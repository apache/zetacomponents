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
class ezcAuthenticationSessionTest extends ezcAuthenticationTest
{
    public static $id = 'john.doe';
    public static $idKey = 'ezcAuth_id';
    public static $timestampKey = 'ezcAuth_timestamp';

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

    public function testSessionOptions()
    {
        $options = new ezcAuthenticationSessionOptions();

        $this->invalidPropertyTest( $options, 'validity', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'validity', 0, 'int >= 1' );
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
