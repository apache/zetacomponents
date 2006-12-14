<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/literals/array_create_with_comments3.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$list = perm( 'debug_dump( array',
              '(',
              alt( perm( clone $comments,
                         '0',
                         clone $comments,
                         ',',
                         clone $comments,
                         '1',
                         clone $comments ) ),
//               new ezcTemplatePermutationNumber( 0 ),
              ') )'
              );

$a = app( "literals/array_create_with_comments3.in", $argv );

do
{
    $str = $list->generate();
    $a->output( "{" . $str . "}\n" );
} while ( $list->increase() );

?>
