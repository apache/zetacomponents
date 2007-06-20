<?php
// load the $token as it was generated on the previous request
$token = isset( $_POST['token'] ) ? $_POST['token'] : null;
// also load the value entered by the user in response to the CAPTCHA image
$captcha = isset( $_POST['captcha'] ) ? $_POST['captcha'] : null;
$credentials = new ezcAuthenticationIdCredentials( $captcha );
$authentication = new ezcAuthentication( $credentials );
$authentication->addFilter( new ezcAuthenticationTokenFilter( $token, 'sha1' ) );
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
