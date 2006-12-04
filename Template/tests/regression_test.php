<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 *
 * @note To turn on interactive mode set the environment variable
 *       EZC_TEST_INTERACTIVE to 1 (0 is off)
 * @note To turn on verbose error messagesset the environment variable
 *       EZC_TEST_VERBOSE to 1 (0 is off)
 */
include_once ("custom_blocks/testblocks.php");
include_once ("custom_blocks/links.php");
include_once ("custom_blocks/cblock.php");
include_once ("custom_blocks/sha1.php");

class ezcTemplateRegressionTest extends ezcTestCase
{
    public $interactiveMode = false;

    public $verboseErrors = false;

    public $skipMissingTests = false;

    public $directories = array();

    public $regressionDir = '';

    private $retryTest = false;

    private $stdin = null;

    public function __construct()
    {
        parent::__construct();

        $this->regressionDir = dirname(__FILE__) . "/regression_tests";
        $this->createTempDir( "regression_compiled_" );

        $directories = array();
        $this->readDirRecursively( $this->regressionDir, $directories, "in" );

        // Sort it, than the file a.in will be processed first. Handy for development.
        natsort( $directories );

        $this->directories = $directories;

        // Check for environment variables which turns on special features
        if ( isset( $_ENV['EZC_TEST_INTERACTIVE'] ) )
            $this->interactiveMode = (bool)$_ENV['EZC_TEST_INTERACTIVE'];

        if ( isset( $_ENV['EZC_TEST_VERBOSE'] ) )
            $this->verboseErrors = (bool)$_ENV['EZC_TEST_VERBOSE'];

        if( $this->interactiveMode )
        {
            // Create stdin handle for asking questions to user
            $this->stdin = fopen("php://stdin","r");
        }
    }

    public function __destruct()
    {
        if( $this->stdin !== null)
        {
            fclose( $this->stdin );
        }
    }

    public function count()
    {
        // We return 1 here since we have startTest/endTest for each .in file
        return 1;
    }

    // This method overrides the default run() in PHPUnit to allowed data-driven testing.
    public function run(PHPUnit_Framework_TestResult $result = NULL)
    {
        if ($result === NULL) {
            $result = $this->createResult();/*new PHPUnit_Framework_TestResult;*/
        }

        $this->setUp();

        $useXdebug = false;
//        $useXdebug = (extension_loaded('xdebug') /*&& $result->collectCodeCoverageInformation)*/;

        foreach ( $this->directories as $directory )
        {
            $result->startTest($this);

            if ($useXdebug && !defined('PHPUnit_INSIDE_OWN_TESTSUITE')) {
                xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
            }

/*            PHPUnit_Util_Timer::start();*/

            $this->retryTest = true;
            while ( $this->retryTest )
            {
                try {
                    $this->retryTest = false;
                    $this->testRunRegression( $directory );
                }

                catch (PHPUnit_Framework_AssertionFailedError $e) {
                    $result->addFailure($this, $e, time() );
                }

                catch (Exception $e) {
                    $result->addError($this, $e, time() );
                }
            }

            $time = time();
/*            $time = PHPUnit_Util_Timer::stop();
            $result->time += $time;*/
            $result->endTest( $this, $time );
        }


        if ($useXdebug) {
            $result->codeCoverageInformation[] = array(
              'test'  => $this,
              'files' => xdebug_get_code_coverage()
            );

            xdebug_stop_code_coverage();

            if (defined('PHPUnit_INSIDE_OWN_TESTSUITE')) {
                xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
            }
        }

        $this->tearDown();

        return $result;
    }

