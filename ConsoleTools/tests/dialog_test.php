<?php
/**
 * ezcConsoleDialogTest class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Generic test case for ezcConsoleDialog implementations.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleDialogTest extends ezcTestCase
{
    const PIPE_READ_SLEEP = 5000;

    protected $dataDir;

    protected $phpPath;

    protected $output;

    protected $proc;

    protected $pipes = array();

    protected $res = array();

    protected function setUp()
    {
        $this->dataDir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR
            . ( ezcBaseFeatures::os() === 'Windows' ? "windows" : "posix" );
        $this->determinePhpPath();
        $this->output  = new ezcConsoleOutput();
        $this->output->formats->test->color = "blue";
    }

    protected function determinePhpPath()
    {
        if ( isset( $_SERVER["_"] ) )
        {
            $this->phpPath = $_SERVER["_"];
        }
        else if ( ezcBaseFeatures::os() === 'Windows' )
        {
            $this->phpPath = 'php.exe';
        }
        else
        {
            $this->phpPath = '/bin/env php';
        }
    }

    protected function tearDown()
    {
        unset( $this->output );
    }

    protected function runDialog( $methodName )
    {
        $methodName = strtr(
            $methodName,
            array(
                ":" => "_",
            )
        );
        $scriptFile = $this->dataDir . DIRECTORY_SEPARATOR . $methodName . '.php';
        $resFile    = $this->dataDir . DIRECTORY_SEPARATOR . $methodName . '_res.php';
        if ( !file_exists( $scriptFile ) )
        {
            throw new RuntimeException( "Missing script file '$scriptFile'!" );
        }

        $desc = array(
            0 => array( "pipe", "r" ),  // stdin
            1 => array( "pipe", "w" ),  // stdout
            2 => array( "pipe", "w" )   // stderr
        );
        $this->proc = proc_open("{$this->phpPath} '{$scriptFile}'", $desc, $this->pipes );
        $this->res  = ( file_exists( $resFile ) ? require( $resFile ) : false );
    }

    protected function closeDialog()
    {
        proc_close( $this->proc );
        unset( $this->pipes, $this->res );
    }

    protected function saveDialogResult( $methodName, $res )
    {
        $methodName = strtr(
            $methodName,
            array(
                ":" => "_",
            )
        );
        $resFile    = "{$this->dataDir}/{$methodName}_res.php";
        file_put_contents(
            $resFile,
            "<?php\n\nreturn " . var_export( $res, true ) . ";\n\n?>"
        );
    }

    protected function readPipe( $pipe )
    {
        usleep( self::PIPE_READ_SLEEP );
        return fread( $pipe, 1024 );
    }
}

?>
