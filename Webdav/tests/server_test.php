<?php
/**
 * Basic test cases for the server class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Additional transport for testing. 
 */
require_once 'classes/transport_test_mock.php';

/**
 * Tests for ezcWebdavServer class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavBasicServerTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavBasicServerTest' );
	}

    public function testSingleton()
    {
        $srv = ezcWebdavServer::getInstance();
        $srv2 = ezcWebdavServer::getInstance();

        $this->assertSame( $srv, $srv2 );
    }

    public function testCtor()
    {
        $srv = ezcWebdavServer::getInstance();

        $this->assertAttributeEquals(
            array(
                'configurations'  => new ezcWebdavServerConfigurationManager(),
                'pluginRegistry'  => new ezcWebdavPluginRegistry(),
                'auth'            => null,
                'options'         => new ezcWebdavServerOptions(),
                'transport'       => null,
                'backend'         => null,
                'pathFactory'     => null,
                'xmlTool'         => null,
                'propertyHandler' => null,
                'headerHandler'   => null,
            ),
            'properties',
            $srv
        );
    }

    public function testGetPropertiesDefaultSuccess()
    {
        $srv = ezcWebdavServer::getInstance();

        $defaults = array(
            'transport'       => null,
            'backend'         => null,
            'configurations'  => new ezcWebdavServerConfigurationManager(),
            'pluginRegistry'  => new ezcWebdavPluginRegistry(),
            'auth'            => null,
            'options'         => new ezcWebdavServerOptions(),
            'xmlTool'         => null,
            'propertyHandler' => null,
            'headerHandler'   => null,
            'pathFactory'     => null,
        );

        foreach ( $defaults as $property => $value )
        {
            $this->assertEquals(
                $value,
                $srv->$property,
                "Property $property has incorrect default."
            );
        }
    }

    public function testGetPropertiesFailure()
    {
        $srv = ezcWebdavServer::getInstance();

        try
        {
            echo $srv->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Property not thrown on get access of non-existent property.' );
    }

    public function testSetPropertiesGetPropertiesSuccess()
    {
        $srv = ezcWebdavServer::getInstance();

        $auth = $this->getMock( 'ezcWebdavBasicAuthenticator' );

        $setValues = array(
            'configurations' => new ezcWebdavServerConfigurationManager(),
            'options'        => new ezcWebdavServerOptions(),
            'auth'           => $auth,
        );
        $checkValues = array(
            'configurations'  => new ezcWebdavServerConfigurationManager(),
            'pluginRegistry'  => new ezcWebdavPluginRegistry(),
            'auth'            => $auth,
            'options'         => new ezcWebdavServerOptions(),
            'transport'       => null,
            'backend'         => null,
            'pathFactory'     => null,
            'xmlTool'         => null,
            'propertyHandler' => null,
            'headerHandler'   => null,
        );

        foreach( $setValues as $property => $value )
        {
            $srv->$property = $value;
        }

        $this->assertAttributeEquals(
            $checkValues,
            'properties',
            $srv
        );

        foreach ( $checkValues as $property => $value )
        {
            $this->assertEquals(
                $value,
                $srv->$property,
                "Property $property has incorrect value after ctor setting."
            );
        }
    }

    public function testSetAccessFailure()
    {
        $typicalFails = array(
            '',
            23,
            23.42,
            true,
            false,
            array(),
            new stdClass(),
        );

        $invalidValues = array(
            'configurations' => $typicalFails, 
            'options'        => $typicalFails,
        );

        foreach ( $invalidValues as $propertyName => $propertyValues )
        {
            $this->assertSetPropertyFailure( $propertyName, $propertyValues, 'ezcBaseValueException' );
        }

        try
        {
            $srv = ezcWebdavServer::getInstance();
            $srv->pluginRegistry = 23;
            $this->fail( 'Exception not thrown on set access to read-only property.' );
        }
        catch ( ezcBasePropertyPermissionException $e ){}

        try
        {
            $srv = ezcWebdavServer::getInstance();
            $srv->transport = 23;
            $this->fail( 'Exception not thrown on set access to read-only property.' );
        }
        catch ( ezcBasePropertyPermissionException $e ){}

        try
        {
            $srv = ezcWebdavServer::getInstance();
            $srv->fooBar = 23;
            $this->fail( 'Exception not thrown on set access to non-existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ){}
    }

    public function testPropertiesIssetAccessDefaultCtorSuccess()
    {
        $srv = ezcWebdavServer::getInstance();

        $properties =array(
            'configurations', 
            'backend', 
            'pluginRegistry', 
            'transport', 
            'xmlTool',
            'propertyHandler',
            'pathFactory',
            'auth',
            'options',
        );

        foreach( $properties as $propertyName )
        {
            $this->assertTrue(
                isset( $srv->$propertyName ),
                "Property not set after default construction: '$propertyName'."
            );
        }
    }

    public function testPropertyIssetAccessFailure()
    {
        $srv = ezcWebdavServer::getInstance();

        $this->assertFalse(
            isset( $srv->foo ),
            'Non-existent property $foo seems to be set.'
        );
        $this->assertFalse(
            isset( $srv->properties ),
            'Non-existent property $properties seems to be set.'
        );
    }

    public function testDefaultHandlerWithUnknowClient()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'unknown';
        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $_SERVER['SERVER_NAME'] = 'webdav';
        $_SERVER['REQUEST_URI'] = '/foo/bar';

        $webdav  = ezcWebdavServer::getInstance();

        // Fake pathfactory, because SCRIPT_FILENAME cannot be overwritten
        $pathFactory = new ezcWebdavBasicPathFactory( 'http://webdav/' );
        foreach( $webdav->configurations as $transportCfg )
        {
            $transportCfg->pathFactory = $pathFactory;
        }

        $backend = new ezcWebdavMemoryBackend();

        // Silence warning of headers already been send, but keep other errors
        $errRep = error_reporting( ( E_ALL | E_STRICT ) & ~E_WARNING );

        // Avoid printing response
        ob_start();

        // Silence headers already sent warnings - we just want to test for
        // exceptions here.
        $webdav->handle( $backend );
        
        // Clean OB res (no need to process it)
        $body = ob_get_clean();
        
        // Reset old error level
        error_reporting( $errRep );
    }

    public function testDefaultHandlerWithUnknowClientAdditionalHandler()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'unknown';
        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $_SERVER['SERVER_NAME'] = 'webdav';
        $_SERVER['REQUEST_URI'] = '/foo/bar';

        $webdav  = ezcWebdavServer::getInstance();
        $webdav->configurations->insertBefore(
            new ezcWebdavServerConfiguration(
                '(.*SomeAgent.*)',
                'ezcWebdavTransportTestMock'
            )
        );
        
        // Fake pathfactory, because SCRIPT_FILENAME cannot be overwritten
        $pathFactory = new ezcWebdavBasicPathFactory( 'http://webdav/' );
        foreach( $webdav->configurations as $transportCfg )
        {
            $transportCfg->pathFactory = $pathFactory;
        }

        $backend = new ezcWebdavMemoryBackend();

        // Silence warning of headers already been send, but keep other errors
        $errRep = error_reporting( ( E_ALL | E_STRICT ) & ~E_WARNING );

        // Avoid printing response
        ob_start();

        // Silence headers already sent warnings - we just want to test for
        // exceptions here.
        $webdav->handle( $backend );
        
        // Clean OB res (no need to process it)
        $body = ob_get_clean();
        
        // Reset old error level
        error_reporting( $errRep );
    }

    protected function assertSetPropertyFailure( $propertyName, array $propertyValues, $exceptionClass )
    {
        foreach ( $propertyValues as $value )
        {
            try
            {
                $srv = ezcWebdavServer::getInstance();
                $srv->$propertyName = $value;
                $this->fail( "Exception not thrown on invalid ___set() value for property '$propertyName'." );
            }
            catch( Exception $e )
            {
                $this->assertTrue(
                    ( $e instanceof $exceptionClass ),
                    "Exception thrown on invalid value set for property '$propertyName'. '" . get_class( $e ) . "' instead of '$exceptionClass'."
                );
            }
        }
    }
}
?>
