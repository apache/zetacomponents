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
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentMultiManagerTest extends ezcTestCase
{
    private $manager = null;

    protected function setUp()
    {
        $managers = array();
        $managers[] = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $managers[] = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data2/" );
        $this->manager = new ezcPersistentMultiManager( $managers );
    }

    public function testFetchValid()
    {
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( null, $def->class );

        $def = $this->manager->fetchDefinition( "MyClass" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( "MyClass", $def->class );
    }

    public function testFetchValidTwice()
    {
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $def2 = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def2 instanceof ezcPersistentObjectDefinition );
    }

    public function testInvalidClass()
    {
        try
        {
            $this->manager->fetchDefinition( "NoSuchClass" );
        }
        catch ( Exception $e )
        {
            return;
        }
        $this->fail( "Fetching a non-existent definition did not throw an exception." );
    }

    public function testAddManager()
    {
        $this->manager = new ezcPersistentMultiManager();
        $this->manager->addManager( new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" ) );
        $this->manager->addManager( new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data2/" ) );

        // test fetching
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( null, $def->class );

        $def = $this->manager->fetchDefinition( "MyClass" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( "MyClass", $def->class );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentMultiManagerTest' );
    }
}

?>
