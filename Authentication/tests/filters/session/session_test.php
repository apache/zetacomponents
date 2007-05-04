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
class ezcAuthenticationSessionTest extends ezcTestCase
{
    public static $id = 'john.doe';

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

    public function testSessionEmpty()
    {
        $_SESSION['ezcAuth_timestamp'] = time();
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $authentication->session = new ezcAuthenticationSessionFilter( $options );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testSessionEmptyExpired()
    {
        $_SESSION['ezcAuth_timestamp'] = time() - 5;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $authentication->session = new ezcAuthenticationSessionFilter( $options );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testSessionValid()
    {
        $_SESSION['ezcAuth_timestamp'] = time();
        $_SESSION['ezcAuth_id'] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 3;
        $authentication->session = new ezcAuthenticationSessionFilter( $options );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testSessionValidExpired()
    {
        $_SESSION['ezcAuth_timestamp'] = time() - 5;
        $_SESSION['ezcAuth_id'] = self::$id;
        $credentials = new ezcAuthenticationIdCredentials( self::$id );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationSessionOptions();
        $options->validity = 1;
        $authentication->session = new ezcAuthenticationSessionFilter( $options );
        $this->assertEquals( true, isset( $_SESSION['ezcAuth_timestamp'] ) );
        $this->assertEquals( true, isset( $_SESSION['ezcAuth_id'] ) );
        $this->assertEquals( false, $authentication->run() );
        $this->assertEquals( false, isset( $_SESSION['ezcAuth_timestamp'] ) );
        $this->assertEquals( false, isset( $_SESSION['ezcAuth_id'] ) );
    }

    public function testOptions()
    {
        $options = new ezcAuthenticationSessionOptions();

        try
        {
            $options->validity = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'validity' is invalid. Allowed values are: int >= 1.", $e->getMessage() );
        }

        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $filter = new ezcAuthenticationSessionFilter();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }
}
?>
