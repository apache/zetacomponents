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
class ezcAuthenticationHtpasswdTest extends ezcTestCase
{
    private static $path = null;
    private static $empty = null;
    private static $nopass = null;

    public static function suite()
    {
        self::$path = dirname( __FILE__ ) . '/data/htpasswd';
        self::$empty = dirname( __FILE__ ) . '/data/htpasswd_empty';
        self::$nopass = dirname( __FILE__ ) . '/data/htpasswd_no_passwords';
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
        $path = dirname( __FILE__ ) . '/data/htpassw';
        try
        {
            $filter = new ezcAuthenticationHtpasswdFilter( $path );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file '{$path}' could not be found.", $e->getMessage() );
        }
    }

    public function testHtpasswdFileNoPermission()
    {
        $tempDir = $this->createTempDir( 'ezcAuthenticationHtpasswdTest' );
        $path = $tempDir . "/htpasswd_unreadable";
        $fh = fopen( $path, "wb" );
        fwrite( $fh, "john.doe:wpeE20wyWHnLE" );
        fclose( $fh );
        chmod( $path, 0 );
        try
        {
            $filter = new ezcAuthenticationHtpasswdFilter( $path );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for reading.", $e->getMessage() );
        }
        $this->removeTempDir();
    }

    public function testHtpasswdOptions()
    {
        $options = new ezcAuthenticationHtpasswdOptions();

        try
        {
            $options->plain = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'plain' is invalid. Allowed values are: bool.", $e->getMessage() );
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

        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );

    }

    public function testProperties()
    {
        $filter = new ezcAuthenticationHtpasswdFilter( self::$path );
        $this->assertEquals( true, isset( $filter->file ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->file = 0;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $expected = "The value '0' that you were trying to assign to setting 'file' is invalid. Allowed values are: string.";
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
?>
