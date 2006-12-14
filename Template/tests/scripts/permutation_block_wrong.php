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
                    "{case 5}",
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

$blocksStart1 = clone $blocksStart;
$blocksEnd1   = clone $blocksEnd;

$blocksStartEnd = perm( $blocksStart1,
                        "\n    {\$foo}\n",
                        $blocksEnd1,
                        "\n"
                        );

$blocksStart2 = clone $blocksStart;
$blocksEnd2   = clone $blocksEnd;

$blocksStartEnd2 = perm( $blocksStart2,
                         "\n    {\$foo}\n",
                         $blocksEnd2,
                         "\n"
                         );

$blocksNested = alt( perm( "{foreach \$array as \$bar}\n",
                           altI( '    ', $blocksStartEnd2 ),
                           "{/foreach}\n"
                           ) );

$alt = alt( $blocksStartEnd,
            $blocksNested
            );

$list = perm( $alt
              );

$dir = dirname( __FILE__ ) . "/../regression_tests/blocks/incorrect/";

$a = app( "", $argv, $dir );

$i = 1;
$top = "{var \$foo = 1, \$_false = false, \$array = array( 1, 2 )}\n";
if ( !$a->outputToFile )
{
    echo $top;
}

$inCount  = 0;
$outCount = 0;

do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $inFile  = $dir . "/non_matching_block_" . $num . ".in";
    $outFile = $dir . "/non_matching_block_" . $num . ".out";
    $useEntry = false;

    // Check for valid entries.
    if ( $alt->index == 0 )
    {
        $start = $startText = $blocksStart1->generate();
        $end   = $endText   = $blocksEnd1->generate();
    }
    elseif ( $alt->index == 1 )
    {
        $start = $startText = $blocksStart2->generate();
        $end   = $endText   = $blocksEnd2->generate();
//        echo "s:{$start}:s\n";
//        echo "e:{$end}:e\n";
    }
    else
    {
        throw new Exception( "Unknown index {$alt->index}" );
    }

    if ( preg_match( "#^{/?([a-zA-Z0-9_]+)#", $start, $matches ) )
    {
        $start = $matches[1];
    }
    if ( preg_match( "#^{/?([a-zA-Z0-9_]+)#", $end, $matches ) )
    {
        $end = $matches[1];
    }
    if ( strcmp( $start, $end ) == 0 )
    {
        // Some exceptions
        if ( $start == 'delimiter' ||
             $start == 'switch' ||
             $start == 'case' ||
             $start == 'default' )
        {
//            $useEntry = true;
        }
        else
        {
//            echo "same\n";
        }
    }
    else
    {
        $useEntry = true;
    }

    if ( $useEntry )
    {
        $a->store( "{* file: " . "non_matching_block_" . $num . ".in" . " *}\n" . $top . $str . "\n",
                   $inFile );
        ++$inCount;

        if ( $alt->index == 0 )
        {
            // Special case 1
            if ( $start == 'delimiter' )
            {
                $len = strlen( $startText );
                $name = ucfirst( $start );
                $a->store( "mock:3:{$len}: Delimiter can only be used inside a foreach block.\n" .
                           "\n" .
                           "{$startText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 2
            elseif ( $start == 'elseif' ||
                     $start == 'else' )
            {
                $len = strlen( $start ) + 1 + 1;
                $a->store( "mock:3:{$len}: Unexpected block {{$start}} at this position. Some blocks can only be used inside other blocks.\n" .
                           "\n" .
                           "{$startText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 3
            elseif ( $start == 'switch' )
            {
                $a->store( "mock:4:5: Expecting an case block.\n" .
                           "\n" .
                           "    {\$foo}\n" .
                           "    ^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 4
            elseif ( $start == 'case' ||
                     $start == 'default' )
            {
                if ( $end == "aaa" )
                {
//                $len = strlen( $startText ) + 1;
                $a->store( /*"mock:3:7: Expecting a literal.\n" .
                           "\n" .
                           "{case 5}\n" .
                           "      ^\n",*/
                    "Incorrect nesting in code, close block {/{$start}} expected.\n" .
                    "\n" .
                    "    {\$foo}\n" .
                    "\n" .
                    "\n" .
                    "\n" .
                    "^\n",
                    /*"mock:3:{$len}: Unexpected block {{$start}} at this position. Some blocks can only be used inside other blocks.\n" .
                           "\n" .
                           "{$startText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",*/
                           $outFile );
                }
                else
                {
                    $len = strlen( $start ) + 1 + 1;
                    $a->store( "mock:3:{$len}: Unexpected block {{$start}} at this position. Some blocks can only be used inside other blocks.\n" .
                               "\n" .
                               "{$startText}\n" .
                               str_repeat( " ", $len - 1 ) . "^\n",
                               $outFile );
                }
                ++$outCount;
            }
            elseif ( $start == '' )
            {
                $len = strlen( $endText ) + 1;
                $a->store( "mock:5:{$len}: Found closing block {/{$end}} without an opening block.\n" .
                           "\n" .
                           "{$endText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",
                           $outFile );
                ++$outCount;
            }
            elseif ( $end == '' )
            {
                $a->store( "mock:7:1: Incorrect nesting in code, close block {/{$start}} expected.\n" .
                           "\n" .
                           "    {\$foo}\n" .
                           "\n" .
                           "\n" .
                           "\n" .
                           "^\n",
                           $outFile );
                ++$outCount;
            }
            else
            {
                $len = strlen( $endText ) + 1;
                $a->store( "mock:5:{$len}: Open and close block do not match: {{$start}} and {/{$end}}\n" .
                           "\n" .
                           "{$endText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",
                           $outFile );
                ++$outCount;
            }
        }
        elseif ( $alt->index == 1 )
        {
            // Special case 1
            if ( $start == '' &&
                 $end   == 'foreach' )
            {
                $a->store( "mock:7:11: Found closing block {/foreach} without an opening block.\n" .
                           "\n" .
                           "{/foreach}\n" .
                           "          ^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 2
            elseif ( $start == 'foreach' &&
                     $end   == '' )
            {
                // TODO: consider better error message for this one since EOF
                //       is reached and there is a block still open
                $a->store( "mock:9:1: Incorrect nesting in code, close block {/foreach} expected.\n" .
                           "\n" .
                           "{/foreach}\n" .
                           "\n" .
                           "\n" .
                           "^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 3
            elseif ( $start == 'elseif' ||
                     $start == 'else' )
            {
                $len = strlen( $start ) + 1 + 1 + 4; // 4 is for the identation
                $a->store( "mock:3:{$len}: Unexpected block {{$start}} at this position. Some blocks can only be used inside other blocks.\n" .
                           "\n" .
                           "    {$startText}\n" .
                           str_repeat( " ", $len - 1 ) . "^\n",
                           $outFile );
                ++$outCount;
            }
            // Special case 4
            elseif ( $start == 'switch' )
            {
                $a->store( "mock:5:9: Expecting an case block.\n" .
                           "\n" .
                           "        {\$foo}\n" .
                           "        ^\n",
                           $outFile );
                ++$outCount;
            }
            elseif ( $start == '' )
            {
                $len = strlen( $endText ) + 4 + 1; // 4 is for the indentation
                $a->store( "mock:6:{$len}: Open and close block do not match: {foreach} and {/{$end}}\n" .
                           "\n" .
                           "    {$endText}\n" .
                           str_repeat( " ", $len - 1 ) .  "^\n",
                           $outFile );
                ++$outCount;
            }
            elseif ( $end == '' )
            {
                // Matches hardcoded {/foreach} so the text is nearly static
                $a->store( "mock:7:11: Open and close block do not match: {{$start}} and {/foreach}\n" .
                           "\n" .
                           "{/foreach}\n" .
                           "          ^\n",
                           $outFile );
                ++$outCount;
            }
            else
            {
                $len = strlen( $endText ) + 4 + 1; // 4 is for the indentation
                $a->store( "mock:6:{$len}: Open and close block do not match: {{$start}} and {/{$end}}\n" .
                           "\n" .
                           "    {$endText}\n" .
                           str_repeat( " ", $len - 1 ) .  "^\n",
                           $outFile );
                ++$outCount;
            }
        }
    }
    ++$i;
} while ( $list->increase() );

if ( $inCount != $outCount )
{
    throw new Exception( ".in count ({$inCount}) does not match .out count ({$outCount})" );
}

?>
