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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'test_case.php';

/**
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorLoadTest extends ezcPersistentSessionIdentityDecoratorTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }


    // loadIfExists

    public function testLoadIfExistsValid()
    {
        $first = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        // Test identity
        $this->assertSame(
            $first,
            $second,
            'Object identity different on second load.'
        );
    }

    public function testLoadIfExistsValidRefetch()
    {
        $this->idSession->options->refetch = true;

        $first = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        // Test identity
        $this->assertNotSame(
            $first,
            $second,
            'Object identity idenitical on second load with refetch.'
        );
    }

    public function testLoadIfExistsInvalid()
    {
        $object = $this->idSession->loadIfExists( 'NoSuchClass', 1 );
        $this->assertEquals( null, $object );
    }

    public function testLoadIfExistsNoSuchObject()
    {
        $object = $this->idSession->loadIfExists( 'PersistentTestObject', 999 );
        $this->assertEquals( null, $object );
    }

    // load

    public function testLoadValid()
    {
        $first = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $second ) );

        // Test identity
        $this->assertSame(
            $first,
            $second,
            'Object identity different on second load.'
        );
    }

    public function testLoadValidRefetch()
    {
        $this->idSession->options->refetch = true;

        $first = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $second ) );

        // Test identity
        $this->assertNotSame(
            $first,
            $second,
            'Object identity idenitical on second load with refetch.'
        );
    }

    public function testLoadInvalid()
    {
        try
        {
            $object = $this->idSession->load( 'NoSuchClass', 1 );
            $this->fail( "load() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testLoadInvalidRefetch()
    {
        $this->idSession->options->refetch = true;

        try
        {
            $object = $this->idSession->load( 'NoSuchClass', 1 );
            $this->fail( "load() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testLoadNoSuchObject()
    {
        try
        {
            $object = $this->idSession->load( 'PersistentTestObject', 999 );
            $this->fail( "load() called with invalid object id. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
            return;
        }
    }

    public function testLoadNoSuchObjectRefetch()
    {
        $this->idSession->options->refetch = true;

        try
        {
            $object = $this->idSession->load( 'PersistentTestObject', 999 );
            $this->fail( "load() called with invalid object id. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
            return;
        }
    }

    // loadIntoObject
    
    public function testLoadIntoObjectOnceSuccess()
    {
        $object = new PersistentTestObject();
        $this->idSession->loadIntoObject( $object, 1 );

        $this->assertEquals( 'Sweden', $object->varchar );
        $this->assertEquals( 9006405, (int)$object->integer );
        $this->assertEquals( 449.96, (float)$object->decimal );
        $this->assertEquals( 'Sweden has nice girls!', $object->text );
    }

    public function testLoadIntoObjectTwiceFailure()
    {
        $first = new PersistentTestObject();
        $this->idSession->loadIntoObject( $first, 1 );

        $this->assertEquals( 'Sweden', $first->varchar );
        $this->assertEquals( 9006405, (int)$first->integer );
        $this->assertEquals( 449.96, (float)$first->decimal );
        $this->assertEquals( 'Sweden has nice girls!', $first->text );

        $second = new PersistentTestObject();
        try
        {
            $this->idSession->loadIntoObject( $second, 1 );
            $this->fail( 'Exception not thrown on load into object of existing instance.' );
        }
        catch ( ezcPersistentIdentityAlreadyExistsException $e ) {}
    }

    public function testLoadIntoObjectTwiceSuccessRefetch()
    {
        $this->idSession->options->refetch = true;

        $first = new PersistentTestObject();
        $this->idSession->loadIntoObject( $first, 1 );

        $this->assertEquals( 'Sweden', $first->varchar );
        $this->assertEquals( 9006405, (int)$first->integer );
        $this->assertEquals( 449.96, (float)$first->decimal );
        $this->assertEquals( 'Sweden has nice girls!', $first->text );

        $second = new PersistentTestObject();
        $this->idSession->loadIntoObject( $second, 1 );

        $this->assertNotSame( $first, $second );
        $this->assertEquals( $first, $second );
    }

    public function testLoadIntoObjectInvalid()
    {
        try
        {
            $object = $this->idSession->loadIntoObject( new Exception(), 1 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e )
        {
            return;    
        }
    }

    public function testLoadIntoObjectInvalidRefetch()
    {
        $this->idSession->options->refetch = true;

        try
        {
            $object = $this->idSession->loadIntoObject( new Exception(), 1 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e )
        {
            return;    
        }
    }

    public function testLoadIntoObjectNoSuchObject()
    {
        try
        {
            $object = $this->idSession->loadIntoObject( new PersistentTestObject(), 999 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
        }
    }

    public function testLoadIntoObjectNoSuchObjectRefetch()
    {
        $this->idSession->options->refetch = true;

        try
        {
            $object = $this->idSession->loadIntoObject( new PersistentTestObject(), 999 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
        }
    }

    // refresh

    public function testRefreshValid()
    {
        $first  = $this->idSession->load( 'PersistentTestObject', 1 );
        $second = $this->idSession->load( 'PersistentTestObject', 1 );

        $this->assertSame( $first, $second );

        $first->integer = 23;

        $this->assertEquals( 23, $second->integer );

        $this->idSession->refresh( $first );

        $this->assertSame( $first, $second );

        $this->assertEquals( 9006405, (int)$first->integer );
        $this->assertEquals( 9006405, (int)$second->integer );
    }

    public function testRefreshInvalid()
    {
        try
        {
            $this->idSession->refresh( new Exception() );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) 
        {
            return;
        }
        $this->fail( "refresh of non-persistent object did not throw exception" );
    }

    public function testRefreshNotPersistent()
    {
        try
        {
            $this->idSession->refresh( new PersistentTestObject() );
        }
        catch ( ezcPersistentObjectNotPersistentException $e )
        {
            return;
        }
        $this->fail( "refresh of non-persistent object did not throw exception" );
    }
}

?>
