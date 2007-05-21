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
    $err = array(
             ezcAuthenticationLdapFilter::STATUS_USERNAME_INCORRECT => 'Incorrect username',
             ezcAuthenticationLdapFilter::STATUS_PASSWORD_INCORRECT => 'Incorrect password'
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
