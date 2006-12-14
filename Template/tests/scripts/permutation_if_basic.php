<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/if/correct/if_with_comments.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$list = perm( '{',
              clone $comments,
              'if',
              clone $comments,
              '$a',
              clone $comments,
              '}',
              "\n    {\$a}\n{/if}"
              );

$a = app( "if/correct/if_with_comments.in", $argv );

$a->output( "{var \$a = \"foo\"}\n" );
do
{
    $str = $list->generate();
    $a->output( $str . "\n" );
} while ( $list->increase() );

?>
