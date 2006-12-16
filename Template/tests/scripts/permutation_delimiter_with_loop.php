<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/blocks/correct/delimiter_with_loop.in

$loopTypes = altMaster( altSlave( "{foreach 1..10 as \$b}\n",
                                  "{\$b = 1}\n{while \$b <= 10}\n" ),
                        altSlave( "{/foreach}\n",
                                  "  {\$b++}\n{/while}\n" ) );

$list = perm( "{foreach 1..4 as \$a",
              alt( "",
                   " offset 1",
                   " limit 1",
                   " offset 1 limit 1" ),
              "}\n",
              indent( perm( "{\$a}\n",
                            "{delimiter",
                            alt( "",
                                 " modulo 3" ),
                            "}\n",
                            indent( perm( $loopTypes,
                                          "  :{\$b}:\n",
                                          $loopTypes->slaves[1] ),
                                    "  " ),
                            "{/delimiter}\n" ),
                      "  " ),
              "{/foreach}\n",
              "============\n"
              );

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "blocks/correct/delimiter_with_loop.in", $argv );

$i = 1;
$a->output( "{var \$a = 0, \$b = 0}\n" );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $a->output( $str );
//    $a->store( "mock:2:2: Unknown block <{$name}>.\n" .
//               "\n" .
//               "{{$name}}\n" .
//               " ^\n",
//               $fileOut );
    ++$i;
} while ( $list->increase() );
$a->close();

?>
