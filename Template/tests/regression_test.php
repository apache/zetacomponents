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
class ezcTemplateRegressionTest extends ezcTestCase
{
    public $requestRegeneration = true;

    public $showTreesOnFailure = true;

    private $stdin = null;

    public function __construct()
    {
        parent::__construct();

        if( $this->requestRegeneration )
        {        
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

    public static function suite()
    {
         return new ezcTestSuite( __CLASS__ );
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

    public function testRunRegression()
    {
        $regressionDir = dirname(__FILE__) . "/regression_tests";
        $this->createTempDir( "regression_compiled_" );

        $directories = array();
        $this->readDirRecursively( $regressionDir, $directories, "in" );

        // Sort it, than the file a.in will be processed first. Handy for development.
        natsort( $directories );

        foreach( $directories as $directory )
        {
            $template = new ezcTemplate();

            $dir = dirname( $directory );
            $base = basename( $directory );

            $template->configuration = new ezcTemplateConfiguration( $dir, $this->getTempDir() );

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
                $help = "The file: <$expected> could not be found.";

                if( $this->requestRegeneration )
                {
                    echo $help;

                    echo "Do you want to create this file? (y/n)";

                    $char = fgetc( $this->stdin );

                    if ($char == "y" || $char == "Y" )
                    {
                        file_put_contents( $expected, $out );
                    }
                }
                else
                {
                    $this->fail( $help );
                }
            }
            else if ( file_get_contents( $expected ) != $out )
            {
                $help  = "The evaluated template <".$regressionDir . "/current.tmp> differs ";
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
                $help .= "----------\n".$out."----------\n";
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
                        file_put_contents( $expected, $out );
                    }
                }
                else
                {
                    $this->fail( $help );
                }

                $this->fail( $help );
            }
            else
            {
                // check the receive variables.
                $receive = substr( $directory, 0, -3 ) . ".receive";
                if( file_exists( $receive ) )
                {
                    $expectedVar = serialize( include( $receive ) );
                    $foundVar = serialize( $template->receive );
                    if( $expectedVar != $foundVar )
                    {
                        echo ("Expected:\n". $expectedVar . "\n\n Found:\n $foundVar\n" );
                    }
                }

                echo "*";
            }
        }

        $this->removeTempDir();
    }
}



?>
