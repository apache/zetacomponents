<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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


}


?>
