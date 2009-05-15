<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$options = new ezcAuthenticationSessionOptions();

$session = new ezcAuthenticationSession( $options );
$session->start();

// URL after returning from OpenID authentication
$url = isset( $_GET['openid_identity'] ) ? $_GET['openid_identity'] : $session->load();
if ( $url === null )
{
    // URL at the start of authentication
    $url = isset( $_GET['openid_identifier'] ) ? $_GET['openid_identifier'] : $session->load();
}

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
    $options = new ezcAuthenticationOpenidOptions();
    $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
    $options->preferredVersion = ezcAuthenticationOpenidFilter::VERSION_2_0;
    $options->store = new ezcAuthenticationOpenidFileStore( '/tmp/store' );

    $filter = new ezcAuthenticationOpenidFilter( $options );
    $filter->registerFetchData( array( 'fullname', 'gender', 'country', 'language' ) );
    $authentication->addFilter( $filter );
}

if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user
    $status = $authentication->getStatus();
    $err = array();
    $err["user"] = "";
    $err["session"] = "";
    for ( $i = 0; $i < count( $status ); $i++ )
    {
        list( $key, $value ) = each( $status[$i] );
        switch ( $key )
        {
            case 'ezcAuthenticationOpenidFilter':
                if ( $value === ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT )
                {
                    $err["user"] = "<span class='error'>OpenID said the provided identifier was incorrect.</span>";
                }
                if ( $value === ezcAuthenticationOpenidFilter::STATUS_CANCELLED )
                {
                    $err["user"] = "<span class='error'>The OpenID authentication was cancelled, please re-login.</span>";
                }
                if ( $value === ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT )
                {
                    $err["user"] = "<span class='error'>The identifier you provided is empty or invalid. It must be a URL (eg. www.example.com or http://www.example.com)</span>";
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
?>

<style>
.error {
    color: #FF0000;
}
</style>
Please login with your OpenID identifier (an URL, eg. www.example.com or http://www.example.com):
<form method="GET" action="">
<input type="hidden" name="action" value="login" />
<img src="http://openid.net/login-bg.gif" /> <input type="text" name="openid_identifier" />
<input type="submit" value="Login" />
<?php echo $err["user"]; ?> <?php echo $err["session"]; ?>
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
