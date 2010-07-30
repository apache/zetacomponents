<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$options = new ezcAuthenticationSessionOptions();
// setting 10 seconds timeout for session for testing purposes only
$options->validity = 60;

$session = new ezcAuthenticationSession( $options );
$session->start();

$setupUrl = isset( $_GET['openid_user_setup_url'] ) ? $_GET['openid_user_setup_url'] : null;
$immediate = isset( $_GET['immediate'] ) ? $_GET['immediate'] : false;

if ( $setupUrl !== null )
{
    $urlParts = parse_url( $setupUrl );
    parse_str( $urlParts['query'], $parts );
    $identity = $parts['openid_identity'];
}
else
{
    $identity = $session->load();
}

$url = isset( $_GET['openid_identifier'] ) ? $_GET['openid_identifier'] : $identity;
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

    // for checkid_immediate
    if ( $immediate !== false )
    {
        $options->immediate = true;
    }

    $filter = new ezcAuthenticationOpenidFilter( $options );

    // it seems that fetching extra data does not work with checkid_immediate
    $filter->registerFetchData( array( 'fullname', 'gender', 'country', 'language' ) );
    $authentication->addFilter( $filter );
}

if ( !$authentication->run() )
{
    $setupUrl = $filter->getSetupUrl();
    if ( !empty( $setupUrl ) )
    {
        // the setup URL will be read by the main window
        echo $setupUrl;
    }
    else
    {
        echo 'Authentication did not succeed.';
    }
}
else
{
?>
<script language="JavaScript">
    // inform the parent window that authentication was successful
    top.opener.window.document.getElementById( 'status' ).innerHTML = '<b style="color: #009900;">logged-in</b> | <a href="openid_ajax.php?action=logout">Logout</a>';
    window.close();
</script>
<?php
}
?>
