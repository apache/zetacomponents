<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/if/correct/if_else_elseif_nested.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$empty = alt( '' );

$if = perm( "if(%cnt%)\n{if \$_true}",
            "\n    ok(%cnt%)\n",
            "{/if}/if(%cnt%)\n"
            );

$if2 = perm( "if(%cnt%)\n{if \$_false}",
             "\n    fail(%cnt%)\n",
             "{/if}ok(%cnt%)\n/if(%cnt%)\n"
             );

$ifElse = perm( "if(%cnt%)\n{if \$_true}",
                "\n    ok(%cnt%)\n",
                "{else}",
                "\n    fail(%cnt%)\n",
                "{/if}/if(%cnt%)\n"
                );

$ifElse2 = perm( "if(%cnt%)\n{if \$_false}",
                 "\n    fail(%cnt%)\n",
                 "{else}",
                 "\n    ok(%cnt%)\n",
                 "{/if}/if(%cnt%)\n"
                 );

$ifElseIf = perm( "if(%cnt%)\n{if \$_true}",
                  "\n    ok(%cnt%)\n",
                  "{elseif \$_false}",
                  "\n    fail(%cnt%)\n",
                  "{/if}/if(%cnt%)\n"
                  );

$ifElseIf2 = perm( "if(%cnt%)\n{if \$_false}",
                   "\n    fail(%cnt%)\n",
                   "{elseif \$_true}",
                   "\n    ok(%cnt%)\n",
                   "{/if}/if(%cnt%)\n"
                   );

$ifElseIf3 = perm( "if(%cnt%)\n{if \$_false}",
                   "\n    fail(%cnt%)\n",
                   "{elseif \$_false}",
                   "\n    fail(%cnt%)\n",
                   "{/if}ok(%cnt%)\n/if(%cnt%)\n"
                   );

$ifElseIfElse = perm( "if(%cnt%)\n{if \$_true}",
                      "\n    ok(%cnt%)\n",
                      "{elseif \$_false}",
                      "\n    fail(%cnt%)\n",
                      "{else}",
                      "\n    fail(%cnt%)\n",
                      "{/if}/if(%cnt%)\n"
                      );

$ifElseIfElse2 = perm( "if(%cnt%)\n{if \$_false}",
                       "\n    fail(%cnt%)\n",
                       "{elseif \$_true}",
                       "\n    ok(%cnt%)\n",
                       "{else}",
                       "\n    fail(%cnt%)\n",
                       "{/if}/if(%cnt%)\n"
                       );

$ifElseIfElse3 = perm( "if(%cnt%)\n{if \$_false}",
                       "\n    fail(%cnt%)\n",
                       "{elseif \$_false}",
                       "\n    fail(%cnt%)\n",
                       "{else}",
                       "\n    ok(%cnt%)\n",
                       "{/if}/if(%cnt%)\n"
                       );

$ifNested = perm( "if(%cnt%)\n{if \$_true}\n",
                  altI( '    ', /*clone $empty, */clone $if, clone $ifElse, clone $ifElseIf, clone $ifElseIfElse, clone $ifElseIfElse2 ),
                  "{/if}/if(%cnt%)\n"
                  );

$ifNested2 = perm( "{if \$_true}\n",
                   alt( '===>', clone $if, clone $ifElse, clone $ifElseIf, clone $ifElseIfElse, clone $ifElseIfElse2, clone $ifNested ),
                   "{/if}"
                   );

$list = perm( alt( clone $if,
                   clone $if2,
                   clone $ifElse,
                   clone $ifElse2,
                   clone $ifElseIf,
                   clone $ifElseIf2,
                   clone $ifElseIf3,
                   clone $ifElseIfElse,
                   clone $ifElseIfElse2,
                   clone $ifElseIfElse3,
                   clone $ifNested
                   )
              );

$a = app( "if/correct/if_else_elseif_nested.in", $argv );

$a->output( "{var \$_false = false,\n     \$_true = true}\n" );
$i = 0;
do
{
    $str = $list->generate();
    $a->output( str_replace( "%cnt%", $i, $str ) . "\n" );
    ++$i;
} while ( $list->increase() );

?>
