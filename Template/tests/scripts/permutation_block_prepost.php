<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/blocks/incorrect/block_mangled_pre_post_*.in

$preText = alt( "a",
                "_"
                );
$blockNames = alt( "var",
                   "cycle",
                   "use",
                   "increment",
                   "decrement",
                   "reset",
                   "return",
                   "break",
                   "skip",
                   "continue",
                   "foreach",
                   "while",
                   "if",
                   "elseif",
                   "switch",
                   "case",
                   "default",
                   "include",
                   "delimiter",
                   "literal",
                   "ldelim",
                   "rdelim",
                   "true",
                   "false",
                   "array"
                   );

/*$blocksStartEnd = perm( $blocksStart,
                        "\n    {\$foo}\n",
                        $blocksEnd,
                        "\n"
                        );

$blocksNested = alt( perm( "{foreach \$array as \$bar}\n",
                           altI( '    ', clone $blocksStartEnd ),
                           "{/foreach}\n"
                           ) );*/

$preList = perm( clone $blockNames,
                 clone $preText
                 );

$postList = perm( clone $preText,
                  clone $blockNames
                  );

$prePostList = perm( clone $preText,
                     clone $blockNames,
                     clone $preText
                     );
/*
mock:2:2: Unknown block <var_>.

{var_}
 ^
*/

$alternatives = alt( $preList, $postList, $prePostList );

$list = perm( "{",
              $alternatives,
              "}\n"
              );

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "", $argv );

$i = 1;
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $fileIn  = $dir . "blocks/incorrect/block_mangled_pre_post_" . $num . ".in";
    $fileOut = $dir . "blocks/incorrect/block_mangled_pre_post_" . $num . ".out";
    $name = $alternatives->generate();
    $a->store( "{* file: " . "non_matching_block_" . $num . ".in" . " *}\n" . $str . "\n",
               $fileIn );
    $a->store( "mock:2:2: Unknown block <{$name}>.\n" .
               "\n" .
               "{{$name}}\n" .
               " ^\n",
               $fileOut );
    ++$i;
} while ( $list->increase() );

?>
