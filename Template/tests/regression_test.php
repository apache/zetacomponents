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
    public $requestRegeneration = false;

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

    public function setUp()
    {
        //// required because of Reflection autoload bug
        class_exists( 'ezcTemplateSourceCode' );
        //class_exists( 'ezcTemplateManager' );
        $this->manager = new ezcTemplateManager();
        //ezcMock::generate( 'ezcTemplateParser', array( "reportElementCursor" ), 'MockElement_ezcTemplateParser' );

        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

    public function tearDown()
    {
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

        $directories = array();
        $this->readDirRecursively( $regressionDir, $directories, "in" );

        foreach( $directories as $directory )
        {
            list( $tstRoot, $astRoot ) = $this->compileTemplate( $directory, $regressionDir . "/current.tmp" ); 

            $cont = file_get_contents( $regressionDir . "/current.tmp" );

            $cont = str_replace( "<"."?php", "", $cont );
            $cont = str_replace( "?" . ">", "", $cont ); 

            ob_start();

            eval( $cont );
            $out = ob_get_contents();

            ob_end_clean();

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

                $help .= "The compiled template:\n";
                $help .= "----------\n".$cont."----------\n";
                $help .= "\n";

                $help .= "The eval'ed output:\n";
                $help .= "----------\n".$out."----------\n";
                $help .= "\n";

                $help .= "The expected output:\n";
                $help .= "----------\n" . file_get_contents( $expected ) . "----------\n";
                $help .= "\n";

                $help .= "The TST tree:\n";
                $help .= "----------\n" . $tstRoot->outputTree()  . "----------\n";
                $help .= "\n";

                $help .= "The AST tree:\n";
                $help .= "----------\n" . $astRoot->getTreeRepresentation()  . "----------\n";
                $help .= "\n";



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
                echo "!";
            }
        }
    }

    public function compileTemplate($input, $output)
    {
        $text = file_get_contents( $input );

        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new ezcTemplateParser( $source, $this->manager );

        $parser->trimWhitespace = false;
        $root = $parser->parseIntoTextElements();
        //echo $root->outputTree();

        $tstToAst = new ezcTemplateTstToAstTransformer();
        $root->accept( $tstToAst );

        $g = new ezcTemplateAstToPhpGenerator( "$output" );
        $tstToAst->rootNode->accept($g);

        return array( $root, $tstToAst->rootNode );
    }
}



?>
