<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcAuthenticationLdapTest extends ezcAuthenticationTest
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
            $this->markTestSkipped( "Cannot connect to LDAP. Probably you didn't setup the LDAP enviroment: " . $e->getMessage() );
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

    public function testLdapTLSOptions()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $options = new ezcAuthenticationLdapOptions();
        $options->protocol = ezcAuthenticationLdapFilter::PROTOCOL_TLS;
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationLdapFilter( $ldap, $options ) );
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
            $this->assertEquals( "Could not connect to host 'ldap://unknown_host:" . self::$port . "': Can't contact LDAP server (code: 81)", $e->getMessage() );
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
            $this->assertEquals( "Could not connect to host 'ldap://" . self::$host . ':' . self::$portSSL . "': Can't contact LDAP server (code: 81)", $e->getMessage() );
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

    public function testLdapMockConnectFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = $this->getMock( 'ezcAuthenticationLdapFilter', array( 'ldapConnect' ), array( $ldap ) );
        $filter->expects( $this->any() )
               ->method( 'ldapConnect' )
               ->will( $this->returnValue( false ) );

        try
        {
            $result = $filter->run( $credentials );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationLdapException $e )
        {
            $this->assertEquals( "Could not connect to host 'ldap://" . self::$host . ':' . self::$port . "'.", $e->getMessage() );
        }
    }

    public function testLdapMockStartTlsFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'wrong password' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port, ezcAuthenticationLdapFilter::PROTOCOL_TLS );
        $filter = $this->getMock( 'ezcAuthenticationLdapFilter', array( 'ldapStartTls' ), array( $ldap ) );
        $filter->expects( $this->any() )
               ->method( 'ldapStartTls' )
               ->will( $this->returnValue( false ) );

        try
        {
            $result = $filter->run( $credentials );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcAuthenticationLdapException $e )
        {
            $this->assertEquals( "Could not connect to host 'ldap://" . self::$host . ':' . self::$port . "'.", $e->getMessage() );
        }
    }

    public function testLdapFetchExtraData()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $filter->registerFetchData( array( 'uid' ) );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );

        $expected = array( 'uid' => array( 'jan.modaal' ) );
        $this->assertEquals( $expected, $filter->fetchData() );
    }

    /**
     * Test for issue #12992 (case-sensitivity problems for LDAP registerFetchData()).
     */
    public function testLdapFetchExtraDataSubdirectory()
    {
        $base = self::$base;
        self::$base = 'ou=Users,dc=foo,dc=bar';
        $credentials = new ezcAuthenticationPasswordCredentials( 'johnny.doe', '12345' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $filter->registerFetchData( array( 'uid', 'displayName' ) );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );

        $expected = array( 'uid' => array( 'johnny.doe' ), 'displayName' => array ( 'Johnny Doe' ) );
        $this->assertEquals( $expected, $filter->fetchData() );
        self::$base = $base;
    }

    /**
     * Modified test for issue #12992 (case-sensitivity problems for LDAP registerFetchData()).
     *
     * Modified 'objectclass' into 'objectClass'.
     */
    public function testLdapFetchExtraDataObjectClass()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $filter->registerFetchData( array( 'uid', 'objectClass' ) );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );

        $expected = array( 'uid' => array( 'jan.modaal' ),
                           'objectClass' => array( 'account', 'simpleSecurityObject', 'top' )
                         );
        $this->assertEquals( $expected, $filter->fetchData() );
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

        $this->invalidPropertyTest( $options, 'protocol', 'wrong value', '1, 2' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testLdapOptionsGetSet()
    {
        $options = new ezcAuthenticationLdapOptions();

        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = new ezcAuthenticationLdapFilter( $ldap );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testLdapProperties()
    {
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = new ezcAuthenticationLdapFilter( $ldap );

        $this->invalidPropertyTest( $filter, 'ldap', 'wrong value', 'ezcAuthenticationLdapInfo' );
        $this->missingPropertyTest( $filter, 'no_such_property' );
    }

    public function testLdapPropertiesIsSet()
    {
        $ldap = new ezcAuthenticationLdapInfo( self::$host, self::$format, self::$base, self::$port );
        $filter = new ezcAuthenticationLdapFilter( $ldap );

        $this->issetPropertyTest( $filter, 'ldap', true );
        $this->issetPropertyTest( $filter, 'no_such_property', false );
    }

    public function testLdapExceptions()
    {
        $e = new ezcAuthenticationLdapException( "Could not connect to host 'localhost'." );
        $this->assertEquals( "Could not connect to host 'localhost'.", $e->getMessage() );
    }
}
?>
