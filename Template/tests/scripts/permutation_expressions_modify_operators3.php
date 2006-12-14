<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/expressions/correct/modifying_property_operators_*.in

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

$modify = perm( "\$obj->prop1",
                " ",
                $modifyingOperators,
                alt( perm( alt( "",
                                perm( " \$obj->subprop->prop2 ",
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

$main = alt( perm( "[{\$obj->prop1 = \$objval1}{\$obj->subprop->prop2 = \$objval2}{",
                   $modifiers,
                   "}",
                   "{str_number( \$obj->prop1, 5, ',', '' )},{str_number( \$obj->subprop->prop2, 5, ',', '' )}]\n"
                   )
             );

$list = perm( "%num%:",
              $main
              );

// special tests
// $a == $b == $c (should produce proper PHP code ) => ($a == $b) == $c
// $a = $b = $c (should produce proper PHP code) $a = ($b = $c)

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "expressions/correct/modifying_property_operators.in", $argv );

$objCode = ( "if ( !class_exists( 'ezcTemplateTestModObjOpMySubClass', false ) )\n" .
             "{\n" .
             "  class ezcTemplateTestModObjOpMySubClass\n" .
             "  {\n" .
             "    public \$prop2 = 501;\n" .
             "  }\n" .
             "}\n" .
             "if ( !class_exists( 'ezcTemplateTestModObjOpMyClass', false ) )\n" .
             "{\n" .
             "  class ezcTemplateTestModObjOpMyClass\n" .
             "  {\n" .
             "    public \$prop1 = 401;\n" .
             "    public \$subprop;\n" .
             "    public function __construct()\n" .
             "    {\n" .
             "      \$this->subprop = new ezcTemplateTestModObjOpMySubClass();\n" .
             "    }\n" .
             "  }\n" .
             "}\n" .
             "\$obj = new ezcTemplateTestModObjOpMyClass();\n" );
$objCodeSend = ( $objCode .
                 "\$v = new ezcTemplateVariableCollection();\n" .
                 "\$v->obj = \$obj;\n" .
                 "return \$v;\n" );


$i = 1;
$top = "{use \$obj}\n{var \$foo = 42, \$objval1 = 401, \$objval2 = 501}\n";
$topPHP = "\$foo = 42; \$objval1 = 401; \$objval2 = 501;\n";
$phpCode = '';

$fileOut  = $dir . "expressions/correct/modifying_property_operators.out";
$filePHP  = $dir . "expressions/correct/modifying_property_operators.php";
$fileSend  = $dir . "expressions/correct/modifying_property_operators.send";

$a->output( $top );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $fileIn  = $dir . "expressions/correct/modifying_property_operators_" . $num . ".in";
    $a->output( $str );
    if ( $main->index == 0 )
    {
        $phpCode .= ( "\$obj->prop1 = \$objval1; \$obj->subprop->prop2 = \$objval2;\n" .
                      $modifiers->generate() . ";\n" .
                      "echo '$num:[', number_format( \$obj->prop1, 5, ',', '' ), ',', number_format( \$obj->subprop->prop2, 5, ',', '' ), \"]\\n\";\n" );
    }
    ++$i;
} while ( $list->increase() );
$a->close();

if ( $a->outputToFile )
{
    $phpCode = ( "<?php\n// file: " . "expressions/correct/modifying_property_operators.php" . "\n" .
                 $objCode .
                 $topPHP . $phpCode .
                 "?>" );
    $a->store( "<?php\n" .
               $objCodeSend . "\n" .
               "?>",
               $fileSend );
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
