<?php
require_once 'tutorial_autoload.php';

// generate a token and save it in the session or in a file/database
$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
$token  = "";
for( $i = 1; $i <= 6 ; $i++ )
{
    $token .= $pattern{rand( 0, 36 )};
}
$encryptedToken = sha1( $token );

// save the $encryptedToken in the session
session_start();
$_SESSION['encryptedToken'] = $encryptedToken;

// also generate a distorted image which contains the symbols from $token and use it
?>
