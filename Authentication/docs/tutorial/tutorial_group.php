<?php
$credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );

// create a database filter
$database = new ezcAuthenticationDatabaseInfo( ezcDbInstance::get(), 'users', array( 'user', 'password' ) );
$databaseFilter = new ezcAuthenticationDatabaseFilter( $database );

// create an LDAP filter
$ldap = new ezcAuthenticationLdapInfo( 'localhost', 'uid=%id%', 'dc=example,dc=com', 389 );
$ldapFilter = new ezcAuthenticationLdapFilter( $ldap );
$authentication = new ezcAuthentication( $credentials );

// use the database and LDAP filters in paralel (only one needs to succeed in
// order for the user to be authenticated
$authentication->addFilter( new ezcAuthenticationGroupFilter( array( $databaseFilter, $ldapFilter ) ) );
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
            case 'ezcAuthenticationDatabaseFilter':
                if ( $value === ezcAuthenticationDatabaseFilter::STATUS_USERNAME_INCORRECT )
                {
                    $err["user"] = "<span class='error'>Username incorrect</span>";
                }
                if ( $value === ezcAuthenticationDatabaseFilter::STATUS_PASSWORD_INCORRECT )
                {
                    $err["password"] = "<span class='error'>Password incorrect</span>";
                }
                break;
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
