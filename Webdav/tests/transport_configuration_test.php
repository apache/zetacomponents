<?php
/**
 * Basic test cases for the memory backend.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Custom classes to test inheritence. 
 */
require_once 'classes/foo_custom_classes.php';

/**
 * Tests for ezcWebdavTransportConfiguration class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavTransportConfigurationTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtorSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*)',
                'transport'       => 'ezcWebdavTransport',
                'xmlTool'         => 'ezcWebdavXmlTool',
                'propertyHandler' => 'ezcWebdavPropertyHandler',
                'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
        
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)'
        );

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*Nautilus.*)',
                'transport'       => 'ezcWebdavTransport',
                'xmlTool'         => 'ezcWebdavXmlTool',
                'propertyHandler' => 'ezcWebdavPropertyHandler',
                'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
        
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'ezcWebdavCustomTransport'
        );

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*Nautilus.*)',
                'transport'       => 'ezcWebdavCustomTransport',
                'xmlTool'         => 'ezcWebdavXmlTool',
                'propertyHandler' => 'ezcWebdavPropertyHandler',
                'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
        
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool'
        );

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*Nautilus.*)',
                'transport'       => 'fooCustomTransport',
                'xmlTool'         => 'fooCustomXmlTool',
                'propertyHandler' => 'ezcWebdavPropertyHandler',
                'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
        
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool',
            'fooCustomPropertyHandler'
        );

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*Nautilus.*)',
                'transport'       => 'fooCustomTransport',
                'xmlTool'         => 'fooCustomXmlTool',
                'propertyHandler' => 'fooCustomPropertyHandler',
                'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
        
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool',
            'fooCustomPropertyHandler',
            new ezcWebdavBasicPathFactory()
        );

        $this->assertAttributeEquals(
            array(
                'userAgentRegex'  => '(.*Nautilus.*)',
                'transport'       => 'fooCustomTransport',
                'xmlTool'         => 'fooCustomXmlTool',
                'propertyHandler' => 'fooCustomPropertyHandler',
                'pathFactory'     => new ezcWebdavBasicPathFactory(),
            ),
            'properties',
            $cfg,
            'Default properties not created correctly on empty ctor.'
        );
    }

    public function testCtorFailure()
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
        $typicalValid = 'fooSomeClass';

        $validCtorParams = array(
            $typicalValid, // userAgentRegex
            $typicalValid, // transport
            $typicalValid, // xmlTool
            $typicalValid, // propertyHandler
            new ezcWebdavAutomaticPathFactory(), // pathFactory
        );

        $invalidCtorParams = array(
            $typicalFails, // userAgentRegex
            $typicalFails, // transport
            $typicalFails, // xmlTool
            $typicalFails, // propertyHandler
            array_merge( $typicalFails, array( 'foo' ) ), // pathFactory
        );

        foreach ( $invalidCtorParams as $id => $paramSet )
        {
            $params = array();
            for ( $i = 0; $i < $id; ++$i )
            {
                $params[$i] = $validCtorParams[$i];
            }
            foreach ( $paramSet as $param )
            {
                $params[$id] = $param;
                $this->assertCtorFailure( $params, ( $i !== 4 ? 'ezcBaseValueException' : 'PHPUnit_Framework_Error' ) );
            }
        }
    }

    public function testGetPropertiesDefaultSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $defaults = array(
            'userAgentRegex'  => '(.*)',
            'transport'       => 'ezcWebdavTransport',
            'xmlTool'         => 'ezcWebdavXmlTool',
            'propertyHandler' => 'ezcWebdavPropertyHandler',
            'pathFactory'     => new ezcWebdavAutomaticPathFactory(),
        );

        foreach ( $defaults as $property => $value )
        {
            $this->assertEquals(
                $value,
                $cfg->$property,
                "Property $property has incorrect default."
            );
        }
    }

    public function testGetPropertiesFromCtorSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool',
            'fooCustomPropertyHandler',
            new ezcWebdavBasicPathFactory()
        );

        $values = array(
            'userAgentRegex'  => '(.*Nautilus.*)',
            'transport'       => 'fooCustomTransport',
            'xmlTool'         => 'fooCustomXmlTool',
            'propertyHandler' => 'fooCustomPropertyHandler',
            'pathFactory'     => new ezcWebdavBasicPathFactory(),
        );

        foreach ( $values as $property => $value )
        {
            $this->assertEquals(
                $value,
                $cfg->$property,
                "Property $property has incorrect value after ctor setting."
            );
        }
    }

    public function testGetPropertiesFailure()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        try
        {
            echo $cfg->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Property not thrown on get access of non-existent property.' );
    }

    public function testSetPropertiesGetPropertiesSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $values = array(
            'userAgentRegex'  => '(.*Nautilus.*)',
            'transport'       => 'fooCustomTransport',
            'xmlTool'         => 'fooCustomXmlTool',
            'propertyHandler' => 'fooCustomPropertyHandler',
            'pathFactory'     => new ezcWebdavBasicPathFactory(),
        );

        foreach( $values as $property => $value )
        {
            $cfg->$property = $value;
        }

        $this->assertAttributeEquals(
            $values,
            'properties',
            $cfg
        );
        foreach ( $values as $property => $value )
        {
            $this->assertEquals(
                $value,
                $cfg->$property,
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
            'userAgentRegex'  => $typicalFails, 
            'transport'       => $typicalFails, 
            'xmlTool'         => $typicalFails, 
            'propertyHandler' => $typicalFails, 
            'pathFactory'     => array_merge( $typicalFails, array( 'foo' ) ), 
        );

        foreach ( $invalidValues as $propertyName => $propertyValues )
        {
            $this->assertSetPropertyFailure( $propertyName, $propertyValues, 'ezcBaseValueException' );
        }

        try
        {
            $cfg = new ezcWebdavTransportConfiguration();
            $cfg->fooBar = 23;
            $this->fail( 'Exception not thrown on set access to non-existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ){}
    }

    public function testPropertiesIssetAccessDefaultCtorSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $properties =array(
            'userAgentRegex', 
            'transport', 
            'xmlTool', 
            'propertyHandler', 
            'pathFactory', 
        );

        foreach( $properties as $propertyName )
        {
            $this->assertTrue(
                isset( $cfg->$propertyName ),
                "Property not set after default construction: '$propertyName'."
            );
        }
    }

    public function testPropertiesIssetAccessNonDefaultCtorSuccess()
    {
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool',
            'fooCustomPropertyHandler',
            new ezcWebdavBasicPathFactory()
        );

        $properties =array(
            'userAgentRegex', 
            'transport', 
            'xmlTool', 
            'propertyHandler', 
            'pathFactory', 
        );

        foreach( $properties as $propertyName )
        {
            $this->assertTrue(
                isset( $cfg->$propertyName ),
                "Property not set after default construction: '$propertyName'."
            );
        }
    }

    public function testPropertyIssetAccessFailure()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $this->assertFalse(
            isset( $cfg->foo ),
            'Non-existent property $foo seems to be set.'
        );
        $this->assertFalse(
            isset( $cfg->properties ),
            'Non-existent property $properties seems to be set.'
        );
    }

    public function testGetTransportInstanceSuccessDefaultCtor()
    {
        $cfg = new ezcWebdavTransportConfiguration();

        $expected = new ezcWebdavTransport();

        $this->assertEquals(
            $expected,
            $cfg->getTransportInstance()
        );
    }

    public function testGetTransportInstanceSuccessNonDefaultCtor()
    {
        $cfg = new ezcWebdavTransportConfiguration(
            '(.*Nautilus.*)',
            'fooCustomTransport',
            'fooCustomXmlTool',
            'fooCustomPropertyHandler',
            new ezcWebdavBasicPathFactory( 'http://foo.example.com/webdav/' )
        );
        
        $xmlTool = new fooCustomXmlTool();
        $expected = new fooCustomTransport(
            $xmlTool,
            new fooCustomPropertyHandler( $xmlTool ),
            new ezcWebdavBasicPathFactory( 'http://foo.example.com/webdav/' )
        );

        $this->assertEquals(
            $expected,
            $cfg->getTransportInstance()
        );

    }

    protected function assertCtorFailure( array $args, $exceptionClass )
    {
        try
        {
            $cfgClass = new ReflectionClass( 'ezcWebdavTransportConfiguration' );
            $cfg = $cfgClass->newInstanceArgs( $args );
        }
        catch( Exception $e )
        {
            ( !( $e instanceof $exceptionClass ) ? var_dump( $e ) : null );
            $this->assertTrue(
                ( $e instanceof $exceptionClass ),
                "Exception thrown on invalid value set of wrong exception class. '" . get_class( $e ) . "' instead of '$exceptionClass'."
            );
            return;
        }
        $this->fail( "Exception not thrown on invalid argument set." );
    }

    protected function assertSetPropertyFailure( $propertyName, array $propertyValues, $exceptionClass )
    {
        foreach ( $propertyValues as $value )
        {
            try
            {
                $cfg = new ezcWebdavTransportConfiguration();
                $cfg->$propertyName = $value;
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
