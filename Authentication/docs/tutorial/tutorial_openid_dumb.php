<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$session = new ezcAuthenticationSession();
$session->start();

$url = isset( $_GET['openid_identifier'] ) ? $_GET['openid_identifier'] : $session->load();
$action = isset( $_GET['action'] ) ? strtolower( $_GET['action'] ) : null;

$credentials = new ezcAuthenticationIdCredentials( $url );
$authentication = new ezcAuthentication( $credentials );
$authentication->session = $session;

if ( $action === 'logout' )
{
    $session->destroy();
}
else
{
    $filter = new ezcAuthenticationOpenidFilter();
    $authentication->addFilter( $filter );
}

if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array(
             'ezcAuthenticationOpenidFilter' => array(
                 ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT => 'OpenID said the provided identifier was incorrect',
                 ezcAuthenticationOpenidFilter::STATUS_CANCELLED => 'The OpenID authentication was cancelled',
                 ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT => 'The identifier you provided is invalid'
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
Please login with your OpenID identifier (an URL, eg. www.example.com or http://www.example.com):
<form method="GET" action="">
<input type="hidden" name="action" value="login" />
<img src="http://openid.net/login-bg.gif" /> <input type="text" name="openid_identifier" />
<input type="submit" value="Login" />
</form>

<?php
}
else
{
?>

You are logged-in as <b><?php echo $url; ?></b> | <a href="?action=logout">Logout</a>

<?php
}
?>
