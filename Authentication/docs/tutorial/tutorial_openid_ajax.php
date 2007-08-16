<?php
require_once 'tutorial_autoload.php';

// no headers should be sent before calling $session->start()
$options = new ezcAuthenticationSessionOptions();

// setting 60 seconds timeout for session for testing purposes only
$options->validity = 60;

$session = new ezcAuthenticationSession( $options );
$session->start();

$identity = $session->load();

$url = isset( $_GET['openid_identifier'] ) ? $_GET['openid_identifier'] : $identity;
$action = isset( $_GET['action'] ) ? strtolower( $_GET['action'] ) : null;

$credentials = new ezcAuthenticationIdCredentials( $url );
$authentication = new ezcAuthentication( $credentials );
$authentication->session = $session;

if ( $action === 'logout' )
{
    $session->destroy();
}

if ( !$authentication->run() )
{
    // authentication did not succeed, so inform the user

?>

<script language="JavaScript">
    var xmlhttp = false;

    /*@cc_on @*/
    /*@if ( @_jscript_version >= 5 )
    try
    {
        xmlhttp = new ActiveXObject( "Msxml2.XMLHTTP" );
    }
    catch ( e )
    {
        try
        {
            xmlhttp = new ActiveXObject( "Microsoft.XMLHTTP" );
        }
        catch ( E )
        {
            xmlhttp = false;
        }
    }
    @end @*/

    if ( !xmlhttp && typeof XMLHttpRequest != 'undefined' )
    {
        try
        {
            xmlhttp = new XMLHttpRequest();
        }
        catch ( e )
        {
            xmlhttp = false;
        }
    }

    if ( !xmlhttp && window.createRequest )
    {
        try
        {
            xmlhttp = window.createRequest();
        }
        catch ( e )
        {
            xmlhttp = false;
        }
    }
</script>

<script language="JavaScript">
    function disableEnterKey( e )
    {
        var key;
        key = ( window.event ) ? window.event.keyCode : e.which;

        return ( key != 13 );
    }

    function login()
    {
        var url;
        var form1;
        var setupUrl;

        form1 = document.form1;

        url = form1.url.value + '?openid_identifier=' + escape( form1.openid_identifier.value ) +
                                '&action=login&immediate=true';

        xmlhttp.open( "GET", url, true );
        xmlhttp.onreadystatechange = function()
        {
            if ( xmlhttp.readyState == 4 )
            {
                setupUrl = xmlhttp.responseText;
                hwnd = window.open( setupUrl, 'Login' );
                if ( hwnd.opener == null )
                {
                    hwnd.opener = self;
                }
            }
        }
        xmlhttp.send( null );
    }
</script>
Please login with your OpenID identifier (an URL, eg. www.example.com or http://www.example.com):
<form method="GET" name="form1">
<input type="hidden" name="url" value="http://localhost/openid/openid_immediate.php" />
<input type="hidden" name="action" value="login" />
<img src="http://openid.net/login-bg.gif" /> <input type="text" name="openid_identifier" onKeyPress="return disableEnterKey( event )" />
<input type="button" onclick="javascript: login();" value="Login" />
<div name="status" id="status"></div>
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
