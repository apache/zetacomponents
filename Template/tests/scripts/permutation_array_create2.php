<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/literals/array_create_with_comments2.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$list = perm( 'debug_dump( array',
              '(',
              alt( perm( clone $comments,
                               alt( '0' ),
                               clone $comments ),
                   perm( clone $comments,
                         alt( '0' ),
                         clone $comments,
                         alt( ',' ),
                         clone $comments )
                   ),
//               new ezcTemplatePermutationNumber( 0 ),
              ') )'
              );


$a = app( "literals/array_create_with_comments2.in", $argv );

do
{
    $str = $list->generate();
    $a->output( "{" . $str . "}\n" );
} while ( $list->increase() );

?>
