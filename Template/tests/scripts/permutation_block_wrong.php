<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/blocks/incorrect/non_matching_block_*.in

$blocksStart = alt( "",
                    "{foreach \$array as \$bar}",
                    "{while \$_false}",
                    "{delimiter}",
                    "{if \$foo}",
                    "{elseif \$foo}",
                    "{else}",
                    "{switch \$foo}",
                    "{case \$foo}",
                    "{default}"
                    );
$blocksEnd = alt( "",
                  "{/foreach}",
                  "{/while}",
                  "{/delimiter}",
                  "{/if}",
                  "{/switch}",
                  "{/case}",
                  "{/default}"
                  );

$blocksStartEnd = perm( $blocksStart,
                        "\n    {\$foo}\n",
                        $blocksEnd,
                        "\n"
                        );

$blocksNested = alt( perm( "{foreach \$array as \$bar}\n",
                           altI( '    ', clone $blocksStartEnd ),
                           "{/foreach}\n"
                           ) );

$list = perm( alt( clone $blocksStartEnd,
                   clone $blocksNested
                   )
               );

$dir = dirname( __FILE__ ) . "/regression_tests/blocks/incorrect/";

$a = app( "", $argv, $dir );

$i = 1;
$top = "{var \$foo = 1, \$_false = false, \$array = array( 1, 2 )}\n";
if ( !$a->outputToFile )
{
    echo $top;
}

do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $file = $dir . "/non_matching_block_" . $num . ".in";
    $a->store( "{* file: " . "non_matching_block_" . $num . ".in" . " *}\n" . $top . $str . "\n",
               $file );
    ++$i;
} while( $list->increase() );

?>
