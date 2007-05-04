<?php
// no headers should be sent before calling $session->start()
$session = new ezcAuthenticationSessionFilter();
$session->start();

// $token is used as a key in the session to store the authenticated state between requests
$token = isset( $_GET['token'] ) ? $_GET['token'] : $session->load();

$credentials = new ezcAuthenticationIdCredentials( $token );
$authentication = new ezcAuthentication( $credentials );
$authentication->session = $session;

var_dump( $token );
var_dump( $_SESSION );
$filter = new ezcAuthenticationTypekeyFilter();
$authentication->addFilter( $filter );
// add other filters if needed

if ( !$authentication->run() )
{
    echo "<b>Not logged-in</b>. ";
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    for ( $i = 0; $i < count( $status ); $i++ )
    {
        list( $key, $value ) = each( $status[$i] );
        switch ( $key )
        {
            case 'ezcAuthenticationTypekeyFilter':
                if ( $value === ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_INCORRECT )
                {
                    echo "Signature returned by TypeKey is incorrect.";
                }
                if ( $value === ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_EXPIRED )
                {
                    echo "Did not login in a reasonable amount of time. The application server and the TypeKey server might be desynchronized.";
                }
                break;

            case 'ezcAuthenticationSessionFilter':
                if ( $value === ezcAuthenticationSessionFilter::STATUS_EXPIRED )
                {
                    echo "Session expired.";
                }
                if ( $value === ezcAuthenticationSessionFilter::STATUS_EMPTY )
                {
                    echo "Session empty.";
                }
                break;
        }
    }
?>
<form method="GET" action="https://www.typekey.com/t/typekey/login" onsubmit="document.getElementById('_return').value += '?token=' + document.getElementById('t').value;">
TypeKey token: <input type="text" name="t" id="t" />
<input type="hidden" name="_return" id="_return" value="http://localhost/typekey.php" />
<input type="submit" />
</form>
<?
}
else
{
    // authentication succeeded, so allow the user to see his content
    echo "<b>Logged-in</b>";
}
?>
