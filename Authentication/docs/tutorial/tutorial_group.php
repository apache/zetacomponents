<?php
require_once 'tutorial_autoload.php';

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
    $err = array(
            'ezcAuthenticationLdapFilter' => array(
                ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
                ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
                ),
            'ezcAuthenticationDatabaseFilter' => array(
                ezcAuthenticationDatabaseFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
                ezcAuthenticationDatabaseFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
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
