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
class ezcAuthenticationTokenTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationTokenTest" );
    }

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testTokenNull()
    {
        $credentials = new ezcAuthenticationIdCredentials( null );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'sha1' ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTokenSha1Correct()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'qwerty' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'sha1' ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTokenSha1Fail()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'qwerty' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'wrong value', 'sha1' ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTokenMd5Correct()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'asdfgh' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'a152e841783914146e4bcd4f39100686', 'md5' ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTokenMd5Fail()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'qwerty' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'wrong value', 'md5' ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTokenExternCallbackCorrect()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'xxIh4TUllUASg', array( 'Encryption', 'uncrackable' ) ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTokenExternCallbackFail()
    {
        $credentials = new ezcAuthenticationIdCredentials( 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationTokenFilter( 'wrong value', array( 'Encryption', 'uncrackable' ) ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testOptions()
    {
        $options = new ezcAuthenticationTokenOptions();

        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $filter = new ezcAuthenticationTokenFilter( '', 'md5' );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testProperties()
    {
        $token = '';
        $filter = new ezcAuthenticationTokenFilter( $token, 'md5' );
        $this->assertEquals( true, isset( $filter->token ) );
        $this->assertEquals( true, isset( $filter->function ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->token = array();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $expected = "The value 'a:0:{}' that you were trying to assign to setting 'token' is invalid. Allowed values are: string || int.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        try
        {
            $filter->function = 'no_such_function';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $expected = "The value 'no_such_function' that you were trying to assign to setting 'function' is invalid. Allowed values are: callback.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        try
        {
            $filter->function = array( 'Encryption', 'no_such_function' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $expected = "The value 'a:2:{i:0;s:10:\"Encryption\";i:1;s:16:\"no_such_function\";}' that you were trying to assign to setting 'function' is invalid. Allowed values are: callback.";
            $this->assertEquals( $expected, $e->getMessage() );
        }

        try
        {
            $filter->no_such_property = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }

        try
        {
            $value = $filter->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }
}

class Encryption
{
    public static function uncrackable( $s )
    {
        return crypt( $s, 'xx' );
    }
}
?>
