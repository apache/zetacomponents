<?php

require_once '/home/dotxp/dev/ez/ezcomponents/trunk/Base/src/base.php';

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

require_once dirname( __FILE__ ) . '/transport_mock.php';

$trans = new tsWebdavTransportMock();
$trans->options->pathFactory = new ezcWebdavPathFactory( 'http://' . $_SERVER['HTTP_HOST'] );
try
{
    $req = $trans->parseRequest( ( $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'] ) );
    $req->validateHeaders();
}
catch( Exception $e )
{
    file_put_contents( './webdav.transport.error.log' . microtime(), var_export( $e, true ) );
    die( $e->getMessage() );
}

if ( file_exists( ( $backendFile = dirname( __FILE__ ) . '/backend.ser' ) ) )
{
    $backend = unserialize( file_get_contents( $backendFile ) );
}
else
{
    $backend = new ezcWebdavMemoryBackend();
    $backend->options->fakeLiveProperties = true;
    $backend->addContents(
        array(
            'test_collection' => array(
                'foo.txt'  => 'Test foo content',
                'bar'      => 'Test bar content',
                'baz_coll' => array(
                    'baz_1.html' => '<html></html>',
                    'baz_2.html' => '<html><body><h1>Test</h1></body></html>',
                ),
            ),
        )
    );

    // Make GET requests work

    $backend->setProperty(
        '/test_collection/foo.txt',
        new ezcWebdavGetContentTypeProperty(
            'text/plain', 'utf-8'
        )
    );
    $backend->setProperty(
        '/test_collection/bar',
        new ezcWebdavGetContentTypeProperty(
            'text/plain', 'utf-8'
        )
    );
    $backend->setProperty(
        '/test_collection/baz_coll/baz_1.html',
        new ezcWebdavGetContentTypeProperty(
            'text/html', 'utf-8'
        )
    );
    $backend->setProperty(
        '/test_collection/baz_coll/baz_2.html',
        new ezcWebdavGetContentTypeProperty(
            'text/xhtml', 'utf-8'
        )
    );
}

$log['request']['backend'] = serialize( $backend );
    
try
{
    $res = $backend->performRequest( $req );
}
catch ( Exception $e )
{
    file_put_contents( './webdav.backend.error.log' . microtime(), var_export( $e, true ) );
    die( $e->getMessage() );
}

try
{
    $trans->handleResponse( $res );
}
catch ( Exception $e )
{
    file_put_contents( './webdav.transport.error.log' . microtime(), var_export( $e, true ) );
    die( $e->getMessage() );
}

$log['request']['server'] =  "<?php\n\nreturn " . var_export( $_SERVER, true ) . ";\n\n?>";
$log['request']['body'] = $GLOBALS['TS_REQUEST_BODY'];
$log['request']['uri'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

$log['response']['headers'] = "<?php\n\nreturn " . var_export( $GLOBALS['TS_RESPONSE_HEADERS'], true ) . ";\n\n?>";
$log['response']['body'] = $GLOBALS['TS_RESPONSE_BODY'];
$log['response']['code'] = $GLOBALS['TS_RESPONSE_INFO']->response->status;
$log['response']['name'] = ezcWebdavResponse::$errorNames[$GLOBALS['TS_RESPONSE_INFO']->response->status];

if ( !file_exists( ( $logDir = dirname( __FILE__ ) . '/log' ) ) )
{
    mkdir( $logDir );
}

$testName = $_SERVER['REQUEST_METHOD'];
$testNo   = ( file_exists( ( $testNoFile = dirname( __FILE__ ) . '/test.no.txt' ) ) ? (int)  file_get_contents( $testNoFile ) : 1 );
$testDir  = $logDir . sprintf( "/%'03s_%s", $testNo, $testName );

file_put_contents( $testNoFile, ++$testNo );

mkdir( $testDir );

mkdir( ( $requestDir  = $testDir . '/request' ) );
mkdir( ( $responseDir = $testDir . '/response' ) );

file_put_contents( $requestDir . '/server.php', $log['request']['server'] );
file_put_contents( $requestDir . '/body.xml', $log['request']['body'] );
file_put_contents( $requestDir . '/uri.txt', $log['request']['uri'] );

file_put_contents( $responseDir . '/headers.php', $log['response']['headers'] );
file_put_contents( $responseDir . '/body.xml', $log['response']['body'] );
file_put_contents( $responseDir . '/code.txt', $log['response']['code'] );
file_put_contents( $responseDir . '/name.txt', $log['response']['name'] );

file_put_contents( $backendFile, serialize( $backend ) );

?>
