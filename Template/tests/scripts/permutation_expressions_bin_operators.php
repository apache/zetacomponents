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

$constValues = alt( "5",
                    "-\$foo"
                    );

$bin = perm( clone $constValues,
             " ",
             clone $binOperators,
             " ",
             clone $constValues );

$object = perm( "\$obj",
                " ",
                $objectOperators,
                " ",
                "foo"
                );

$array = perm( "\$arr['foo']"
               );

$bin2 = perm( //clone $constValues,
              "\$foo",
              " ",
              clone $binOperators,
              " ",
//              clone $constValues
              5
              );

$comboLeft = alt( clone $bin2,
                  $object,
                  $array );

$binCombination = perm( alt( "( ",
                             "!( " ),
                        $comboLeft,
                        " ) ",
                        clone $binOperators,
                        " ",
                        clone $constValues
//                     clone $bin2
                        );

$bins = alt( $bin,
             $binCombination
             );

$main = alt( perm( "[{debug_dump( ",
                   $bins,
                   " )}]\n" )
             );

$list = perm( "%num%:",
              $main
              );

// special tests
// $a == $b == $c (should produce proper PHP code ) => ($a == $b) == $c
// $a = $b = $c (should produce proper PHP code) $a = ($b = $c)

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "expressions/correct/binary_operators_0001.in", $argv );

$objCode = ( "if ( !class_exists( 'ezcTemplateTestBinOpMyClass', false ) )\n" .
             "{\n" .
             "  class ezcTemplateTestBinOpMyClass\n" .
             "  {\n" .
             "    public \$foo = 301;\n" .
             "  }\n" .
             "}\n" .
             "\$obj = new ezcTemplateTestBinOpMyClass();\n" );
$objCodeSend = ( $objCode .
                 "\$v = new ezcTemplateVariableCollection();\n" .
                 "\$v->obj = \$obj;\n" .
                 "return \$v;\n" );


$i = 1;
$topObj = "{use \$obj}\n";
$top = "{var \$foo = 42, \$bar = 101, \$bar2 = 201, \$arr = array( 'foo' => 401 )}\n";
$topPHP = "\$foo = 42; \$bar = 101; \$bar2 = 201; \$arr = array( 'foo' => 401 );\n";
$phpCode = array( 1 => '' );
$sendMap = array( 1 => false );

$block = 1;
$a->output( $top );
do
{
    if ( $i > 1 &&
         ( ( $i - 1 ) % 32 ) == 0 )
    {
        $a->close();
        ++$block;
        $sendMap[$block] = $comboLeft->index == 1;
        $needUse = $sendMap[$block];
        $num2 = sprintf( "%04d", $block );
        $a->file = "expressions/correct/binary_operators_{$num2}.in";
        $phpCode[$block] = '';
        if ( $needUse )
        {
            $a->output( $topObj );
        }
        $a->output( $top );
    }
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $a->output( $str );
    if ( $main->index == 0 )
    {
        $phpCode[$block] .= ( "\$x = " . $bins->generate() . ";\n" .
                              "echo '$num:[', var_export( \$x, true ), \"]\\n\";\n" );
    }
    ++$i;
} while( $list->increase() );
$a->close();

if ( $a->outputToFile )
{
    foreach ( $phpCode as $blockIndex => $phpCodeTmp )
    {
        $num2 = sprintf( "%04d", $blockIndex );

        $fileOut  = $dir . "expressions/correct/binary_operators_{$num2}.out";
        $filePHP  = $dir . "expressions/correct/binary_operators_{$num2}.php";
        $fileSend = $dir . "expressions/correct/binary_operators_{$num2}.send";

        if ( $sendMap[$blockIndex] )
        {
            //$comboLeft
            $a->store( "<?php\n" .
                       $objCodeSend . "\n?>",
                       $fileSend );
        }
        $phpCodeTmp = ( "<?php\n// file: " . "expressions/correct/binary_operators.php" . "\n" .
                     $objCode .
                     $topPHP . $phpCodeTmp .
                     "?>" );
        $tmpFile = $a->store( $phpCodeTmp,
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
}

?>
