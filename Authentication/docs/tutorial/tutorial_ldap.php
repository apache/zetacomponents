<?php
require_once 'tutorial_autoload.php';

$credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
$ldap = new ezcAuthenticationLdapInfo( 'localhost', 'uid=%id%', 'dc=example,dc=com', 389 );
$authentication = new ezcAuthentication( $credentials );
$authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
// add more filters if needed
if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array(
            'ezcAuthenticationLdapFilter' => array(
                ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
                ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
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
