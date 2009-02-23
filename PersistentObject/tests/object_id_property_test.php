<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the ezcPersistentObjectIdProperty class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectIdPropertyTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectIdPropertyTest' );
    }

    public function testConstructureSuccess()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertAttributeEquals(
            array(
                'columnName'   => null,
                'propertyName' => null,
                'propertyType' => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'generator'    => null,
                'visibility'   => null,
                'databaseType' => PDO::PARAM_STR,
            ),
            'properties',
            $property
        );
        
        
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentNativeGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            PDO::PARAM_LOB
        );
        $this->assertAttributeEquals(
            array(
                'columnName'   => 'column',
                'propertyName' => 'property',
                'propertyType' => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'generator'    => new ezcPersistentGeneratorDefinition(
                    new ezcPersistentNativeGenerator()
                ),
                'visibility'   => ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
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
            $property = new ezcPersistentObjectIdProperty(
                23,
                'foo',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $columnName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                23,
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyName.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                'baz',
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value of type string for parameter $visibility.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                'foo',
                PDO::PARAM_LOB
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyType.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $property = new ezcPersistentObjectIdProperty(
                'foo',
                'bar',
                ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
                new ezcPersistentGeneratorDefinition(
                    new ezcPersistentManualGenerator()
                ),
                ezcPersistentObjectProperty::PHP_TYPE_INT,
                'foo'
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value for parameter $propertyType.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testGetAccessSuccess()
    {
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
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
            $property->visibility
        );
        $this->assertEquals(
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            $property->generator
        );
        $this->assertEquals(
            ezcPersistentObjectProperty::PHP_TYPE_INT,
            $property->propertyType
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );
    }

    public function testGetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty(
            'column',
            'property',
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            ezcPersistentObjectProperty::PHP_TYPE_INT,
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
        $property = new ezcPersistentObjectIdProperty();
        $property->columnName   = 'column';
        $property->propertyName ='property';
        $property->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;
        $property->visibility   = ezcPersistentObjectProperty::VISIBILITY_PROTECTED;
        $property->generator    = new ezcPersistentGeneratorDefinition(
            new ezcPersistentManualGenerator()
        );
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
            ezcPersistentObjectProperty::VISIBILITY_PROTECTED,
            $property->visibility
        );
        $this->assertEquals(
            new ezcPersistentGeneratorDefinition(
                new ezcPersistentManualGenerator()
            ),
            $property->generator
        );
        $this->assertEquals(
            PDO::PARAM_LOB,
            $property->databaseType
        );
    }
    
    public function testSetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty();
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
            'visibility',
            array( true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'generator',
            array( true, false, 'foo', 23, 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $property,
            'databaseType',
            array( true, false, 'foo', 23, 23.42, array(), new stdClass() )
        );
    }

    public function testIssetAccessSuccess()
    {
        $property = new ezcPersistentObjectIdProperty();
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
            isset( $property->visibility ),
            'Property $visibility seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->generator ),
            'Property $generator seems not to be set.'
        );
        $this->assertTrue(
            isset( $property->databaseType ),
            'Property $generator seems not to be set.'
        );
    }

    public function testIssetAccessFailure()
    {
        $property = new ezcPersistentObjectIdProperty();
        $this->assertFalse(
            isset( $property->foo ),
            'Property $foo seems to be set.'
        );
    }
}


?>
