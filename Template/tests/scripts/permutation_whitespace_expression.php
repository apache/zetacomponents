<?php

require_once dirname( __FILE__ ) . "/permutation.php";

// Writes to: regression_tests/expressions/correct/whitespace_usage_*.in

$ws = alt( "", " \t", "\n" );
$comment = alt( "/*c*/", "//c\n" );
$wsComment = alt( clone $ws, clone $comment, clone $ws );
$comments = alt( clone $ws, clone $comment/*, clone $wsComment*/ );

$binOperators = alt( "+",
                     "-",
                     "*",
//                     "/",
                     "%",

                     "==",
                     "===",
                     "!=",
                     "!==",
                     "<",
                     "<=",
                     ">",
                     ">=",

                     "&&",
                     "||",

                     "." );

$binOperatorsSlash = alt( "/"
                          );

$bins = perm( "5",
              alt( perm( clone $comments,
                         $binOperators,
                         clone $comments ),
                   perm( clone $comments,
                         $binOperatorsSlash,
                         " ",
                         $comments ) ),
              "5"
              );

$main = perm( "[{",
              $bins,
              "}]\n"
              );

$list = perm( "%num%:",
              $main
              );
$dir = dirname( __FILE__ ) . "/../regression_tests/";

$a = app( "expressions/correct/whitespace_usage_0001.in", $argv );

$i = 1;
$top = "";
$topPHP = "";
$phpCode = array( 1 => '' );
$sendMap = array( 1 => false );

// Invalid cases in PHP:
// 5//*asdf*/5
// 5. 5
// 5 .5

$block = 1;
$a->output( $top );
do
{
    if ( $i > 1 &&
         ( ( $i - 1 ) % 50 ) == 0 )
    {
        $a->close();
        ++$block;
        $num2 = sprintf( "%04d", $block );
        $a->file = "expressions/correct/whitespace_usage_{$num2}.in";
        $phpCode[$block] = '';
        $a->output( $top );
    }
    $num = sprintf( "%04d", $i );
    $str = $list->generate();
    $binText = $bins->generate();

    // Some workarounds for strange PHP behaviour
    $binText = preg_replace( "#5\.([^5])#", "5 .\\1", $binText );
    $binText = preg_replace( "#([^5])\.5#", "\\1. 5", $binText );

    $str = str_replace( "%num%", $num, $str );
    $a->output( $str );
    if ( $main->index == 0 )
    {
        $phpCode[$block] .= ( "\$x = " . $binText . ";\n" .
                              "echo '$num:[', " );
        $phpCode[$block] .= "\$x, \"]\\n\";\n";
    }
    ++$i;
} while ( $list->increase() );
$a->close();

if ( $a->outputToFile )
{
    foreach ( $phpCode as $blockIndex => $phpCodeTmp )
    {
        $num2 = sprintf( "%04d", $blockIndex );

        $fileOut  = $dir . "expressions/correct/whitespace_usage_{$num2}.out";
        $filePHP  = $dir . "expressions/correct/whitespace_usage_{$num2}.php";

        $phpCodeTmp = ( "<?php\n// file: " . "expressions/correct/whitespace_usage.php" . "\n" .
                        $topPHP . $phpCodeTmp .
                        "?>" );
        $tmpFile = $a->store( $phpCodeTmp,
                              $filePHP );
        if ( $tmpFile !== false )
        {
            @system( "php -l $tmpFile >/dev/null", $status );
            if ( $status != 0 )
            {
                throw new Exception( "The generated PHP file $tmpFile contains syntax errors" );
            }

            echo "php $tmpFile > $fileOut\n";
            @exec( "php $tmpFile > $fileOut", $shellOut, $status );
            if ( $status != 0 )
            {
                throw new Exception( "The generated PHP file $tmpFile did not run properly" );
            }
            unlink( $tmpFile );
        }
    }
}

?>
