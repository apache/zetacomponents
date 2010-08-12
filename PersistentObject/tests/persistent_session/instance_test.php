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

/**
 * Test the instance class
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionInstanceTest extends ezcTestCase
{
    private $default;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
            return;
        }
        ezcPersistentSessionInstance::reset();
    }

    public function testWithoutIdentifierInvalid()
    {
        try
        {
            ezcPersistentSessionInstance::get();
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public function testGetWithIdentifierValid()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager );
        $manager2 = clone( $manager );
        $manager2->a = "something";
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager2 );

        ezcPersistentSessionInstance::set( $session1 );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );
        $this->assertEquals( false, isset( ezcPersistentSessionInstance::get()->definitionManager->a ) );
        $this->assertEquals( true, isset( ezcPersistentSessionInstance::get( 'secondary' )->definitionManager->a ) );
    }

    public function testChooseDefault()
    {

        $manager1 = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager1 );
        $manager2 = clone( $manager1 );
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager2 );

        ezcPersistentSessionInstance::set( $session1 );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );
        ezcPersistentSessionInstance::chooseDefault( 'secondary' );
        $this->assertSame( $manager2, ezcPersistentSessionInstance::get()->definitionManager );
    }

    public function testWithIdentifierInvalid()
    {
        try
        {
            ezcPersistentSessionInstance::get( "NoSuchInstance" );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public function testWith2IdentifiersInvalid()
    {
        $manager1 = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager1 );
        
        $manager2 = clone( $manager1 );
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager2 );
        
        ezcPersistentSessionInstance::set( $session1, 'first' );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );

        try
        {
            ezcPersistentSessionInstance::get( "NoSuchInstance" );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public function testResetWithoutIdentifier()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session = new ezcPersistentSession( ezcDbInstance::get(), $manager );

        ezcPersistentSessionInstance::set( $session );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get()
        );

        ezcPersistentSessionInstance::reset();

        try
        {
            ezcPersistentSessionInstance::get();
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public function testResetWithIdentifiers()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/PersistentObject/tests/data/" );
        $session1 = new ezcPersistentSession( ezcDbInstance::get(), $manager );
        $session2 = new ezcPersistentSession( ezcDbInstance::get(), $manager );

        ezcPersistentSessionInstance::set( $session1, 'first' );
        ezcPersistentSessionInstance::set( $session2, 'secondary' );

        $this->assertSame(
            $session1,
            ezcPersistentSessionInstance::get( 'first' )
        );
        $this->assertSame(
            $session2,
            ezcPersistentSessionInstance::get( 'secondary' )
        );

        ezcPersistentSessionInstance::reset();

        try
        {
            ezcPersistentSessionInstance::get( 'first' );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}

        try
        {
            ezcPersistentSessionInstance::get( 'secondary' );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcPersistentSessionNotFoundException $e ) {}
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcPersistentSessionInstanceTest" );
    }
}

?>
