<?php
/**
 * Basic test cases for the path factory class.
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
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Reqiuire base test
 */
require_once 'property_test.php';

/**
 * Tests for ezcWebdavBasicPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
abstract class ezcWebdavWebdavPropertyTestCase extends ezcWebdavPropertyTestCase
{
    /**
     * Name of property.
     * 
     * @var string
     */
    protected $propertyName;

    /**
     * Property always has content.
     * 
     * @var bool
     */
    protected $alwaysHasContent = false;

    /**
     * Expected property namespace
     * 
     * @var string
     */
    protected $namespace = 'DAV:';

    public function testCtorSuccess()
    {
        $class = new ReflectionClass( $this->className );
        
        // Without params
        $object = $class->newInstance();
        $this->assertPropertyValues( $object, $this->defaultValues );

        
        $params = array();
        foreach ( $this->workingValues as $propName => $values )
        {
            foreach ( $values as $value )
            {
                $params[$propName] = $value;
                $object = $class->newInstanceArgs( $params );
                $this->assertPropertyValues( $object, $params );
            }
        }
    }

    public function testPropertyNamespace()
    {
        $object = $this->getObject();

        $this->assertEquals(
            $object->namespace,
            $this->namespace,
            'Property is in wrong namespace.'
        );
    }

    public function testPropertyName()
    {
        $object = $this->getObject();

        $this->assertEquals(
            $object->name,
            $this->propertyName,
            'Property has wrong name assigned.'
        );
    }

    public function testPropertyNoContent()
    {
        $object = $this->getObject();
        
        $this->assertSame(
            true XOR $this->alwaysHasContent,
            $object->hasNoContent(),
            'Initially a property should have no content.'
        );
    }

    public function testSetAccessFailure()
    {
        foreach ( $this->failingValues as $propName => $values )
        {
            foreach( $values as $value )
            {
                $object = $this->getObject();
                $object->$propName = $value;

                $this->assertEquals( 
                    true,
                    $object->hasError
                );

                $this->assertEquals( 
                    $this->defaultValues[$propName], 
                    $object->$propName,
                    "Failed default value for $propName."
                );
            }
        }
    }

    public function testPropertyNoContentWithContentSet()
    {
        $object = $this->getObject();

        foreach ( $this->workingValues as $propName => $values )
        {
            foreach( $values as $value )
            {
                $object->$propName = $value;
                $this->assertEquals( $value, $object->$propName );
            }
        }
        
        $this->assertSame(
            false,
            $object->hasNoContent(),
            'The property should have some content now.'
        );
    }

    public function testPropertyClearContent()
    {
        $object = $this->getObject();

        foreach ( $this->workingValues as $propName => $values )
        {
            foreach( $values as $value )
            {
                $object->$propName = $value;
                $this->assertEquals( $value, $object->$propName );
            }
        }
        
        $this->assertSame(
            false,
            $object->hasNoContent(),
            'The property should have some content now.'
        );

        $object->clear();
        
        $this->assertSame(
            true XOR $this->alwaysHasContent,
            $object->hasNoContent(),
            'The property should have some content now.'
        );

        $this->assertPropertyValues( $object, $this->defaultValues );
    }
}
?>
