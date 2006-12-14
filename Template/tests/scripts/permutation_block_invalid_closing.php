<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/blocks/incorrect/block_invalid_closing_*.in

$singleBlockNames = alt( "var",
                         "cycle",
                         "use",
                         "increment",
                         "decrement",
                         "reset",
                         "return",
                         "break",
                         "skip",
                         "continue",
                         "else",
                         "elseif",
                         "include",
                         "ldelim",
                         "rdelim"
                         );

$nestedBlockNames = alt( "foreach",
                         "while",
                         "if",
                         "switch",
                         "case",
                         "default",
                         "delimiter",
                         "literal"
                         );
$otherNames = alt( "tru",
                   "fals",
                   "ray"
                   );

$alts = alt( $singleBlockNames,
             $nestedBlockNames,
             $otherNames
             );

$data = alt( "",
             " \$foo" );

$lineStart = perm( "{/",
                   $alts );

$line = perm( $lineStart,
              $data,
              "}" );

$list = perm( $line,
              "\n"
              );

$a = app( "", $argv );
$dir = $a->dir;

$i = 1;
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $fileIn  = $dir . "/blocks/incorrect/block_invalid_closing_" . $num . ".in";
    $fileOut = $dir . "/blocks/incorrect/block_invalid_closing_" . $num . ".out";
    $name = $alts->generate();
    $a->store( "{* file: " . "block_invalid_closing_" . $num . ".in" . " *}\n{var \$foo = \"T42p\"}\n" . $str . "\n",
               $fileIn );
    if ( $alts->index == 0 )
    {
        $dataText = $data->generate();
        $a->store( "mock:3:2: This block cannot be closed.\n" .
                   "\n" .
                   "{/{$name}{$dataText}}\n" .
                   " ^\n",
                   $fileOut );
    }
    elseif ( $alts->index == 1 )
    {
        $lineText = $line->generate();
        if ( $data->index == 0 )
        {
            $offset = strlen( $line->generate() ) + 1;
            $a->store( "mock:3:{$offset}: Found closing block {/{$name}} without an opening block.\n" .
                       "\n" .
                       "{$lineText}\n" .
                       str_repeat( " ", $offset - 1 ) . "^\n",
                       $fileOut );
        }
        else
        {
            $offset = strlen( $lineStart->generate() ) + 2;
            $a->store( "mock:3:{$offset}: Expecting a closing curly bracket: '}'\n" .
                       "\n" .
                       "{$lineText}\n" .
                       str_repeat( " ", $offset - 1 ) . "^\n",
                       $fileOut );
        }
    }
    elseif ( $alts->index == 2 )
    {
        $dataText = $data->generate();
        $a->store( "mock:3:3: Unknown block <{$name}>.\n" .
                   "\n" .
                   "{/{$name}{$dataText}}\n" .
                   "  ^\n",
                   $fileOut );
    }
    /*mock:3:3: Unknown block <tru>.

{/tru}
  ^
*/
    /*mock:3:11: Found closing block {/foreach} without an opening block.

{/foreach}
          ^*/
    ++$i;
} while ( $list->increase() );

?>
