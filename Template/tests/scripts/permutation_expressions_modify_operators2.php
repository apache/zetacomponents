<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/expressions/correct/modifying_array_operators_*.in

$modifyingOperators = alt( "=",
                           "+=",
                           "-=",
                           "*=",
                           "/=", // this is handled in a separate test.
                           "%=",
                           ".="
                           );

$constValues = alt( "5",
                    "-\$foo"
                    );

$modify = perm( "\$arr['foo']",
                " ",
                $modifyingOperators,
                alt( perm( alt( "",
                                perm( " \$arr2['foo']['bar'] ",
                                      clone $modifyingOperators )
                                ),
                           " ",
//                clone $constValues
                           5
                           )/*,
                     alt( " ++\$bar2",
                          " --\$bar2",
                          " \$bar2++",
                          " \$bar2--" )*/
                     )
                );

$modifiers = alt( $modify );

$main = alt( perm( "[{\$arr = \$arr_}{\$arr2 = \$arr2_}{",
                   $modifiers,
                   "}",
                   "{str_number( \$arr['foo'], 5, ',', '' )},{str_number( \$arr2['foo']['bar'], 5, ',', '' )}]\n"
                   )
             );

$list = perm( "%num%:",
              $main
              );

// special tests
// $a == $b == $c (should produce proper PHP code ) => ($a == $b) == $c
// $a = $b = $c (should produce proper PHP code) $a = ($b = $c)

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "expressions/correct/modifying_array_operators.in", $argv );

$objCode = ( "if ( !class_exists( 'ezcTemplateTestModOpMyClass', false ) )\n" .
             "{\n" .
             "  class ezcTemplateTestModOpMyClass\n" .
             "  {\n" .
             "    public \$foo = 301;\n" .
             "  }\n" .
             "}\n" .
             "\$obj = new ezcTemplateTestModOpMyClass();\n" );


$i = 1;
$top = "{var \$foo = 42, \$arr_ = array( 'foo' => 401 ), \$arr2_ = array( 'foo' => array( 'bar' => 501 ) )}\n{var \$arr, \$arr2}\n";
$topPHP = "\$foo = 42; \$arr_ = array( 'foo' => 401 ); \$arr2_ = array( 'foo' => array( 'bar' => 501 ) );\n";
$phpCode = '';

$fileOut  = $dir . "expressions/correct/modifying_array_operators.out";
$filePHP  = $dir . "expressions/correct/modifying_array_operators.php";

$a->output( $top );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $fileIn  = $dir . "expressions/correct/modifying_array_operators_" . $num . ".in";
    $a->output( $str );
    if ( $main->index == 0 )
    {
        $phpCode .= ( "\$arr = \$arr_; \$arr2 = \$arr2_;\n" .
                      $modifiers->generate() . ";\n" .
                      "echo '$num:[', number_format( \$arr['foo'], 5, ',', '' ), ',', number_format( \$arr2['foo']['bar'], 5, ',', '' ), \"]\\n\";\n" );
    }
    ++$i;
} while ( $list->increase() );
$a->close();

if ( $a->outputToFile )
{
    $phpCode = ( "<?php\n// file: " . "expressions/correct/modifying_array_operators.php" . "\n" .
//                 $objCode .
                 $topPHP . $phpCode .
                 "?>" );
    $tmpFile = $a->store( $phpCode,
                          $filePHP );

    if ( $tmpFile !== false )
    {
        @system( "php -l $tmpFile >/dev/null", $status );
        if ( $status != 0 )
        {
            throw new Exception( "The generated PHP file $tmpFile contains syntax errors" );
        }

        echo "php $tmpFile > $fileOut\n";
        @exec( "php $tmpFile > $fileOut", $shellOut, $status );
        if ( $status != 0 )
        {
            throw new Exception( "The generated PHP file $tmpFile did not run properly" );
        }
        unlink( $tmpFile );
    }
}

?>
