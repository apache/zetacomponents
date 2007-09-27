<?php

require_once dirname( __FILE__ ) . '/../../../Base/src/base.php';

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

function loadFiles( array $files )
{
    $unorderedRes = array();
    foreach ( $files as $file )
    {
        $info = pathinfo( $file );
        switch( $info['extension'] )
        {
            case 'ser':
                $value = var_export( unserialize( file_get_contents( $file ) ), true );
                break;
            case 'php':
                $value = file_get_contents( $file );
                break;
            case 'txt':
            default:
                $value = file_get_contents( $file );
                break;
        }
        $unorderedRes[$info['filename']] = $value;
    }
    
    $res = array();
    if ( isset( $unorderedRes['info'] ) )
    {
        $res['info'] = $unorderedRes['info'];
        unset( $unorderedRes['info'] );
    }
    if ( isset( $unorderedRes['code'] ) )
    {
        $res['code'] = $unorderedRes['code'];
        unset( $unorderedRes['code'] );
    }
    if ( isset( $unorderedRes['name'] ) )
    {
        $res['name'] = $unorderedRes['name'];
        unset( $unorderedRes['name'] );
    }
    if ( isset( $unorderedRes['uri'] ) )
    {
        $res['uri'] = $unorderedRes['uri'];
        unset( $unorderedRes['uri'] );
    }
    if ( isset( $unorderedRes['server'] ) )
    {
        $res['server'] = $unorderedRes['server'];
        unset( $unorderedRes['server'] );
    }
    if ( isset( $unorderedRes['headers'] ) )
    {
        $res['headers'] = $unorderedRes['headers'];
        unset( $unorderedRes['headers'] );
    }
    if ( isset( $unorderedRes['body'] ) )
    {
        $res['body'] = $unorderedRes['body'];
        unset( $unorderedRes['body'] );
    }
    if ( isset( $unorderedRes['result'] ) )
    {
        $res['result'] = $unorderedRes['result'];
        unset( $unorderedRes['result'] );
    }
    foreach( $unorderedRes as $name => $value )
    {
        $res[$name] = $value;
    }
    return $res;
}

$out = new ezcConsoleOutput();

$out->formats->error->color  = 'red';
$out->formats->error->style  = array( 'bold' );
$out->formats->error->target = ezcConsoleOutput::TARGET_STDERR;

$out->formats->headline_1->color  = 'green';
$out->formats->headline_1->style  = array( 'bold' );

$out->formats->headline_2->color  = 'cyan';
$out->formats->headline_2->style  = array( 'bold' );

$out->formats->headline_3->color  = 'blue';

$out->formats->border->color  = 'gray';
$out->formats->border->style  = array( 'bold' );


$in = new ezcConsoleInput();

$helpOpt = $in->registerOption(
    new ezcConsoleOption( 'h', 'help' )
);
$helpOpt->isHelpOption = true;
$helpOpt->shorthelp    = 'Print help information.';
$helpOpt->longhelp     = 'Display this help information about the program.';

$suiteOpt = $in->registerOption(
    new ezcConsoleOption( 's', 'suite', ezcConsoleInput::TYPE_STRING, '*' )
);
$suiteOpt->shorthelp = 'Path pattern defining the client test suites to display data for.';
$suiteOpt->longhelp  = 'This option may contain a path pattern as understood by glob(), defining the client test suites to display data for. An example would be "rfc" to only see the rfc tests or "r*" to see all suites starting with "r".';

$testOpt = $in->registerOption(
    new ezcConsoleOption( 't', 'test', ezcConsoleInput::TYPE_STRING, '*' )
);
$testOpt->shorthelp = 'Path pattern defining the test cases to display data for.';
$testOpt->longhelp  = 'This option may contain a path pattern as understood by glob(), defining the test cases to display data for. An example would be "get_*" to only see all test cases that start with "get_".';

$noColorOpt = $in->registerOption(
    new ezcConsoleOption( 'n', 'no-color' )
);
$noColorOpt->shorthelp = 'Switch of use of format codes (for logging).';
$noColorOpt->longhelp  = 'Switches of the use of shell formatting codes, like color and style. This is particularly useful if you want to log the generated output.';

try
{
    $in->process();
}
catch ( ezcConsoleException $e )
{
    $out->outputLine( $e->getMessage(), 'error' );
    $out->outputLine(
        $in->getHelpText( 'Webdav client test viewer' ),
        'error'
    );
    exit(-1);
}

if ( $helpOpt->value === true )
{
    $out->outputLine(
        $in->getHelpText( 'Webdav client test viewer', 80, true )
    );
    exit(0);
}

if ( $noColorOpt->value === true )
{
    $out->options->useFormats = false;
}

$suites = glob( dirname( __FILE__ ) . "/../clients/{$suiteOpt->value}", GLOB_ONLYDIR );
foreach ( $suites as $suite )
{
    $tests = glob( "{$suite}/{$testOpt->value}", GLOB_ONLYDIR );


    foreach( $tests as $test )
    {

        $requestInfos = loadFiles( glob( "{$test}/request/*" ) );
        if ( count( $requestInfos ) === 0 )
        {
            echo $out->outputLine( 'No files found for this test!', 'error' );
        }
        foreach ( $requestInfos as $file => $info )
        {
            $out->outputLine();
            $out->outputLine( '- Printing infos for test suite "' . basename( $suite ) . '":', 'headline_1' );
            $out->outputLine( '--- Printing infos for test "' . basename( $test ) . '/request":', 'headline_2' );
            $out->outputLine( '----- Printing file contents for "' . $file . '"', 'headline_3' );

            $out->outputLine( '------------------------------------- START ------------------------------------', 'border' );
            $out->outputLine( $info );
            $out->outputLine( '-------------------------------------- END -------------------------------------', 'border' );
        }
        

        $responseInfos = loadFiles( glob( "{$test}/response/*" ) );
        if ( count( $responseInfos ) === 0 )
        {
            echo $out->outputLine( 'No files found for this test!', 'error' );
        }
        foreach ( $responseInfos as $file => $info )
        {
            $out->outputLine( '--- Printing infos for test "' . basename( $test ) . '/response":', 'headline_2' );
            $out->outputLine( '----- Printing file contents for "' . $file . '"', 'headline_3' );

            $out->outputLine( '------------------------------------- START ------------------------------------', 'border' );
            $out->outputLine( $info );
            $out->outputLine( '-------------------------------------- END -------------------------------------', 'border' );
        }
    }
}

?>
