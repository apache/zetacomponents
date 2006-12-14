<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/if/incorrect/modifying_expression_*.in

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


$modifyingOperators = alt( "=",
                           "+=",
                           "-=",
                           "*=",
                           "/=", // this is handled in a separate test.
                           "%=",
                           ".="
                           );

$mod = perm( "\$foo ",
             $modifyingOperators,
             " 5"
             );

$binRhs = alt( perm( " ( \$bar ",
                     $modifyingOperators,
                     " 5 )" ),
               perm( " \$bar++" ),
               perm( " \$bar--" ),
               perm( " ++\$bar" ),
               perm( " --\$bar" )
               );


$bin = perm( "\$foo ",
             "+ ",
             alt( clone $binRhs,
                  perm( "( ",
                        clone $binRhs,
                        " )" ) )
             );

$ops = alt( $mod,
            $bin );

$main = alt( $ops,
             perm( "( ", $ops, " )" )
             );
$list = perm( "%num%:",
              "{if ",
              $main,
              "}",
              "this should never appear",
              "{/if}\n"
              );

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "", $argv );

$i = 1;
$top = "{var \$foo = 42, \$bar = 101}\n";

do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $fileIn  = $dir . "if/incorrect/modifying_expression_" . $num . ".in";
    $a->store( "{* file: " . "if/incorrect/modifying_expression_" . $num . ".in" . " *}\n" . $top . $str,
               $fileIn );
    ++$i;
} while ( $list->increase() );

?>
