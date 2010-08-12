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
class ezcAuthenticationGeneralTest extends ezcAuthenticationTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationGeneralTest" );
    }

    public function testGeneralNoFilters()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'john.doe' );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testGeneralStatus()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'john.doe' );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( array(), $authentication->getStatus() );
    }

    public function testGeneralIdCredentials()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'john.doe' );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( 'john.doe', $credentials->__toString() );
    }

    public function testGeneralIdCredentialsSetState()
    {
        $credentials = ezcAuthenticationIdCredentials::__set_state( array( 'id' => 'john.doe' ) );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( 'john.doe', $credentials->__toString() );
    }

    public function testGeneralPasswordCredentials()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( 'john.doe', $credentials->__toString() );
    }

    public function testGeneralPasswordCredentialsSetState()
    {
        $credentials = ezcAuthenticationPasswordCredentials::__set_state( array( 'id' => 'john.doe', 'password' => 'foobar' ) );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( 'john.doe', $credentials->__toString() );
    }

    public function testGeneralOptions()
    {
        $options = new ezcAuthenticationOptions();

        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testGeneralOptionsGetSet()
    {
        $options = new ezcAuthenticationOptions();

        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->setOptions( $options );
        $this->assertEquals( $options, $authentication->getOptions() );
    }

    public function testGeneralProperties()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );

        $this->invalidPropertyTest( $authentication, 'credentials', 'wrong value', 'ezcAuthenticationCredentials' );
        $this->invalidPropertyTest( $authentication, 'session', 'wrong value', 'ezcAuthenticationSession' );
        $this->invalidPropertyTest( $authentication, 'status', 'wrong value', 'ezcAuthenticationStatus' );
        $this->missingPropertyTest( $authentication, 'no_such_property' );
    }

    public function testGeneralPropertiesIsSet()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );

        $this->issetPropertyTest( $authentication, 'credentials', true );
        $this->issetPropertyTest( $authentication, 'status', true );
        $this->issetPropertyTest( $authentication, 'session', false );
        $this->issetPropertyTest( $authentication, 'no_such_property', false );
    }
}
?>