    protected function setUp()
    {
        date_default_timezone_set( "UTC" );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    private function removeTags( $str )
    {
        $str=str_replace('<'.'?php','<'.'?',$str);
        $str= '?'.'>'. trim($str). '<'.'?';
        return $str;
    }

    private function readDirRecursively( $dir, &$total, $onlyWithExtension = false) 
    {
        $extensionLength = strlen( $onlyWithExtension );
        $path = opendir( $dir );

        while( false !== ( $file = readdir( $path ) ) ) 
        {
            if( $file != "." && $file != ".." ) 
            {
                $new = $dir . "/" . $file;

                if( is_file( $new ) )
                {
                    if( !$onlyWithExtension || substr( $file,  -$extensionLength - 1 ) == ".$onlyWithExtension" )
                    {
                         $total[] = $new;
                    }
                }
                elseif( is_dir( $new ) )
                {
                    $this->readDirRecursively( $new, $total, $onlyWithExtension );
                }
            }
        }
    }

    public function interact( $template, $tplSource, $expected, $actual, $expectedFile, $help )
    {

        while ( true )
        {
            echo "Action (g/c/r/d/do/de/ds/dc/dta/dtt/dd/ge/ee/es/v/q/?): ";

            $reply = strtolower( trim( fgets( $this->stdin ) ) );

            if ( $reply == "q" )
            {
                exit(0);
            }
            elseif( $reply == "v" )
            {
                echo ( "\n" );
                echo ( str_pad( "Compile path: ", 17) . $template->configuration->compilePath . "\n" );
                echo ( str_pad( "Template path: ", 17 ) . $template->configuration->templatePath . "\n" );
                echo ( str_pad( "Source path: ", 17 ) . $tplSource . " \n" );
                echo ( str_pad( "Expected output: ", 17 ) . $expectedFile . " \n" );
                echo ( "\n" );
                echo (  str_pad( "Context: ", 17 ) . get_class( $template->configuration->context ) );

                echo( "\n" );

                continue;
            }
            elseif ( $reply == "r" )
            {
                $this->retryTest = true;
                return;
            }
            elseif ( $reply == "g" )
            {
                file_put_contents( $expectedFile, $actual );
                return;
            }
            elseif ( $reply == "do" || $reply == "de" || $reply == "ds" || $reply == "dc" || $reply == "dta" || $reply == "dtt" || $reply == "dd" || $reply == "d" )
            {
                $displayText = false;

                if ( $reply == "ds" || $reply == "d" )
                {
                    if ( $reply == "d" )
                    {
                        $displayText .= "------Source template------\n";
                    }
                    $displayText .= file_get_contents( $tplSource );
                }
                if ( $reply == "do" || $reply == "d" )
                {
                    if ( $reply == "d" )
                    {
                        $displayText .= "------Generated output------\n";
                    }
                    $displayText .= $actual;
                }
                if ( $reply == "de" || $reply == "d" )
                {
                    if ( $reply == "d" )
                    {
                        if ( file_exists( $expectedFile ) )
                        {
                            $displayText .= "------Expected output------\n";
                        }
                        else
                        {
                            $displayText .= "------Expected output (file missing)------\n";
                        }
                    }
                    $displayText .= $expected;
                }
                if ( $reply == "dd" || $reply == "d" )
                {
                    if ( $reply == "d" )
                    {
                        $displayText .= "------Diff of output------\n";
                    }
                    if ( PHP_OS == 'Linux' )
                    {
                        $expectedTmp = $this->getTempDir() . "/expected.tmp";
                        $actualTmp = $this->getTempDir() . "/actual.tmp";
                        file_put_contents( $expectedTmp, $expected );
                        file_put_contents( $actualTmp, $actual );
                        $displayText .= shell_exec( "diff -U3 '$expectedTmp' '$actualTmp'" );
                        unlink( $expectedTmp );
                        unlink( $actualTmp );
                    }
                    else
                    {
                    }
                }
                if ( $reply == "dc" || $reply == "d" )
                {
                    if ( file_exists( $template->compiledTemplatePath ) )
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------Compiled PHP code------\n";
                        }
                        $code = file_get_contents( $template->compiledTemplatePath );
                        $code = str_replace( "<"."?php", "", $code );
                        $displayText .= str_replace( "?" . ">", "", $code );
                    }
                    else
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------Compiled PHP code not found------\n";
                        }
                        else
                        {
                            echo "The compiled file <" . $template->compiledTemplatePath . "> was not found\n";
                            echo "This usually means the template file contained syntax errors\n";
                            continue;
                        }
                    }
                }

