<?php

// Intialize autoload
require_once '/home/kore/devel/ezcomponents/trunk/Base/src/base.php';
function __autoload( $class )
{
    ezcBase::autoload( $class );
}

// Create log directory for current request
mkdir( 
    $logDir = 'log/' . preg_replace( '(\W+)', '_', $_SERVER['HTTP_USER_AGENT'] ) . '/' . 
        date( 'Ymd_His_' ) . substr( microtime( true ), 2 ) . '/', 
    0777, 
    true
);

// Simply use file backend
$backend = new ezcWebdavFileBackend( 'storage/' );

// Read request contents
$GLOBALS['EZC_WEBDAV_REQUEST_BODY'] = '';

$in = fopen(  'php://input', 'r' );
while (  $data = fread(  $in, 1024 ) )
{
    $GLOBALS['EZC_WEBDAV_REQUEST_BODY'] .= $data;
}

// Log request contents
file_put_contents( $logDir . 'request_headers.txt', "<?php\n\nreturn " . var_export( $_SERVER, true ) . "\n?>" );
file_put_contents( $logDir . 'request_body.xml',   $GLOBALS['EZC_WEBDAV_REQUEST_BODY'] );

// Mock transport to make important stuff accessible
class mockedTransport extends ezcWebdavMicrosoftCompatibleTransport
{
    protected function retrieveBody()
    {
        return $GLOBALS['EZC_WEBDAV_REQUEST_BODY'];
    }

    protected function sendResponse( ezcWebdavOutputResult $output )
    {
        $GLOBALS['EZC_WEBDAV_RESPONSE'] = $output->status;
        $GLOBALS['EZC_WEBDAV_RESPONSE_HEADERS'] = $output->headers;

        ob_start();
        parent::sendResponse( $output );
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = ob_get_clean();


        // MS stuff seems to want paths without host
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = str_replace(
            'http://webdav',
            '',
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );

        // Add date namespace to response elements for MS clients
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = preg_replace(
            '(<D:response([^>]*)>)',
            '<D:response\\1 xmlns:lp1="DAV:" xmlns:lp2="http://apache.org/dav/props/" xmlns:ns0="urn:uuid:c2f41010-65b3-11d1-a29f-00aa00c14882/">',
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );

        // Set creationdate namespace
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = preg_replace(
            '(<D:creationdate([^>]*)>)',
            '<D:creationdate\\1 ns0:dt="dateTime.tz">',
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );

        // Set getlastmodified namespace
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = preg_replace(
            '(<D:getlastmodified([^>]*)>)',
            '<D:getlastmodified\\1 ns0:dt="dateTime.rfc1123">',
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );

        // Put some elements in DAV: namespace with other namespace identifier
        $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] = preg_replace(
            '(D:(resourcetype|creationdate|getlastmodified|getetag)([^>]*))',
            'lp1:\\1\\2',
            $GLOBALS['EZC_WEBDAV_RESPONSE_BODY']
        );

        echo $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'];
    }
}

// Create transport
$transport = new mockedTransport();
$transport->pathFactory = new ezcWebdavBasicPathFactory( 'http://webdav' );

if ( ( strpos( $_SERVER['REQUEST_URI'], '.' ) === false ) &&
     ( substr( $_SERVER['REQUEST_URI'], -1 ) !== '/' ) )
{
    header( 'Location: ' . $_SERVER['REQUEST_URI'] . '/', true, 301 );
    exit;
}

// Try to parse request, and log otherwise
$response = false;
try
{
    $request = $transport->parseRequest( ( $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'] ) );
    $request->validateHeaders();
}
catch ( Exception $e )
{
    file_put_contents( $logDir . 'transport_parse_error.txt', (string) $e );

    $response = new ezcWebdavErrorResponse(
        ezcWebdavResponse::STATUS_400
    );
}

// We already may have caused some error response, so that we do not need to
// handle the request any more
if ( $response === false )
{
    // Log parsed request
    file_put_contents( $logDir . 'request.txt', "<?php\n\nreturn " . var_export( $request, true ) . "\n?>" );

    // Try to handle given request in backend, and log failures
    try
    {
        $response = $backend->performRequest( $request );
    }
    catch ( Exception $e )
    {
        file_put_contents( $logDir . 'backend_error.txt', (string) $e );

        $response = new ezcWebdavErrorResponse(
            ezcWebdavResponse::STATUS_500
        );
    }
}

// Log handled response
file_put_contents( $logDir . 'response.txt', "<?php\n\nreturn " . var_export( $response, true ) . "\n?>" );

// Try to serialize response back, log on error
try
{
    $transport->handleResponse( $response );
}
catch ( Exception $e )
{
    file_put_contents( $logDir . 'transport_serialize_error.txt', (string) $e );
    die( 
        'Error handling response: ' .
        $e->getMessage()
    );
}

// Log actual response
file_put_contents( $logDir . 'response_status.xml',  $GLOBALS['EZC_WEBDAV_RESPONSE'] );
file_put_contents( $logDir . 'response_headers.xml', var_export( $GLOBALS['EZC_WEBDAV_RESPONSE_HEADERS'], true ) );
file_put_contents( $logDir . 'response_body.xml',    $GLOBALS['EZC_WEBDAV_RESPONSE_BODY'] );
?>
