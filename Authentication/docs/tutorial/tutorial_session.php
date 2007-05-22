<?php
// no headers should be sent before calling $session->start()
$session = new ezcAuthenticationSessionFilter();
$session->start();
$user = isset( $_POST['user'] ) ? $_POST['user'] : $session->load();
$password = isset( $_POST['password'] ) ? $_POST['password'] : null;
$credentials = new ezcAuthenticationPasswordCredentials( $user, $password );
$authentication = new ezcAuthentication( $credentials );
$authentication->session = $session;
$authentication->addFilter( new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd' ) );
// add other filters if needed
if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array(
             ezcAuthenticationHtpasswdFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
             ezcAuthenticationHtpasswdFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password',
             ezcAuthenticationSessionFilter::STATUS_EMPTY => '',
             ezcAuthenticationSessionFilter::STATUS_EXPIRED => 'Session expired'
             );
    for ( $i = 0; $i < count( $status ); $i++ )
    {
        list( $key, $value ) = each( $status[$i] );
        echo $err[$value];
    }
}
else
{
    // authentication succeeded, so allow the user to see his content
}
?>
