<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the ezcPersistentObjectProperty class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectPropertyTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectPropertyTest' );
    }

    public function testConstructureSuccess()
    {
        $property = new ezcPersistentObjectProperty();
        $this->assertAttributeEquals(
            array(
                'columnName'   => null,
                'propertyName' => null,
                'propertyType' => ezcPersistentObjectProperty::PHP_TYPE_STRING,
                'conversion'   => null
            ),
            'properties',
            $property
        );
        
        
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentObjectPropertyDateTimeConversion()
        );
        $this->assertAttributeEquals(
            array(
                'columnName'   => 'column',
                'propertyName' => 'property',
                'propertyType' => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'conversion'   => new ezcPersistentObjectPropertyDateTimeConversion(),
            ),
            'properties',
            $property
        );
    }

    public function testConstructureFailure()
    {
        try
        {
            $property = new ezcPersistentObjectProperty(
                23,
                'foo',
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                new ezcPersistentObjectPropertyDateTimeConversion()
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $columnName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                23,
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                new ezcPersistentObjectPropertyDateTimeConversion()
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                'bar',
                'baz',
                new ezcPersistentObjectPropertyDateTimeConversion()
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value of type string for parameter $type.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                'bar',
                'baz',
                'bam'
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value of type string for parameter $type.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testGetAccessSuccess()
    {
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentObjectPropertyDateTimeConversion()
        );

        $this->assertEquals(
            'column',
            $property->columnName
        );
        $this->assertEquals(
            'property',
            $property->propertyName
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->propertyType
        );
        $this->assertEquals(
            new ezcPersistentObjectPropertyDateTimeConversion(),
            $property->conversion
        );
    }

    public function testGetAccessFailure()
    {
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentObjectPropertyDateTimeConversion()
        );
        try
        {
            echo $property->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on get access to invalid property $foo.' );
    }
    
    public function testSetAccessSuccess()
    {
        $property = new ezcPersistentObjectProperty();
        $property->columnName   = 'column';
        $property->propertyName ='property';
        $property->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
        $property->conversion   = new ezcPersistentObjectPropertyDateTimeConversion();

        $this->assertEquals(
            'column',
            $property->columnName
        );
        $this->assertEquals(
            'property',
            $property->propertyName
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->propertyType
        );
        $this->assertEquals(
            new ezcPersistentObjectPropertyDateTimeConversion(),
            $property->conversion
        );
        
        $property->conversion   = null;
        $this->assertNull(
            $property->conversion
        );
    }
    
    public function testSetAccessFailure()
    {
        $property = new ezcPersistentObjectProperty();
        $this->assertSetPropertyFails(
            $property,
            'columnName',
            array( true, false, 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'propertyName',
            array( true, false, 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'propertyType',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'conversion',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
    }

    public function testIssetAccessSuccess()
    {
        $property = new ezcPersistentObjectProperty();
        $this->assertTrue(
            isset( $property->columnName ),
            'Property $columnName seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->propertyName ),
            'Property $propertyName seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->propertyType ),
            'Property $propertyType seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->conversion ),
            'Property $conversion seems not to be set.'
        );
    }

    public function testIssetAccessFailure()
    {
        $property = new ezcPersistentObjectProperty();
        $this->assertFalse(
            isset( $property->foo ),
            'Property $foo seems to be set.'
        );
    }
}


?>
