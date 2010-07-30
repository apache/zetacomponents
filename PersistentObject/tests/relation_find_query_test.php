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
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'find_query_test.php';

/**
 * Tests the ezcPersistentFindQuery class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentRelationFindQueryTest extends ezcPersistentFindQueryTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRelationSetNameInCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $sn = 'mySetName';

        $findQuery = new ezcPersistentRelationFindQuery( $q, $cn, $sn );

        $this->assertEquals( $sn, $findQuery->relationSetName );
    }

    public function testRelationSourceInCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $sn = 'mySetName';
        $src = new stdClass();

        $findQuery = new ezcPersistentRelationFindQuery( $q, $cn, $sn, $src );

        $this->assertEquals( $sn, $findQuery->relationSetName );
        $this->assertSame( $src, $findQuery->relationSource );
    }

    public function testSetOwnPropertiesSuccess()
    {
        $findQuery = $this->createFindQuery();
        
        $this->assertSetProperty( $findQuery, 'relationSetName', array( 'mySetName' ) );
        $this->assertSetProperty( $findQuery, 'relationSource', array( new stdClass() ) );
    }

    public function testSetOwnPropertiesFailure()
    {
        parent::testSetOwnPropertiesFailure();
        $findQuery = $this->createFindQuery();
        
        $this->assertSetPropertyFails(
            $findQuery,
            'relationSetName',
            array( 23, 42.23, true, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $findQuery,
            'relationSource',
            array( 23, 42.23, true, array(), 'foo' )
        );
    }

    public function testGetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $sn = 'mySetName';
        $src = new stdClass();

        $findQuery = $this->createFindQuery();

        $findQuery->relationSetName = $sn;
        $findQuery->relationSource  = $src;

        $this->assertEquals( $sn, $findQuery->relationSetName );
        $this->assertEquals( $src, $findQuery->relationSource );
    }

    public function testIssetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $findQuery = $this->createFindQuery();

        $this->assertTrue( isset( $findQuery->relationSetName ) );
        $this->assertTrue( isset( $findQuery->relationSource ) );
    }

    protected function createFindQuery()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';

        return new ezcPersistentRelationFindQuery( $q, $cn );
    }
}

?>
