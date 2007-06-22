<?php
require_once 'tutorial_autoload.php';

// load the $encryptedToken as it was generated on a previous request
session_start();
$encryptedToken = isset( $_SESSION['encryptedToken'] ) ? $_SESSION['encryptedToken'] : null;

// also load the value entered by the user in response to the CAPTCHA image
$captcha = isset( $_POST['captcha'] ) ? $_POST['captcha'] : null;

$credentials = new ezcAuthenticationIdCredentials( $captcha );
$authentication = new ezcAuthentication( $credentials );
$authentication->addFilter( new ezcAuthenticationTokenFilter( $encryptedToken, 'sha1' ) );
if ( !$authentication->run() )
{
    // CAPTCHA was incorrect, so inform the user to try again, eventually
    // by generating another token and CAPTCHA image
}
else
{
    // CAPTCHA was correct, so let the user send his spam or whatever
}
?>
