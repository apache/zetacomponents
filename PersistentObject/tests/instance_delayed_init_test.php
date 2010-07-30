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

require_once 'test_classes.php';

/**
 * Test the delayed init for instance class
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectInstanceDelayedInitTest extends ezcTestCase
{
    private $default;

    public function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
    }

    public function testDelayedInit1()
    {
        ezcBaseInit::setCallback( 'ezcInitPersistentSessionInstance', 'testDelayedInitPersistentSessionInstance' );
        $instance1 = ezcPersistentSessionInstance::get( 'delayed1' );
    }

    public function testDelayedInit2()
    {
        try
        {
            $instance2 = ezcPersistentSessionInstance::get( 'delayed2' );
        }
        catch ( ezcPersistentSessionNotFoundException $e )
        {
            $this->assertEquals( "Could not find the persistent session: delayed2.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcPersistentObjectInstanceDelayedInitTest" );
    }
}

?>
