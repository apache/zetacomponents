<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
include_once("override.php");

class ezcTemplateTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Create some variables which point to the correct template directory.
     * This is prepended to all created path values to ensure tests where
     * they are installed.
     */
    protected function setUp()
    {
        /*
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
*/
        $this->basePath = $this->createTempDir( "ezcTemplate_" );
        $this->templatePath = $this->basePath . "/templates";
        $this->compilePath = $this->basePath . "/compiled";

        mkdir ( $this->templatePath );
        mkdir ( $this->compilePath );

        $config = ezcTemplateConfiguration::getInstance();
        $config->templatePath = $this->templatePath;
        $config->compilePath = $this->compilePath;

        $config2 = ezcTemplateConfiguration::getInstance("templates");
        $config2->templatePath = realpath( dirname( __FILE__ ) ) . '/' . 'templates';
        $config2->compilePath = $this->compilePath;
    }

    protected function tearDown()
    {
        $tc = ezcTemplateConfiguration::getInstance();
        $tc->executeTemplate = true;
        $this->removeTempDir();
    }

    /**
     * Creates manager with initialised values and check the properties.
     */
    public function testInit()
    {
        $template = new ezcTemplate();

        self::assertFalse( isset( $template->configuration ), "Property 'configuration' is already set, but it should be set only after it has been 'get' before." );
        self::assertSame( 'ezcTemplateConfiguration', get_class( $template->configuration ),
                          'Property <configuration>' );
        self::assertTrue( isset( $template->configuration ), "Property 'configuration' is not set, even after requesting it." );
    }

    public function testReExecuteTemplate()
    {
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Hello world" );

        $template = new ezcTemplate();
        $res = $template->process( "reexecute_template.ezt" );

        // Change the template, and set the time back. 
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Goodbye cruel world" );
        $new_date = 1114300800; // +- 24 April 2005.
        touch( $this->templatePath . "/reexecute_template.ezt", $new_date );

        $res2 = $template->process( "reexecute_template.ezt" );

        self::assertEquals( $res, $res2, "Expected the same output" );
    }

    public function testReExecuteTemplateKeepSendVariables()
    {
        file_put_contents( $this->templatePath . "/sendVar.ezt", "{use \$a}\n{\$a}" );

        $template = new ezcTemplate();
        $template->send->a = 1;
        $res = $template->process( "sendVar.ezt" );
        self::assertEquals("1", $res);

        $res = $template->process( "sendVar.ezt" ); # Run again, send->a == 1 (implicitly set from the previous run)
        self::assertEquals("1", $res);

        $template->send = new ezcTemplateVariableCollection();
        try
        {
            $res = $template->process( "sendVar.ezt" ); # Run again, send->a is not set.
            $this->fail( "Expected an ezcTemplateRuntimeException");
        }
        catch ( ezcTemplateRuntimeException $e)
        {
        }
    }


    public function testReCompileTemplate()
    {
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Hello world" );

        $template = new ezcTemplate();
        $res = $template->process( "reexecute_template.ezt" );

        // Change the template
        sleep(1);
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Goodbye cruel world" );

        $res2 = $template->process( "reexecute_template.ezt" );

        self::assertEquals( "Goodbye cruel world", $res2 );
    }

    public function testSkipReCompileTemplate()
    {
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Hello world" );

        $template = new ezcTemplate();
        $res = $template->process( "reexecute_template.ezt" );

        // Change the template
        file_put_contents( $this->templatePath . "/reexecute_template.ezt", "Goodbye cruel world" );

        $noCheckConfig = clone ezcTemplateConfiguration::getInstance();
        $noCheckConfig->checkModifiedTemplates = false;
        $res2 = $template->process( "reexecute_template.ezt", $noCheckConfig );

        self::assertEquals( "Hello world", $res2 );
    }

    public function testNoTemplateNameGiven()
    {
        $template = new ezcTemplate();

        try
        {
            $template->process("");
            $this->fail( "Expected an ezcTemplateFileNotFoundException");
        } 
        catch (ezcTemplateFileNotFoundException $e )
        {
        }
    }

    public function testOverride()
    {
        $template = new ezcTemplate();

        $o = new OverrideLocation( "override_test");
        $out = $template->process($o, ezcTemplateConfiguration::getInstance("templates"));

        $this->assertEquals("Yes\n", $out);
    }


    public function testOverrideInTemplate()
    {
        $template = new ezcTemplate();

        $o = new OverrideLocation( "override_in_template");

        $c = ezcTemplateConfiguration::getInstance("templates");
        $c->addExtension("OverrideCustomFunction");
        $out = $template->process($o, $c);

        $this->assertEquals("[\nYes\n]\n", $out);
    }

    public function testOverrideWithNewInterface()
    {
        $template = new ezcTemplate();

        $o = new OverrideLocationNew( "override_test");
        $out = $template->process($o, ezcTemplateConfiguration::getInstance("templates"));

        $this->assertEquals("Yes\n", $out);
    }


    public function testOverrideInTemplateWithNewInterface()
    {
        $template = new ezcTemplate();

        $o = new OverrideLocationNew( "override_in_template");

        $c = ezcTemplateConfiguration::getInstance("templates");
        $c->addExtension("OverrideCustomFunctionNew");
        $out = $template->process($o, $c);

        $this->assertEquals("[\nYes\n]\n", $out);
    }

    public function testTemplateLocator()
    {
        $c = ezcTemplateConfiguration::getInstance( 'templates' );
        $c->locator = new PathResolver();

        $template = new ezcTemplate();
        $out = $template->process( 'test1.ezt', $c );

        $this->assertEquals("[\nYes\n]\n", $out);
    }

    public function testTemplateFileNotWriteableException()
    {
        file_put_contents( $this->templatePath . "/test.ezt", "Hello world" );

        $template = new ezcTemplate();
        $conf = ezcTemplateConfiguration::getInstance();
        $conf->compilePath = $this->basePath . "/not_writable";
        $out = $template->process( "test.ezt", $conf );
        self::assertEquals( "Hello world", $out);


        $a = glob($conf->compilePath . "/compiled_templates/xhtml-*/*.php");
        $path = $a[0];
        chmod($path, 0500); // Read only.
        chmod(dirname( $path ), 0500); // Read only.
        sleep(1);
        touch ($this->templatePath . "/test.ezt");
        try
        {
            $out = $template->process( "test.ezt", $conf );
            self::fail("Expected a FileNotWriteableException");
        }
        catch ( ezcTemplateFileNotWriteableException $e )
        {
            chmod($path, 0700 ); // Changed in order to be deleted
            chmod(dirname( $path ), 0700 ); // Changed in order to be deleted
        }

    }

    public function testTemplateFileNotWriteableException2()
    {
        file_put_contents( $this->templatePath . "/test.ezt", "Hello world" );
        file_put_contents( $this->templatePath . "/test2.ezt", "Hello world" );

        $template = new ezcTemplate();
        $conf = ezcTemplateConfiguration::getInstance();
        $conf->compilePath = $this->basePath . "/not_writable";
        $out = $template->process( "test.ezt", $conf );
        self::assertEquals( "Hello world", $out);
        $d = glob($conf->compilePath . "/compiled_templates/xhtml-*"); // Read, Executable only
        $dir = $d[0];
        chmod($dir, 0555); // Read, Executable only

        try
        {
            $out = $template->process( "test2.ezt", $conf );
            self::fail("Expected a FileNotWriteableException");
        }
        catch ( ezcTemplateFileNotWriteableException $e )
        {
            chmod($dir, 0755 ); // Changed in order to be deleted
        }
    }

    public function testRelativeAndAbsolutePath()
    {
        file_put_contents( $this->templatePath . "/test.ezt", "Hello world" );
        file_put_contents( $this->templatePath . "/test2.ezt", "Hello world2" );

        $absPath = $this->templatePath;

        $conf = ezcTemplateConfiguration::getInstance();
        $conf->templatePath = $absPath;

        $template = new ezcTemplate();
        self::assertEquals( "Hello world",  $template->process( "test.ezt", $conf ) );

        $conf->templatePath = "/this/is/wrong";
        self::assertEquals( "Hello world2",  $template->process( $absPath  . DIRECTORY_SEPARATOR . "test2.ezt", $conf ) );
        
        try
        {
            self::assertEquals( "Hello world2",  $template->process( "test2.ezt", $conf ) );
            self::fail("Expected an exception");
        } catch ( ezcTemplateException $e)
        {
            self::assertEquals("The requested template file '/this/is/wrong" . DIRECTORY_SEPARATOR . "test2.ezt' does not exist.", $e->getMessage() );

        }
    }

    public function testRelativeAndAbsolutePathWindows()
    {
        file_put_contents( $this->templatePath . "/test.ezt", "Hello world" );
        file_put_contents( $this->templatePath . "/test2.ezt", "Hello world2" );

        $absPath = $this->templatePath;

        $conf = ezcTemplateConfiguration::getInstance();
        $conf->templatePath = $absPath;

        $template = new ezcTemplate();
        self::assertEquals( "Hello world",  $template->process( "test.ezt", $conf ) );

        $conf->templatePath = "C:\\this\\is\\wrong";
        self::assertEquals( "Hello world2",  $template->process( $absPath  . DIRECTORY_SEPARATOR . "test2.ezt", $conf ) );
        
        try
        {
            self::assertEquals( "Hello world2",  $template->process( "test2.ezt", $conf ) );
            self::fail("Expected an exception");
        }
        catch ( ezcTemplateException $e )
        {
            self::assertEquals("The requested template file 'C:\\this\\is\\wrong" . DIRECTORY_SEPARATOR . "test2.ezt' does not exist.", $e->getMessage() );

        }
    }

    public function testMissingUseVariable()
    {
        file_put_contents( $this->templatePath . "/test.ezt", '{use $test}{$test}' );
        $template = new ezcTemplate();
        try
        {
            $out = $template->process("test.ezt");
            self::fail("Expected an exception");
        }
        catch ( ezcTemplateException $e)
        {
            self::assertEquals("The external (use) variable", substr($e->getMessage(), 0, 27) );
            self::assertEquals("the application code", substr($e->getMessage(), -20) );

        }
    }

    public function testMissingUseVariableWithInclude()
    {
        file_put_contents( $this->templatePath . "/test.ezt", '{include "test2.ezt"}' );
        file_put_contents( $this->templatePath . "/test2.ezt", '{use $test}{$test}' );
        $template = new ezcTemplate();
        try
        {
            $out = $template->process("test.ezt");
            self::fail("Expected an exception");
        }
        catch ( ezcTemplateException $e)
        {
            self::assertEquals("The external (use) variable", substr($e->getMessage(), 0, 27) );
            self::assertNotEquals("the application code", substr($e->getMessage(), -20) );
        }
    }

    public function testCompileOnly()
    {
        file_put_contents( $this->templatePath . "/test.ezt", '{use $myVar}{$myVar}' );
        $tc = ezcTemplateConfiguration::getInstance();
        $tc->executeTemplate = false;

        self::assertEquals(0, count(glob($tc->compilePath . "/compiled_templates/xhtml-*/*.php")) );

        $template = new ezcTemplate();
        $out = $template->process("test.ezt");

        // Should work, because we compile the template only.
        $template->process("test.ezt");

        self::assertEquals(1, count(glob($tc->compilePath . "/compiled_templates/xhtml-*/*.php")) );
    }

    public function testAddExtensionTestWrong1()
    {
        $c = new ezcTemplateConfiguration();
        try
        {
            $c->addExtension( 'foo' );
            self::fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'foo' that you were trying to assign to argument 'customClass' is invalid. Allowed values are: string with classname that implements the ezcTemplateCustomBlock or ezcTemplateCustomFunction interface.", $e->getMessage() );
        }
    }

    public function testAddExtensionTestWrong2()
    {
        $c = new ezcTemplateConfiguration();
        try
        {
            $c->addExtension( array( 'foo' ) );
            self::fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'a:1:{i:0;s:3:\"foo\";}' that you were trying to assign to argument 'customClass' is invalid. Allowed values are: string with classname that implements the ezcTemplateCustomBlock or ezcTemplateCustomFunction interface.", $e->getMessage() );
        }
    }

    public function testAddExtensionTestWrong3()
    {
        $c = new ezcTemplateConfiguration();
        try
        {
            $c->addExtension( 'ezcTemplateConfiguration' );
            self::fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'ezcTemplateConfiguration' that you were trying to assign to argument 'customClass' is invalid. Allowed values are: string with classname that implements the ezcTemplateCustomBlock or ezcTemplateCustomFunction interface.", $e->getMessage() );
        }
    }

}


?>
