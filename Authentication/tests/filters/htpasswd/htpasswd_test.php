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
class ezcAuthenticationHtpasswdTest extends ezcAuthenticationTest
{
    private static $path = null;
    private static $empty = null;
    private static $nopass = null;
    private static $missing = null;

    public static function suite()
    {
        self::$path = dirname( __FILE__ ) . '/data/htpasswd';
        self::$empty = dirname( __FILE__ ) . '/data/htpasswd_empty';
        self::$nopass = dirname( __FILE__ ) . '/data/htpasswd_no_passwords';
        self::$missing = dirname( __FILE__ ) . '/data/htpassw';

        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationHtpasswdTest" );
    }

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testHtpasswdPasswordNull()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', null );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdPlainPasswordNull()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', null );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdCrypt()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdCryptEncrypted()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wpeE20wyWHnLE' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdSha1()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'qwerty' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdSha1Encrypted()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'sbN3OgXA7QF2eHpPFXT/AHX3Uh4=' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdMd5()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'asdfgh' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdMd5Encrypted()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'A5gP9/..$HG29Tb75h3Cyf7YsuU2Yh1' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdPlain()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'abcdef' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );

        // Linux flavours plain-text passwords are not supported, but on Windows they should be (not tested)
        if ( substr( php_uname( 's' ), 0, 7 ) === 'Windows' )
        {
            $this->assertEquals( true, $authentication->run() );
        }
        else
        {
            $this->assertEquals( false, $authentication->run() );
        }
    }

    public function testHtpasswdCorrectCredentialsContinue()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ), true );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdCorrectCredentialsContinueIncorrectFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$empty, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdIncorrectFailStopCorrectCredentials()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$empty, $options ), true );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdCorrectCredentialsStopIncorrectFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ), true );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$empty, $options  ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testHtpasswdIncorrectUsername()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'no such user', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdIncorrectPassword()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wrong password' );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$path ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdFileEmpty()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'foobar' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$empty, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdFileNoPasswords()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', '' );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationHtpasswdOptions();
        $options->plain = true;
        $authentication->addFilter( new ezcAuthenticationHtpasswdFilter( self::$nopass, $options ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testHtpasswdFileNotFound()
    {
        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );

        $this->missingFileTest( $filter, 'file', self::$missing );
    }

    public function testHtpasswdFileNoPermission()
    {
        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );

        $this->unreadableFileTest( $filter, 'file', 'htpasswd_unreadable' );
    }

    public function testHtpasswdOptions()
    {
        $options = new ezcAuthenticationHtpasswdOptions();

        $this->invalidPropertyTest( $options, 'plain', 'wrong value', 'bool' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testHtpasswdOptionsGetSet()
    {
        $options = new ezcAuthenticationHtpasswdOptions();

        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testHtpasswdProperties()
    {
        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );

        $this->invalidPropertyTest( $filter, 'file', 0, 'string' );
        $this->missingPropertyTest( $filter, 'no_such_property' );
    }

    public function testHtpasswdPropertiesIsSet()
    {
        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );

        $this->issetPropertyTest( $filter, 'file', true );
        $this->issetPropertyTest( $filter, 'no_such_property', false );
    }
}
?>
