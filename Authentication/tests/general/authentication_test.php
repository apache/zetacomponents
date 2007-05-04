<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationTest" );
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
        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->setOptions( $options );
        $this->assertEquals( $options, $authentication->getOptions() );
    }

    public function testProperties()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $this->assertEquals( true, isset( $authentication->credentials ) );
        $this->assertEquals( true, isset( $authentication->status ) );
        $this->assertEquals( false, isset( $authentication->session ) );
        $this->assertEquals( false, isset( $authentication->no_such_property ) );

        try
        {
            $authentication->credentials = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'credentials' is invalid. Allowed values are: ezcAuthenticationCredentials.", $e->getMessage() );
        }

        try
        {
            $authentication->session = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'session' is invalid. Allowed values are: ezcAuthenticationSessionFilter.", $e->getMessage() );
        }

        try
        {
            $authentication->status = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'status' is invalid. Allowed values are: ezcAuthenticationStatus.", $e->getMessage() );
        }

        try
        {
            $authentication->no_such_property = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }

        try
        {
            $value = $authentication->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }
}
?>
