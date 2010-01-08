<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
