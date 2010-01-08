<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
                'converter'    => null,
                'databaseType' => PDO::PARAM_STR,
            ),
            'properties',
            $property
        );
        
        
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentPropertyDateTimeConverter(),
            PDO::PARAM_LOB
        );
        $this->assertAttributeEquals(
            array(
                'columnName'   => 'column',
                'propertyName' => 'property',
                'propertyType' => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'converter'    => new ezcPersistentPropertyDateTimeConverter(),
                'databaseType' => PDO::PARAM_LOB,
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
                new ezcPersistentPropertyDateTimeConverter(),
                PDO::PARAM_LOB
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
                new ezcPersistentPropertyDateTimeConverter(),
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                'foo',
                'baz',
                new ezcPersistentPropertyDateTimeConverter(),
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyType.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                'foo',
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                'bam',
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value parameter $converter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectProperty(
                'foo',
                'foo',
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                new ezcPersistentPropertyDateTimeConverter(),
                23
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $databaseType.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testGetAccessSuccess()
    {
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentPropertyDateTimeConverter(),
            PDO::PARAM_LOB
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
            new ezcPersistentPropertyDateTimeConverter(),
            $property->converter
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );
    }

    public function testGetAccessFailure()
    {
        $property = new ezcPersistentObjectProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            new ezcPersistentPropertyDateTimeConverter(),
            PDO::PARAM_LOB
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
        $property->converter    = new ezcPersistentPropertyDateTimeConverter();
        $property->databaseType = PDO::PARAM_LOB;

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
            new ezcPersistentPropertyDateTimeConverter(),
            $property->converter
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );
        
        $property->converter   = null;
        $this->assertNull(
            $property->converter
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
            'converter',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'databaseType',
            array( true, false, 'foo', 23, 23.42, array(), new stdClass() )
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
            isset( $property->converter ),
            'Property $converter seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->databaseType ),
            'Property $databaseType seems not to be set.'
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
