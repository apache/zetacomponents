<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/array_append/append_with_comments.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ ) ;

$list = perm( alt( '$a' ),
              clone $comments,
              alt( '[' ),
              clone $comments,
              alt( ']' ),
              clone $comments,
              alt( '=1' )
              );


$a = app( "array_append/append_with_comments.in", $argv );

$a->output( "{var \$a = array( 0 )}\n" );
do
{
    $str = $list->generate();
    $a->output( "{" . $str . "}\n" );
} while ( $list->increase() );
$a->output( "{debug_dump( \$a )}\n" );

?>
