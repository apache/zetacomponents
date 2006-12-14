<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/switch/correct/switch_nested.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$empty = alt( '' );

function makeCase( $nums )
{
    if ( !is_array( $nums ) )
        $nums = array( $nums );
    $list = array();
    return alt( "{case " . implode( ",", $nums ) . "}\n    {\"{case " . var_export( implode( ",", $nums ), true ) . "}\"}\n{/case}\n" );
}

$switch = perm( "{switch \$_num_1}\n",
                "{/switch}\n"
                );

$switch1 = perm( "{switch \$_num_1}\n",
                 alt( makeCase( '1' ), makeCase( array( '1', '2' ) ) ),
                 "{/switch}\n"
                 );

$switch2 = perm( "{switch \$_num_2}\n",
                 alt( makeCase( '1' ), makeCase( array( '1', '3' ) ) ),
                 alt( makeCase( '2' ), makeCase( array( '2', '3' ) ) ),
                 "{/switch}\n"
                 );


$switchDef = perm( "{switch \$_num_4}\n",
                   alt( makeCase( '1' ), makeCase( array( '1', '3' ) ) ),
                   alt( makeCase( '2' ), makeCase( array( '2', '3' ) ) ),
                   "{default}\n    {\"{default}\"}\n{/default}\n",
                   "{/switch}\n"
                   );

$switchDef2 = perm( "{switch \$_num_3}\n",
                    "{default}\n    {\"{default}\"}\n{/default}\n",
                    "{/switch}\n"
                    );



$switchNested = perm( "{switch \$_num_1}\n",
                      "{case '1'}\n",
                      altI( '    ', clone $switch, clone $switch1, clone $switch2, clone $switchDef, clone $switchDef2 ),
                      "{/case}\n",
                      "{default}\n    {\"{default}\"}\n{/default}\n",
                      "{/switch}\n"
                      );

$list = perm( alt( clone $switch,
                   clone $switch1,
                   clone $switch2,
                   clone $switchDef,
                   clone $switchDef2,
                   clone $switchNested
                   ) );

$a = app( "switch/correct/switch_nested.in", $argv );

$a->output( "{var \$_num_1 = 1, \$_num_2 = 2, \$_num_3 = 3, \$_num_4 = 4}\n" );
do
{
    $str = $list->generate();
    $a->output( $str . "\n" );
} while ( $list->increase() );

?>
