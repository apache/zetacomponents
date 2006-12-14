<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/if/correct/if_nested.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$empty = alt( '' );

$if = perm( "{if \$_foo}",
            "\n    {\$_foo}\n",
            "{/if}\n"
            );

$ifElse = perm( "{if \$_false}",
                "\n    {\$_foo}\n",
                "{else}",
                "\n    {\$_bar}\n",
                "{/if}\n"
                );

$ifElseIf = perm( "{if \$_false}",
                  "\n    {\$_foo}\n",
                  "{elseif \$_true}",
                  "\n    {\$_bar}\n",
                  "{/if}\n"
                  );

$ifElseIfElse = perm( "{if \$_false}",
                      "\n    {\$_foo}\n",
                      "{elseif \$_true}",
                      "\n    {\$_bar}\n",
                      "{else}",
                      "\n    {\$_false}\n",
                      "{/if}\n"
                      );

$ifElseIfElse2 = perm( "{if \$_false}",
                       "\n    {\$_foo}\n",
                       "{elseif \$_true}",
                       "\n    {\$_bar}\n",
                       "{elseif \$_false}",
                       "\n    {\$_bar}\n",
                       "{else}",
                       "\n    {\$_false}\n",
                       "{/if}\n"
                       );

$ifNested = perm( "{if \$_foo}\n",
                  altI( '--->', clone $empty, clone $if, clone $ifElse, clone $ifElseIf, clone $ifElseIfElse, clone $ifElseIfElse2 ),
                  "{/if}\n"
                  );

$ifNested2 = perm( "{if \$_foo}\n",
                   altI( '===>', clone $if, clone $ifElse, clone $ifElseIf, clone $ifElseIfElse, clone $ifElseIfElse2, clone $ifNested ),
                   "{/if}"
                   );

$list = perm( clone $if,
              clone $ifElse,
              clone $ifElseIf,
              clone $ifElseIfElse,
              clone $ifElseIfElse2,
              clone $ifNested2
              );

$a = app( "if/correct/if_nested.in", $argv );

$a->output( "{var \$_foo = \"foo\",\n     \$_bar = \"bar\",\n     \$_false = false,\n     \$_true = true}\n" );
do
{
    $str = $list->generate();
    $a->output( $str . "\n" );
} while ( $list->increase() );

?>
