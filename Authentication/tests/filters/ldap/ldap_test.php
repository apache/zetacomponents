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
class ezcAuthenticationLdapTest extends ezcTestCase
{
    public static $host = 'localhost';
    public static $format = 'uid=%id%';
    public static $base = 'dc=foo,dc=bar';
    public static $port = 389;
    public static $portSSL = 636;
    public static $formatAdmin = 'cn=%id%';

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationLdapTest" );
    }

    public function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'ldap' ) )
        {
            $this->markTestSkipped( "PHP must be compiled with --with-ldap." );
        }
        try
        {
            $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'asdfgh' );
            $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
            $authentication = new ezcAuthentication( $credentials );
            $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
            $authentication->run();
        }
        catch ( ezcAuthenticationLdapException $e )
        {
            // this will be changed later when we will have a test server with LDAP
            $this->markTestSkipped( "Cannot connect to LDAP. Probably you didn't setup the LDAP enviroment." );
        }
    }

    public function tearDown()
    {

    }

    public function testLdapTLS()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port, ezcAuthenticationLdapFilter::PROTOCOL_TLS );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapWrongServer()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john', 'foobar' );
        $ldap = new ezcAuthenticationLdapInfo( 'unknown_host', self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        try
        {
            $result = $authentication->run();
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationLdapException $e )
        {
            $this->assertEquals( "Could not connect to host 'ldap://unknown_host:" . self::$port . "'. (0x51)", $e->getMessage() );
        }
    }

    public function testLdapWrongPort()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john', 'foobar' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$portSSL );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        try
        {
            $result = $authentication->run();
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationLdapException $e )
        {
            $this->assertEquals( "Could not connect to host 'ldap://" . self::$host . ':' . self::$portSSL . "'. (0x51)", $e->getMessage() );
        }
    }

    public function testLdapPasswordNull()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'admin', null );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$formatAdmin, self::$base );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapDefaultPort()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'admin', 'wee123' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$formatAdmin, self::$base );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapUsernameWithStrangeCharacters()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'Ruşinică Piţigoi', '12345' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapUsernameFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john', 'foobar' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapAdminCryptCorrect()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'admin', 'wee123' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$formatAdmin, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapAdminCryptFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'admin', 'wee12' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$formatAdmin, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapCryptCorrect()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapCryptFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapSha1Correct()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapSha1Fail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapMd5Correct()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'asdfgh' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapMd5Fail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapPlainCorrect()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'abcdef' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testLdapPlainFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testLdapInfo()
    {
        $ldap = ezcAuthenticationLdapInfo::__set_state( array( 'host' => self::$host, 'format' => self::$format, 'base' => self::$base, 'port' => self::$port, 'protocol' => ezcAuthenticationLdapFilter::PROTOCOL_TLS ) );
        $this->assertEquals( self::$host, $ldap->host );
        $this->assertEquals( self::$format, $ldap->format );
        $this->assertEquals( self::$base, $ldap->base );
        $this->assertEquals( self::$port, $ldap->port );
    }

    public function testLdapOptions()
    {
        $options = new ezcAuthenticationLdapOptions();

        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testLdapProperties()
    {
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $this->assertEquals( true, isset( $filter->ldap ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->ldap = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'ldap' is invalid. Allowed values are: instance of ezcAuthenticationLdapInfo.", $e->getMessage() );
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

    public function testLdapExceptions()
    {
        $e = new ezcAuthenticationLdapException( "Could not connect to host 'localhost'." );
        $this->assertEquals( "Could not connect to host 'localhost'.", $e->getMessage() );
    }
}
?>
