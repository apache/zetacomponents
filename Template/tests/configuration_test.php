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
class ezcTemplateConfigurationTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateConfigurationTest" );
    }

    public function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

    public function testDefault()
    {
        $conf = new ezcTemplateConfiguration();

        self::assertPropertySame( $conf, 'templatePath',        "." );
        self::assertPropertySame( $conf, 'compiledPath',        "." );
        self::assertPropertySame( $conf, 'autoloadList',        false );
        self::assertPropertySame( $conf, 'autoloadDefinitions', array() );
        self::assertPropertySame( $conf, 'resourceLocators',    array() );
    }

    public function testInit()
    {
        $conf = new ezcTemplateConfiguration( 'templates', 'compiled' );

        self::assertPropertySame( $conf, 'templatePath',        "templates" );
        self::assertPropertySame( $conf, 'compiledPath',        "compiled" );
        self::assertPropertySame( $conf, 'autoloadList',        false );
        self::assertPropertySame( $conf, 'autoloadDefinitions', array() );
        self::assertPropertySame( $conf, 'resourceLocators',    array() );
    }

    public function testReadOnlyProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to set a read-only property
        try
        {
            $conf->autoloadList = array();
            self::fail( 'Property autoloadList does not throw read-only exception' );
        }
        catch( ezcBasePropertyPermissionException $e )
        {
        }
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
        catch( ezcBasePropertyNotFoundException $e )
        {
        }
    }

    public function testModifyProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to set invalid types for autoloadDefinitions
        $this->assertSetPropertyFails( $conf, 'autoloadDefinitions',
                                       array( true, false, 2, 2.0, 'string' ) );
        // Try to set valid arrays
        $this->assertSetProperty( $conf, 'autoloadDefinitions',
                                  array( array(),
                                         array( new ezcTemplateAutoloaderDefinition( 'path/to/file.php', 'autoloader' ) ) ) );

        // Try to set valid path entries
        $this->assertSetProperty( $conf, 'templatePath',
                                  array( 'templates', '.', '/var/templates' ) );
        $this->assertSetProperty( $conf, 'compiledPath',
                                  array( 'compiled-templates', '.', '/var/cache/templates' ) );
    }

//     public function testAutoloaderRegistration()
//     {
//         throw new PHPUnit2_Framework_IncompleteTestError;
//     }
}

?>
