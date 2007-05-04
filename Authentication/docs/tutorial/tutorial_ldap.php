<?php
$credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
$ldap = new ezcAuthenticationLdapInfo( 'localhost', 'uid=%id%', 'dc=example,dc=com', 389 );
$authentication = new ezcAuthentication( $credentials );
$authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
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
            case 'ezcAuthenticationLdapFilter':
                if ( $value === ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT )
                {
                    $err["user"] = "<span class='error'>Username incorrect</span>";
                }
                if ( $value === ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT )
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
