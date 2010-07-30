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

require_once 'test_case.php';

/**
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorMiscTest extends ezcPersistentSessionIdentityDecoratorTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
    
    // overloading

    public function testSetFailure()
    {
        $this->assertSetPropertyFails(
            $this->idSession,
            'identityMap',
            array(
                'foo',
                23,
                42.23,
                true,
                false,
                array(),
                new stdClass(),
                $this->idMap
            )
        );

        $this->assertSetPropertyFails(
            $this->idSession,
            'options',
            array(
                'foo',
                23,
                42.23,
                true,
                false,
                array(),
                new stdClass(),
            )
        );

        // Dispatched to session
        $this->assertSetPropertyFails(
            $this->idSession,
            'database',
            array(
                'foo',
                23,
                42.23,
                true,
                false,
                array(),
                new stdClass(),
                $this->idSession->database
            )
        );
    }

    public function testSetSuccess()
    {
        $this->assertSetProperty(
            $this->idSession,
            'options',
            array(
                new ezcPersistentSessionIdentityDecoratorOptions()
            )
        );
    }

    public function testGetSuccess()
    {
        $this->assertSame(
            $this->idMap,
            $this->idSession->identityMap
        );
        $this->assertTrue(
            ( $this->idSession->options instanceof ezcPersistentSessionIdentityDecoratorOptions )
        );
        $this->assertTrue(
            ( $this->idSession->options instanceof ezcPersistentSessionIdentityDecoratorOptions )
        );

        // Delegated
        $this->assertTrue(
            ( $this->idSession->database instanceof ezcDbHandler )
        );
        $this->assertTrue(
            ( $this->idSession->definitionManager instanceof ezcPersistentDefinitionManager )
        );
        $this->assertTrue(
            ( $this->idSession->loadHandler instanceof ezcPersistentLoadHandler )
        );
        $this->assertTrue(
            ( $this->idSession->saveHandler instanceof ezcPersistentSaveHandler )
        );
        $this->assertTrue(
            ( $this->idSession->deleteHandler instanceof ezcPersistentDeleteHandler )
        );
    }

    public function testGetFailure()
    {
        try
        {
            echo $this->idSession->foo;
            $this->fail( 'Exception not thrown on get access to non-existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetSuccess()
    {
        $this->assertTrue(
            isset( $this->idSession->identityMap )
        );
        $this->assertTrue(
            isset( $this->idSession->options )
        );
        $this->assertTrue(
            isset( $this->idSession->database )
        );
        $this->assertTrue(
            isset( $this->idSession->definitionManager )
        );
        $this->assertTrue(
            isset( $this->idSession->loadHandler )
        );
        $this->assertTrue(
            isset( $this->idSession->saveHandler )
        );
        $this->assertTrue(
            isset( $this->idSession->deleteHandler )
        );
    }

    public function testIssetFailure()
    {
        $this->assertFalse(
            isset( $this->idSession->foo )
        );
    }
}

?>
