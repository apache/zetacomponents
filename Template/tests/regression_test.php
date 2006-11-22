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
 */
include_once ("custom_blocks/testblocks.php");
include_once ("custom_blocks/links.php");
include_once ("custom_blocks/cblock.php");

class ezcTemplateRegressionTest extends ezcTestCase
{
    public $interactiveMode = false;

    public $requestRegeneration = false;

    public $showTreesOnFailure = false;

    public $directories = array();

    public $regressionDir = '';

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

        // Turn of generation if interactivity is not allowed
        if ( !$this->interactiveMode )
            $this->requestRegeneration = false;

        if( $this->requestRegeneration )
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
            $result = new PHPUnit_Framework_TestResult;
        }

        $this->setUp();

        foreach ( $this->directories as $directory )
        {
            $result->startTest($this);

            try {
                $this->testRunRegression( $directory );
            }

            catch (PHPUnit_Framework_AssertionFailedError $e) {
                $result->addFailure($this, $e, time() );
            }

            catch (Exception $e) {
                $result->addError($this, $e, time() );
            }

            $result->endTest($this, time());
        }

        $this->removeTempDir();

        return $result;
    }

    protected function setUp()
    {
        date_default_timezone_set( "UTC" );
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

            $out = array();
            $counter = 0;

            try
            {
                $out[$counter] = $template->process( $base );

                ++$counter;
                while( file_exists( substr( $directory, 0, -3 ) . ".out" . ($counter + 1) ) )
                {
                    if( file_exists( substr( $directory, 0, -3 ). ".send". ($counter + 1) ) )
                    {
                        $template->send = include (substr( $directory, 0, -3 ). ".send". ($counter + 1));
                    }

                    $out[$counter] = $template->process( $base );
                    $counter++;
                } 
            } 
            catch (Exception $e )
            {
                $out[$counter] = $e->getMessage();

                // Begin of the error message contains the full path. We replace this with 'mock' so that the 
                // tests work on other systems as well.
                if( strncmp( $out[$counter], $directory, strlen( $directory ) ) == 0 )
                {
                    $out[$counter] = "mock" . substr( $out[$counter], strlen( $directory ) );
                }
            }

            $expected = substr( $directory, 0, -3 ) . ".out";

            if( !file_exists( $expected ) ) 
            {
                $help = "The out file: <$expected> could not be found.";

                if( $this->requestRegeneration )
                {
                    echo $help;

                    echo "Do you want to create this file? (y/n)";

                    $char = fgetc( $this->stdin );

                    if ($char == "y" || $char == "Y" )
                    {
                        file_put_contents( $expected, $out[$counter] );
                    }
                    return; // No more testing to be done now since the file is generated
                }
                else
                {
                    throw new PHPUnit_Framework_ExpectationFailedException( $help );
                }
            }

            $expectedText = file_get_contents( $expected );
            $actualText = $out[0];

            try
            {
                $this->assertEquals( $expectedText, $actualText, "In:  <$expected>\nOut: <$directory>" );
            }
            catch ( PHPUnit_Framework_ExpectationFailedException $e )
            {
                if ( $this->interactiveMode )
                {
                $help  = "The evaluated template <".$this->regressionDir . "/current.tmp> differs ";
                $help .= "from the expected output: <$expected>.\n\n";

                $help .= "The original template <$directory>:\n";
                $help .= "----------\n".file_get_contents( $directory ) . "----------\n";
                $help .= "\n";

                $cont = file_get_contents( $template->compiledTemplatePath );
                $cont = str_replace( "<"."?php", "", $cont );
                $cont = str_replace( "?" . ">", "", $cont ); 

                $help .= "The compiled template:\n";
                $help .= "----------\n".$cont."----------\n";
                $help .= "\n";

                $help .= "The eval'ed output:\n";
                $help .= "----------\n".$out[0]."----------\n";
                $help .= "\n";

                $help .= "The expected output:\n";
                $help .= "----------\n" . file_get_contents( $expected ) . "----------\n";
                $help .= "\n";

                if( $this->showTreesOnFailure && $template->tstTree !== false )
                {
                    $help .= "The TST tree:\n";
                    $help .= "----------\n" . ezcTemplateTstTreeOutput::output( $template->tstTree )  . "----------\n";
                    $help .= "\n";
                }

                if( $this->showTreesOnFailure && $template->astTree !== false )
                {
                    $help .= "The AST tree:\n";
                    $help .= "----------\n" . ezcTemplateAstTreeOutput::output( $template->astTree )  . "----------\n";
                    $help .= "\n";
                }

                if( $this->requestRegeneration )
                {
                    echo $help;
                    echo "Do you want to set the new file output? ";

                    $char = fgetc( $this->stdin );

                    if ($char == "y" || $char == "Y" )
                    {
                        file_put_contents( $expected, $out[0] );
                    }
                }
                // Rethrow with new and more detailed message
                throw new PHPUnit_Framework_ExpectationFailedException( $help, $e->getComparisonFailure() );
                }
                else
                {
                    throw $e;
                }
            }

/* This code will be removed soon
            if( sizeof( $out ) > 1 )
            {
                for( $i = 1; $i < sizeof( $out ); $i++ )
                {
                    $file = substr( $directory, 0, -3 ) . ".out" . ($i + 1);
                    if( file_get_contents( $file ) != $out[$i] )
                    {
                        $help =  "\nRun ". ($i + 1) . " returns a different value than expected.\n";
                        $help .= "file: $file \n\n";

                        $help .= "The eval'ed output:\n";
                        $help .= "----------\n".$out[$i]."----------\n";
                        $help .= "\n";

                        $help .= "The expected output:\n";
                        $help .= "----------\n" . file_get_contents( substr( $directory, 0, -3 ) . ".out" . ($i + 1)  ) . "----------\n";
                        $help .= "\n";

                        die ( $help );
                    }
                }
            }*/
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
