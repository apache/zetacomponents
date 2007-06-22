<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$session = new ezcAuthenticationSession();
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
            'ezcAuthenticationHtpasswdFilter' => array(
                ezcAuthenticationHtpasswdFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
                ezcAuthenticationHtpasswdFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
                ),
            'ezcAuthenticationSession' => array(
                ezcAuthenticationSession::STATUS_EMPTY => '',
                ezcAuthenticationSession::STATUS_EXPIRED => 'Session expired'
                )
            );
    foreach ( $status as $line )
    {
        list( $key, $value ) = each( $line );
        echo $err[$key][$value] . "\n";
    }
}
else
{
    // authentication succeeded, so allow the user to see his content
}
?>
