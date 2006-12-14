<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/array_fetch/correct/comments.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ ) ;

$list = perm( "{\$a[",
              clone $comments,
              '0',
              clone $comments,
              "]}\n"
              );


$a = app( "array_fetch/correct/comments.in", $argv );

$a->output( "{var \$a = array( 0 => 'foo' )}\n" );
$i = 0;
do
{
    $str = $list->generate();
    $a->output( $str );
    ++$i;
} while ( $list->increase() );
$a->close();
$a->store( str_repeat( "foo\n", $i ),
           $a->dir . "/array_fetch/correct/comments.out" );

?>
