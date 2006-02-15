<?php
/**
 * File containing example of using ezcPhpGenerator
 * @package PhpGenerator
 */

$generator = new ezcPhpGenerator( "~/file.php" );
$generator->appendCodePiece( "function fibonacci( $number )" );
$generator->appendCodePiece( "{" );

$generator->appendVariable( "lo", 1 );
$generator->appendVariable( "hi", 1 );
$generator->appendVariable( "i", 2 );

$generator->appendWhile( '$i < $number' );
$generator->appendVariable( "hi", "$lo + $hi" );
$generator->appendVariable( "lo", "$hi - $lo" );
$generator->appendEndWhile();
$generator->appendCodePiece( "}" );

?>

The above code will fill the file "~/file.php" with the following contents:

<?php
/**
 * function fibonacci
 */
function fibonacci( $number )
{
    $lo = 1;
    $hi = 1;
    $i = 2;
    while ( $i < $number )
    {
        $hi = $lo + $hi;
        $lo = $hi - $lo;
    }
    return $hi;
}

?>
