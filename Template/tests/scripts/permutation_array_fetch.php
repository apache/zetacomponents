<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/array_fetch/correct/indexes.in

$ws = alt( "", " ", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ ) ;

$indexPre = perm( "[1]",
                  clone $comments,
                  "[]",
                  clone $comments );

$indexPost = perm( "[2]" );

$entry1 = alt( "",
               perm( clone $comments,
                     "[1]" ),
               perm( "[1]",
                     clone $comments,
                     "[2]" ),
               perm( $indexPre,
                     $indexPost )
               );

$var = perm( "{\$a[0]" );

$fetch = perm( $var,
               $entry1,
               "}"
               );

$list = perm( $fetch,
              "\n"
              );


$a = app( "array_fetch/correct/indexes.in", $argv );

$top = "{var \$a = array( 0 => array( 1 => array( 2 => 'foo' ) ) )}\n";
$a->output( $top );
$i = 1;
$out = '';
$map = array( 0 => "Array\n",
              1 => "Array\n",
              2 => "foo\n",
              3 => '' );
do
{
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    if ( $entry1->index == 3 )
    {
        $a->store( "{* file: indexes_{$num}.in *}\n" . $top . $str,
                   $a->dir . "/array_fetch/incorrect/indexes_{$num}.in" );
/*        $text = $fetch->generate();
        $len = strlen( $text );
        $a->store( "mock:3:{$len}: Unexpected array append '[]'. Did you forget an expresssion between the brackets?\n" .
                   "\n" .
                   "{$text}\n" .
                   str_repeat( " ", ezcTemplatePermutation::column( $var->generate() . $indexPre->generate() ) ) . "^\n",
                   $a->dir . "/array_fetch/incorrect/indexes_{$num}.out" );*/
    }
    else
    {
        $a->output( $str );
    }
    $out .= $map[$entry1->index];
    ++$i;
} while ( $list->increase() );
$a->close();
$a->store( $out,
           $a->dir . "/array_fetch/correct/indexes.out" );

?>
