<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/literals/array_create_with_comments.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$list = perm( 'debug_dump( array',
              clone $comments,
              '(',
              clone $comments,
              '0',
              clone $comments,
              ') )'
              );

$a = app( "literals/array_create_with_comments.in", $argv );

do
{
    $str = $list->generate();
    $a->output( "{" . $str . "}\n" );
} while ( $list->increase() );

?>
