<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$session = new ezcAuthenticationSession();
$session->start();

// $token is used as a key in the session to store the authenticated state between requests
$token = isset( $_GET['token'] ) ? $_GET['token'] : $session->load();

$credentials = new ezcAuthenticationIdCredentials( $token );
$authentication = new ezcAuthentication( $credentials );
$authentication->session = $session;

$filter = new ezcAuthenticationTypekeyFilter();
$authentication->addFilter( $filter );
// add other filters if needed

if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array(
             'ezcAuthenticationTypekeyFilter' => array(
                 ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_INCORRECT => 'Signature returned by TypeKey is incorrect',
                 ezcAuthenticationTypekeyFilter::STATUS_SIGNATURE_EXPIRED => 'The signature returned by TypeKey expired'
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
?>
<form method="GET" action="https://www.typekey.com/t/typekey/login" onsubmit="document.getElementById('_return').value += '?token=' + document.getElementById('t').value;">
TypeKey token: <input type="text" name="t" id="t" />
<input type="hidden" name="_return" id="_return" value="http://localhost/typekey.php" />
<input type="submit" />
</form>
<?php
}
else
{
    // authentication succeeded, so allow the user to see his content
    echo "<b>Logged-in</b>";
}
?>
