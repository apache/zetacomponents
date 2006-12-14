<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/expressions/correct/binary_operators_*.in

$binOperators = alt( "+",
                     "-",
                     "*",
                     "/",
                     "%",

                     "==",
                     "===",
                     "!=",
                     "!==",
                     "<",
                     "<=",
                     ">",
                     ">=",

                     "&&",
                     "||",

                     "." );

$objectOperators = alt( "->" );
//"["

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

$bin = perm( clone $constValues,
             " ",
             clone $binOperators,
             " ",
             clone $constValues );

$modify = perm( "\$bar",
                " ",
                $modifyingOperators,
                alt( "",
                     perm( " \$bar2 ",
                           clone $modifyingOperators ) ),
                " ",
//                clone $constValues
                5
                );

$object = perm( "\$obj",
                " ",
                $objectOperators,
                " ",
                "foo"
                );

$array = perm( "\$arr['foo']"
               );

$bin2 = perm( // clone $constValues,
              "\$foo",
              " ",
              clone $binOperators,
              " ",
//              clone $constValues
              5
              );

$instanceOf = perm( // clone $constValues,
                    "\$foo",
                    " ",
                    "instanceof",
                    " ",
//              clone $constValues
                    "'bar'"
                    );

$binCombination = perm( alt( "( ",
                             "!( " ),
                        alt( clone $bin2,
                             $object,
                             $array ),
                        " ) ",
                        clone $binOperators,
                        " ",
                        clone $constValues
//                     clone $bin2
                        );

$bins = alt( $bin,
             $binCombination//,
//             $object
             );

$modifiers = alt( $modify );

$main = alt( perm( "[{debug_dump( ",
                   $bins,
                   " )}]\n" ),
             perm( "[{\$bar = 101}{\$bar2 = 201}{",
                   $modifiers,
                   "}",
                   "{debug_dump( \$bar )},{debug_dump( \$bar2 )}]\n"
                   )/*,
             perm( "[{",
                   $modifiersDiv,
                   "}",
                   "{debug_dump( \$bar )},{debug_dump( \$bar2 )}]\n"
                   )*/
             );

$list = perm( "%num%:",
              $main
              );

// special tests
// $a == $b == $c (should produce proper PHP code ) => ($a == $b) == $c
// $a = $b = $c (should produce proper PHP code) $a = ($b = $c)

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "expressions/correct/binary_operators.in", $argv );

$objCode = ( "if ( !class_exists( 'ezcTemplateTestExprMyClass', false ) )\n" .
             "{\n" .
             "  class ezcTemplateTestExprMyClass\n" .
             "  {\n" .
             "    public \$foo = 301;\n" .
             "  }\n" .
             "}\n" .
             "\$obj = new ezcTemplateTestExprMyClass();\n" );
$objCodeSend = ( $objCode .
                 "\$v = new ezcTemplateVariableCollection();\n" .
                 "\$v->obj = \$obj;\n" .
                 "return \$v;\n" );


$i = 1;
$top = "{use \$obj}\n{var \$foo = 42, \$bar = 101, \$bar2 = 201, \$arr = array( 'foo' => 401 )}\n";
$topPHP = "\$foo = 42; \$bar = 101; \$bar2 = 201; \$arr = array( 'foo' => 401 );\n";
$phpCode = '';

$fileOut  = $dir . "expressions/correct/binary_operators.out";
$filePHP  = $dir . "expressions/correct/binary_operators.php";
$fileSend = $dir . "expressions/correct/binary_operators.send";

$a->output( $top );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $fileIn  = $dir . "expressions/correct/binary_operators_" . $num . ".in";
//    $fileOut  = $dir . "expressions/correct/nested_with_delimiter_" . $num . ".out";
//    $filePHP  = $dir . "expressions/correct/nested_with_delimiter_" . $num . ".php";
//    $name = $alternatives->generate();
    $a->output( $str );
/*    $a->store( "{* file: " . "expressions/correct/binary_operators_" . $num . ".in" . " *}\n" . $top . $str,
               $fileIn );*/
/*    $inner2Delimiter = '';
    $inner2 = '';
    if ( $innerBlocks2->index == 0 )
    {
        $inner2Delimiter = ( "{}:~~delim~~\n" .
                             "{$i}:====delim====\n" );
        $inner2 = '';
    }
    implode( $inner2Delimiter, array_pad( array(), 2 - 1, $inner2 );
    $a->store( "{* file: " . "nested_with_delimiter_" . $num . ".out" . " *}\n" . $out,
               $fileOut );*/
    if ( $main->index == 0 )
    {
        $phpCode .= ( "\$x = " . $bins->generate() . ";\n" .
                      "echo '$num:[', var_export( \$x, true ), \"]\\n\";\n" );
    }
    elseif ( $main->index == 1 )
    {
        $phpCode .= ( "\$bar = 101; \$bar2 = 201;\n" .
                      $modifiers->generate() . ";\n" .
                      "echo '$num:[', var_export( \$bar, true ), ',', var_export( \$bar2, true ), \"]\\n\";\n" );
    }
    ++$i;
} while ( $list->increase() );
$a->close();

if ( $a->outputToFile )
{
    $a->store( "<?php\n" .
               $objCodeSend . "\n?>",
               $fileSend );

    $phpCode = ( "<?php\n// file: " . "expressions/correct/binary_operators.php" . "\n" .
                 $objCode .
                 $topPHP . $phpCode .
                 "?>" );
    $tmpFile = $a->store( $phpCode,
                          $filePHP );

    if ( $tmpFile !== false )
    {
        @system( "php -l $tmpFile >/dev/null", $status );
//    echo $status == 0 ? "OK" : "FAILED", "\n";
        if ( $status != 0 )
        {
            throw new Exception( "The generated PHP file $tmpFile contains syntax errors" );
        }

        echo "php $tmpFile > $fileOut\n";
        @exec( "php $tmpFile > $fileOut", $shellOut, $status );
//    echo $status == 0 ? "OK" : "FAILED", "\n";
        if ( $status != 0 )
        {
            throw new Exception( "The generated PHP file $tmpFile did not run properly" );
        }
//    $out = $shellOut;
//    echo $out, "\n";
//    $a->store( "{* file: " . "nested_with_delimiter_" . $num . ".out" . " *}\n" . $out,
//               $fileOut );*/
        sleep( 5 );
        unlink( $tmpFile );
    }
}

?>
