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
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'Authentication/tests/test.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationSessionTest extends ezcAuthenticationTest
{
    public static $id = 'john.doe';
    public static $idKey = 'ezcAuth_id';
    public static $timestampKey = 'ezcAuth_timestamp';
    public static $lastActivityTimestampKey = 'ezcAuth_lastActivityTimestamp';

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationSessionTest" );
    }

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testSessionRunEmpty()
    {
        $_SESSION[self::$timestampKey] = time();
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $authentication->session = new ezcAuthenticationSession( $options );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testSessionRunEmptyExpired()
    {
        $_SESSION[self::$timestampKey] = time() - 5;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $authentication->session = new ezcAuthenticationSession( $options );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testSessionRunValid()
    {
        $_SESSION[self::$timestampKey] = time();
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $authentication->session = new ezcAuthenticationSession( $options );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testSessionRunValidExpired()
    {
        $_SESSION[self::$timestampKey] = time() - 5;
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $authentication->session = new ezcAuthenticationSession( $options );
        $this->assertEquals( true, isset( $_SESSION[self::$timestampKey] ) );
        $this->assertEquals( true, isset( $_SESSION[self::$idKey] ) );
        $this->assertEquals( false, $authentication->run() );
        $this->assertEquals( false, isset( $_SESSION[self::$timestampKey] ) );
        $this->assertEquals( false, isset( $_SESSION[self::$idKey] ) );
    }

    public function testSessionIsValidEmpty()
    {
        $_SESSION[self::$timestampKey] = time();
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( false, $session->isValid( $credentials ) );
    }

    public function testSessionIsValidEmptyExpired()
    {
        $_SESSION[self::$timestampKey] = time() - 5;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( false, $session->isValid( $credentials ) );
    }

    public function testSessionIsValidValid()
    {
        $_SESSION[self::$timestampKey] = time();
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( true, $session->isValid( $credentials ) );
    }

    public function testSessionIsValidValidExpired()
    {
        $_SESSION[self::$timestampKey] = time() - 5;
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( true, isset( $_SESSION[self::$timestampKey] ) );
        $this->assertEquals( true, isset( $_SESSION[self::$idKey] ) );
        $this->assertEquals( false, $session->isValid( $credentials ) );
        $this->assertEquals( false, isset( $_SESSION[self::$timestampKey] ) );
        $this->assertEquals( false, isset( $_SESSION[self::$idKey] ) );
    }

    public function testSessionIsValidIdleTimeout()
    {
        $_SESSION[self::$lastActivityTimestampKey] = time();
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $options->idleTimeout = 1;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( true, $session->isValid( $credentials ) );
    }

    public function testSessionIsValidIdleTimeoutExpired()
    {
        $_SESSION[self::$lastActivityTimestampKey] = time() - 10;
        $_SESSION[self::$idKey] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );

        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 100;
        $options->idleTimeout = 5;
        $session = new ezcAuthenticationSession( $options );
        $this->assertEquals( false, $session->isValid( $credentials ) );
    }

    public function testSessionOptions()
    {
        $options = new ezcAuthenticationSessionOptions();

        $this->invalidPropertyTest( $options, 'validity', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'validity', 0, 'int >= 1' );
        $this->invalidPropertyTest( $options, 'idleTimeout', 'wrong value', 'int >= 1'  );
        $this->invalidPropertyTest( $options, 'idleTimeout', 0, 'int >= 1'  );
        $this->invalidPropertyTest( $options, 'idKey', array(), 'string' );
        $this->invalidPropertyTest( $options, 'timestampKey', array(), 'string' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testSessionOptionsGetSet()
    {
        $options = new ezcAuthenticationSessionOptions();

        $filter = new ezcAuthenticationSession();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }
}
?>
