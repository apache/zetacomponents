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
    $err = array();
    $err["user"] = "";
    $err["password"] = "";
    $err["session"] = "";
    for ( $i = 0; $i < count( $status ); $i++ )
    {
        list( $key, $value ) = each( $status[$i] );
        switch ( $key )
        {
            case 'ezcAuthenticationHtpasswdFilter':
                if ( $value === ezcAuthenticationHtpasswdFilter::STATUS_USERNAME_INCORRECT )
                {
                    $err["user"] = "<span class='error'>Username incorrect</span>";
                }
                if ( $value === ezcAuthenticationHtpasswdFilter::STATUS_PASSWORD_INCORRECT )
                {
                    $err["password"] = "<span class='error'>Password incorrect</span>";
                }
                break;

            case 'ezcAuthenticationSessionFilter':
                if ( $value === ezcAuthenticationSessionFilter::STATUS_EXPIRED )
                {
                    $err["session"] = "<span class='error'>Session expired</span>";
                }
                break;
        }
    }
    // use $err array (with a Template object for example) to display the login form
    // to the user with "Password incorrect" message next to the password field, etc...
}
else
{
    // authentication succeeded, so allow the user to see his content
}
?>
