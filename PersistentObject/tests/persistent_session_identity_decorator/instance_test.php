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
 * Test the instance class with ezcPersistentSessionIdentityDecorator.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorInstanceTest extends ezcTestCase
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
        }
    }

    protected function getSession()
    {
        $manager = new ezcPersistentCodeManager(
            dirname( __FILE__ ) . "/../data/"
        );
        return new ezcPersistentSession(
            ezcDbInstance::get(),
            $manager
        );
    }

    protected function getSessionDecorator( $session )
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $session->definitionManager
        );

        return new ezcPersistentSessionIdentityDecorator(
            $session,
            $idMap
        );

    }

    public function testSetWithoutIdentifier()
    {
        $session = $this->getSessionDecorator(
            $this->getSession()
        );

        ezcPersistentSessionInstance::set( $session );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get()
        );
    }

    public function testSetWithIdentifier()
    {
        $session = $this->getSessionDecorator(
            $this->getSession()
        );

        ezcPersistentSessionInstance::set( $session, 'foobar' );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get( 'foobar' )
        );
    }

    public function testSetWithIdentifierMixed()
    {
        $session          = $this->getSession();
        $sessionDecorator = $this->getSessionDecorator( $session );

        ezcPersistentSessionInstance::set( $session, 'session' );
        ezcPersistentSessionInstance::set( $sessionDecorator, 'decorator' );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get( 'session' )
        );
        $this->assertSame(
            $sessionDecorator,
            ezcPersistentSessionInstance::get( 'decorator' )
        );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}

?>
