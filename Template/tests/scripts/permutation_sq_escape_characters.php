<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/literals/string_sq_escaped_characters.in

$chars = array();
$escChars = array();
for ( $i = 1; $i < 256; ++$i )
{
    $chars[] = chr( $i );
    $escChars[] = "\\" . chr( $i );
}

$allChars = array_merge( $chars, $escChars );

$single = new ezcTemplatePermutationAlternative( $chars );
$escaped = perm( "\\",
                 new ezcTemplatePermutationAlternative( $chars )
                 );

$alt = alt( $single,
            $escaped
            );

$list = perm( $alt
              );

$a = app( "literals/string_sq_escaped_characters.in", $argv );
$outFile = "literals/string_sq_escaped_characters.out";

$i = 0;
$out = '';
$a->output( "{'" );
do
{
    if ( $i > 0 &&
         ( $i % 8 ) == 0 )
    {
        $a->output( "'}\n{'" );
        $out .= "\n";
    }
    if ( isset( $allChars[$i] ) )
    {
        $out .= $allChars[$i];
    }
    $str = $list->generate();
    if ( $alt->index == 0 &&
             $single->generate() == "\\" )
    {
        $str = "\\\\";
    }
    elseif ( $alt->index == 0 &&
             $single->generate() == "'" )
    {
        $str = "\\" . $str;
    }
    elseif ( $alt->index == 1 &&
             $escaped->generate() == "\\'" )
    {
        $str = "\\\\\\'";
    }
    elseif ( $alt->index == 1 &&
             $escaped->generate() == "\\\\" )
    {
        $str = "\\\\\\\\";
    }
    elseif ( $alt->index == 1 &&
             in_array( $escaped->generate(),
                       array( "\\'",
                              "\\\\" )
                        ) )
    {
        $str = "\\" . $str;
    }
    $a->output( $str );
    ++$i;
} while ( $list->increase() );
$a->output( "'}\n" );
$a->close();
$a->store( $out . "\n",
           $a->dir . "/" . $outFile );

?>