                if ( $reply == "dtt" || $reply == "d" )
                {
                    // NOTE: This currently fails due to missing implementations in the Tst class.
                    if ( $template->tstTree instanceof ezcTemplateTstNode )
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------TST------\n";
                        }

                        $displayText .= ezcTemplateTstTreeOutput::output( $template->tstTree );
                        $displayText .= "\n";
                    }
                    else
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------TST tree not available------\n";
                        }
                        else
                        {
                            echo "The TST tree is not available\n";
                            continue;
                        }
                    }
                }
                if ( $reply == "dta" || $reply == "d" )
                {
                    if ( $template->astTree instanceof ezcTemplateAstNode )
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------AST------\n";
                        }
                        $displayText .= ezcTemplateAstTreeOutput::output( $template->astTree );
                    }
                    else
                    {
                        if ( $reply == "d" )
                        {
                            $displayText .= "------AST tree not available------\n";
                        }
                        else
                        {
                            echo "The AST tree is not available\n";
                            continue;
                        }
                    }
                }
                if ( PHP_OS == 'Linux' )
                {
                    // Pipe the text to less
                    $l = popen( "less", "w" );
                    fwrite( $l, $displayText );
                    pclose( $l );
                    continue;
                }
                else
                {
                    echo $displayText, "\n";
                }
            }
            elseif ( $reply == 'c' )
            {
                throw new PHPUnit_Framework_ExpectationFailedException( $help );
            }
            elseif ( $reply == 'c!' )
            {
                $this->skipMissingTests = true;
                throw new PHPUnit_Framework_ExpectationFailedException( $help );
            }
            elseif ($reply == "ir" )
            {
                if( file_exists( $tplSource.".tmp" ) )
                {
                    echo "Cannot rename the file to: {$tplSource}.tmp because the file already exists\n";
                    continue;
                }

                echo ( "renaming: " .  $tplSource . " to: " . $tplSource.".tmp\n"   );
                rename ( $tplSource, $tplSource.".tmp" );

                throw new PHPUnit_Framework_ExpectationFailedException( $help );
            }
            elseif ( $reply == "ge" || $reply == "ee" )
            {
                $editor = ( isset($_ENV["EDITOR"] ) && $_ENV["EDITOR"] != "" ) ? $_ENV["EDITOR"] : "vi";

                if( $reply == "ge" )
                {
                    file_put_contents( $expectedFile, $actual );
                }

                passthru( $editor . " " . escapeshellcmd( $expectedFile ) );
                continue;
            }
            elseif ( $reply == "es" )
            {
                $editor = ( isset($_ENV["EDITOR"] ) && $_ENV["EDITOR"] != "" ) ? $_ENV["EDITOR"] : "vi";

                passthru( $editor . " " . escapeshellcmd( $tplSource ) );
                continue;
            }
            elseif ( $reply == '?' )
            {
                echo "The actions are:\n",
                    "g  - Generate output file (Implies success of test)\n",
                    "c  - Continue, Skip the current test (Implies failure of test)\n",
                    "c! - Continue, Skip all test with a missing out file.\n",
                    "r  - Retry the test\n",

                    "do  - Display the generated output\n",
                    "de  - Display the expected output\n",
                    "ds - Display source template\n",
                    "dc - Display generated/compiled PHP code\n",
                    "d - Display all\n",

                    "dta - Display the AST tree\n",
                    "dtt - Display the TST tree\n",

                    "dd  - Display difference between generated output and expected output\n",
                    
                    "v  - Display verbose template information\n",
                    "q  - Quit\n",

                    "ir - Input Rename. Rename the input file so that it won't be available in the next run.\n",

                    "ge - Generate and edit the expected output file.\n";
                    "ee - Edit the expected output file.\n";
                    "es - Edit the source file.\n";

/*
                    "g  - Generate output file (Implies success of test)\n",
                    "s  - Skip this test (Implies failure of test)\n",
                    "sm - Skip all missing tests\n",
                    "r  - Retry the test\n",

                    "o  - Display the generated output\n",
                    "e  - Display the expected output\n",
                    "st - Display source template\n",
                    "sp - Display generated/compiled PHP code\n",
                    "at - Display the AST tree\n",
                    "tt - Display the TST tree\n",
                    "d  - Display difference between generated output and expected output\n",
                    "a  - Display all of the above (o,e,st,sp,at,tt,d)\n",
                    "v  - Display verbose template information\n",
                    "ren- Rename a input test from *.in to *.in.tmp\n",
                    "q  - Quit\n";
 */
                continue;
            }
            else
            {
                continue;
            }

            return; // No more testing to be done now since the file is generated
        }
    }

    public function testRunRegression( $directory )
    {
            $template = new ezcTemplate();
            $dir = dirname( $directory );
            $base = basename( $directory );

            $template->configuration = new ezcTemplateConfiguration( $dir, $this->getTempDir() );
            //$template->configuration->cachePath = $this->getTempDir() . "/cached"; 
            //$template->configuration->cachePath = "/tmp/cache";

            /*
            if( !is_dir( $template->configuration->cachePath ) )
            {
                mkdir( $template->configuration->cachePath);
            }
             */

            $template->configuration->addExtension( "TestBlocks" );
            $template->configuration->addExtension( "LinksCustomBlock" );
            $template->configuration->addExtension( "cblockTemplateExtension" );
            $template->configuration->addExtension( "Sha1CustomBlock" );

            if( preg_match("#^(\w+)@(\w+)\..*$#", $base, $match ) )
            {
                $contextClass = "ezcTemplate". ucfirst( strtolower( $match[2] ) ) . "Context";
                $template->configuration->context = new $contextClass();
            }
            else
            {
                $template->configuration->context = new ezcTemplateNoContext();
            }

            $send = substr( $directory, 0, -3 ) . ".send";
            if( file_exists( $send ) )
            {
                $template->send = include ($send);
            }

            $out = "";

            try
            {
                $out = $template->process( $base );
            } 
            catch (Exception $e )
            {
                $out = $e->getMessage();

                // Begin of the error message contains the full path. We replace this with 'mock' so that the 
                // tests work on other systems as well.
                if( strncmp( $out, $directory, strlen( $directory ) ) == 0 )
                {
                    $out = "mock" . substr( $out, strlen( $directory ) );
                }
            }

            $expected = substr( $directory, 0, -3 ) . ".out";

            if( !file_exists( $expected ) ) 
            {
                $help = "The out file: '$expected' could not be found.";

                if( !$this->skipMissingTests && $this->interactiveMode )
                {
                    echo "\n", $help, "\n";

                    self::interact( $template, $directory, false, $out, $expected, $help );
                    return;
                }
                else
                {
                    throw new PHPUnit_Framework_ExpectationFailedException( $help );
                }
            }

            $expectedText = file_get_contents( $expected );

            try
            {
                $this->assertEquals( $expectedText, $out, "In:  <$expected>\nOut: <$directory>" );
            }
            catch ( PHPUnit_Framework_ExpectationFailedException $e )
            {
                $help  = "The evaluated template <".$this->regressionDir . "/current.tmp> differs ";
                $help .= "from the expected output: <$expected>.";
                if( $this->interactiveMode )
                {
                    echo "\n", $help, "\n";
                    self::interact( $template, $directory, file_get_contents( $expected ), $out, $expected, $help );
                    return;
                }

                // Rethrow with new and more detailed message
                throw new PHPUnit_Framework_ExpectationFailedException( $help, $e->getComparisonFailure() );
            }

                // check the receive variables.
                $receive = substr( $directory, 0, -3 ) . ".receive";
                if( file_exists( $receive ) )
                {
                    $expectedVar = include( $receive );
                    $foundVar = $template->receive;
                    $this->assertEquals( $expectedVar, $foundVar, "Received variables does not match" );
                }
    }
}



?>
