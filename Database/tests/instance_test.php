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
 * @package Database
 * @subpackage Tests
 */

/**
 * Test the instance class
 *
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseInstanceTest extends ezcTestCase
{
    private $default;

    protected function setUp()
    {
        try
        {
            $this->default = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
    }

    protected function tearDown()
    {
        ezcDbInstance::reset();
        ezcDbInstance::set( $this->default );
    }

    public function testGetWithIdentifierValid()
    {
        $db = ezcDbInstance::get();
        $db = clone( $db );
        $db->a = "something";
        ezcDbInstance::set( $db, 'secondary' );
        $this->assertEquals( true, isset( ezcDbInstance::get( 'secondary' )->a ) );
    }

    public function testChooseDefault()
    {
        $db = ezcDbInstance::get();
        $db = clone $db;
        $db->a = "something";
        ezcDbInstance::set( $db, 'secondary' );

        ezcDbInstance::chooseDefault( 'secondary' );
        $this->assertEquals( true, isset( ezcDbInstance::get()->a ) );
    }

    public function testWithIdentifierInvalid()
    {
        try
        {
            ezcDbInstance::get( "NoSuchInstance" );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcDbHandlerNotFoundException $e ) {}
    }

    public function testGetIdentifiers()
    {
        $this->assertTrue( count( ezcDbInstance::getIdentifiers() ) >= 1 );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseInstanceTest" );
    }
}

?>
