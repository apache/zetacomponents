<?php
// generate a token and save it in the session or in a file/database or in the
// html source code in a hidden form field
$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
$token  = "";
for( $i = 1; $i <= 6 ; $i++ )
{
    $token .= $pattern{rand( 0, 36 )};
}
$encryptedToken = sha1( $token );
// save the $encryptedToken, for example in a hidden form field in the html source code
// also generate a distorted image which contains the symbols from $token and use it
?>
