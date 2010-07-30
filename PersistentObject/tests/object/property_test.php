<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
                'columnName'       => null,
                'resultColumnName' => null,
                'propertyName'     => null,
                'propertyType'     => ezcPersistentObjectProperty::PHP_TYPE_STRING,
                'converter'        => null,
                'databaseType'     => PDO::PARAM_STR,
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
                'columnName'       => 'column',
                'resultColumnName' => 'column',
                'propertyName'     => 'property',
                'propertyType'     => ezcPersistentObjectProperty::PHP_TYPE_INT,
                'converter'        => new ezcPersistentPropertyDateTimeConverter(),
                'databaseType'     => PDO::PARAM_LOB,
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

        $property->columnName = 'CamelCase';
        $this->assertEquals(
            'CamelCase',
            $property->columnName
        );
        $this->assertEquals(
            'camelcase',
            $property->resultColumnName
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
        $this->assertTrue(
            isset( $property->resultColumnName ),
            'Property $resultColumnName seems not to be set.'
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
