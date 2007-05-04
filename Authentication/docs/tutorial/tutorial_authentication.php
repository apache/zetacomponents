<?php
$credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e' );
$authentication = new ezcAuthentication( $credentials );
$authentication->addFilter( new ezcAuthenticationHtpasswdFilter( '/etc/htpasswd' ) );
// add more filters if needed
if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array();
    $err["user"] = "";
    $err["password"] = "";
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
