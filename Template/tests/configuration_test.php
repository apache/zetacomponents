<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once 'test_classes.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateConfigurationTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateConfigurationTest" );
    }

    protected function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

// Doesn't work if other tests are run as well.
//    public function testDelayedInit()
//    {
//        ezcBaseInit::setCallback( 'ezcInitTemplateConfiguration', 'testDelayedInitTemplateConfiguration' );
//        $config = ezcTemplateConfiguration::getInstance();
//        $this->assertEquals( new ezcTemplateNoContext, $config->context );
//    }

    public function testDefault()
    {
        $conf = new ezcTemplateConfiguration();

        $this->assertSame( '.', $conf->templatePath );
        $this->assertSame( './compiled_templates', $conf->compilePath . DIRECTORY_SEPARATOR . $conf->compiledTemplatesPath);
    }

    public function testInit()
    {
        $conf = new ezcTemplateConfiguration( 'templates', 'compiled' );

        $this->assertSame( 'templates', $conf->templatePath );
        $this->assertSame( 'compiled/compiled_templates', $conf->compilePath . DIRECTORY_SEPARATOR . $conf->compiledTemplatesPath );
    }

    public function testInvalidProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to access non-existing property
        try
        {
            $invalid = $conf->invalid;
            self::fail( 'Property invalid does not throw not-found exception' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
        }
    }

    public function testModifyProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to set invalid types for autoloadDefinitions
        $this->assertSetPropertyFails( $conf, 'autoloadDefinitions',
                                       array( true, false, 2, 2.0, 'string' ) );
        // Try to set valid path entries
        $this->assertSetProperty( $conf, 'templatePath',
                                  array( 'templates', '.', '/var/templates' ) );
        $this->assertSetProperty( $conf, 'compilePath',
                                  array( 'compiled-templates', '.', '/var/cache/templates' ) );
    }

//     public function testAutoloaderRegistration()
//     {
//         throw new PHPUnit_Framework_IncompleteTestError;
//     }
}

?>
