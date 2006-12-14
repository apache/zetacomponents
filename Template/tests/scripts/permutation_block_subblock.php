<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/foreach/correct/nested_with_delimiter_*.in

$blockStart = altMaster( altSlave( "{\$i = 0}\n{foreach \$foo as \$bar}\n",
                                   "{\$num = 0}{\$i = 0}\n{while \$num<3}\n{\$bar = \$num}\n{\$num++}\n",
                                   "{\$i = 0}\n{if \$foo[1]}\n"
                                   ),
                         altSlave( "{++\$i}\n{/foreach}\n",
                                   "{++\$i}\n{/while}\n",
                                   "{/if}\n"
                                   ) );
$blockEnd   = $blockStart->slaves[1];

$innerBlocks1 = alt( "{delimiter}\n" .
                     "    {\$i}:~~~~delim~~~~\n" .
                     "{/delimiter}\n",

                     "{if \$bar}\n" .
                     "    {\$i}:[if]\$bar is true[/if]\n" .
                     "{else}\n" .
                     "    {\$i}:[if]\$bar is false[/if]\n" .
                     "{/if}\n",

                     "{switch \$bar}\n" .
                     "{case 1}\n" .
                     "    {\$i}:[switch]1[/switch]\n" .
                     "{/case}\n" .
                     "{case 2}\n" .
                     "    {\$i}:[switch]2[/switch]\n" .
                     "{/case}\n" .
                     "{default}\n" .
                     "    {\$i}:[switch]default({\$bar})[/switch]\n" .
                     "{/default}\n" .
                     "{/switch}\n"
                     );

$delimBlocks = alt( "{delimiter}\n" .
                    "    {\$i}:====delim====\n" .
                    "{/delimiter}\n" .
                    "{delimiter modulo 2}\n" .
                    "    {\$i}:____delim____\n" .
                    "{/delimiter}\n"
                    );


$blockStart2 = clone $blockStart;
$blockEnd2   = $blockStart2->slaves[1];
$innerBlocks2 = clone $innerBlocks1;
/*$innerBlocks2->replace( "\$foo", "\$foo2" );
$innerBlocks2->replace( "\$bar", "\$bar2" );
$innerBlocks2->replace( "\$num", "\$num2" );
$innerBlocks2->replace( "{\$i}", "{\$i}:{\$j}" );
$innerBlocks2->replace( "{\$i = 0}", "{\$j = 0}" );
$innerBlocks2->replace( "~~~~delim~~~~", "~~delim~~" );*/

$outerBlocks2 = perm( $blockStart2,
                      indent( perm( $innerBlocks2,
                                    $delimBlocks ),
                              "    " ),
                      $blockEnd2
                      );


$outerBlocks2->replace( "\$foo", "\$foo2" );
$outerBlocks2->replace( "\$bar", "\$bar2" );
$outerBlocks2->replace( "\$num", "\$num2" );
$outerBlocks2->replace( "{\$i}", "{\$i}:{\$j}" );
$outerBlocks2->replace( "{\$i = 0}", "{\$j = 0}" );
$outerBlocks2->replace( "{++\$i}", "{++\$j}" );
$outerBlocks2->replace( "~~~~delim~~~~", "~~delim~~" );

$outerBlocks = perm( "\{%num%\n",
                     "{foreach 1..1 as \$blackhole}\n",
                     indent( perm( $blockStart,
                                   indent( perm( $innerBlocks1,
                                                 $outerBlocks2
//                                                 clone $delimBlocks
                                                 ),
                                           "    " ),
                                   $blockEnd
                                   ),
                             "    " ),
                     "{/foreach}\n",
                     "\}\n"
                     );

$list = perm( $outerBlocks );

$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "", $argv );

$i = 1;
$top = "{var \$foo = array( 0, 1, 3 ), \$foo2 = array( '', 'foo' ), \$bar = 0, \$bar2 = 0, \$num = 0, \$num2 = 0, \$i = 0, \$j = 0}\n";
//$a->output( $top );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $str = str_replace( "%num%", $num, $str );
    $fileIn  = $dir . "foreach/correct/nested_with_delimiter_" . $num . ".in";
//    $fileOut  = $dir . "foreach/correct/nested_with_delimiter_" . $num . ".out";
//    $name = $alternatives->generate();
    $a->store( "{* file: " . "nested_with_delimiter_" . $num . ".in" . " *}\n" . $top . $str,
               $fileIn );
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
//    $a->output( $str );
    ++$i;
} while ( $list->increase() );

?>
