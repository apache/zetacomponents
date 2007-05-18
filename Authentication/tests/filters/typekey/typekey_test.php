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
class ezcAuthenticationTypekeyTest extends ezcTestCase
{
    public static $token = '391jbj25WAQANzJrKvb5';
    public static $keysFile = 'http://www.typekey.com/extras/regkeys.txt';
    public static $keysFileMissing = '/tmp/this file cannot possibly exist';
    public static $keysFileUrlMissing = 'http://localhost/this file cannot possibly exist';

    public static $response = array(
        'name' => 'ezc',
        'nick' => 'ezctest',
        'email' => '5098f1e87a608675ded4d933f31899cae6b4f968',
        'ts' => '1176888597',
        'sig' => 'RaJ5rx U6tKZvs1dbOGktNxPmzA=:aSNNjdE/ZAuk/GQ7mTiQZe83a6E='
        );

    public static $responseEmpty = array(
        'name' => '',
        'nick' => '',
        'email' => '',
        'ts' => '',
        'sig' => ':'
        );

    public static $responseNull = array();

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationTypekeyTest" );
    }

    public function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) &&
             !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath or --with-gmp.' );
        }
    }

    public function tearDown()
    {

    }

    public function testTypekeyGmpCorrect()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }
        $_GET = self::$response;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTypekeyGmpFail()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }
        $_GET = self::$responseEmpty;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );
        $authentication->addFilter( $filter );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTypekeyGmpEmptyFail()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }
        $_GET = self::$responseNull;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );
        $authentication->addFilter( $filter );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTypekeyBcmathCorrect()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }
        $_GET = self::$response;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTypekeyBcmathFail()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }
        $_GET = self::$responseEmpty;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );
        $authentication->addFilter( $filter );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTypekeyBcmathEmptyFail()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }
        $_GET = self::$responseNull;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );
        $authentication->addFilter( $filter );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTypekeyValidityValid()
    {
        $_GET = self::$response;
        $validity = time() - $_GET['ts'] + 1000;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationTypekeyOptions();
        $options->validity = $validity;
        $filter = new ezcAuthenticationTypekeyFilter( $options );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testTypekeyValidityInvalid()
    {
        $_GET = self::$response;
        $validity = time() - $_GET['ts'] - 1000;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationTypekeyOptions();
        $options->validity = $validity;
        $filter = new ezcAuthenticationTypekeyFilter( $options );
        $authentication->addFilter( $filter );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testTypekeyPublicKeysFileLocal()
    {
        $tempDir = $this->createTempDir( 'ezcAuthenticationTypekeyTest' );
        $path = $tempDir . "/keys.txt";
        file_put_contents( $path, file_get_contents( self::$keysFile ) );
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationTypekeyOptions();
        $options->keysFile = $path;
        $filter = new ezcAuthenticationTypekeyFilter( $options );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );
        $this->removeTempDir();
    }

    public function testTypekeyPublicKeysFileEmpty()
    {
        $tempDir = $this->createTempDir( 'ezcAuthenticationTypekeyTest' );
        $path = $tempDir . "/keys_empty.txt";
        file_put_contents( $path, '' );
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationTypekeyOptions();
        $options->keysFile = $path;
        $filter = new ezcAuthenticationTypekeyFilter( $options );
        $authentication->addFilter( $filter );
        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationTypekeyException $e )
        {
            $expected = "Could not fetch public keys from '{$path}'.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
        $this->removeTempDir();
    }
    public function testTypekeyPublicKeysFileBroken()
    {
        $tempDir = $this->createTempDir( 'ezcAuthenticationTypekeyTest' );
        $path = $tempDir . "/keys_empty.txt";
        file_put_contents( $path, 'xxx' );
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationTypekeyOptions();
        $options->keysFile = $path;
        $filter = new ezcAuthenticationTypekeyFilter( $options );
        $authentication->addFilter( $filter );
        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationTypekeyException $e )
        {
            $expected = "The data retrieved from '{$path}' is invalid.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
        $this->removeTempDir();
    }

    public function testTypekeyPublicKeysFileMissing()
    {
        $path = self::$keysFileMissing;
        $options = new ezcAuthenticationTypekeyOptions();
        try
        {
            $options->keysFile = $path;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $expected = "The file '{$path}' could not be found.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testTypekeyPublicKeysFileUrlMissing()
    {
        $path = self::$keysFileUrlMissing;
        $options = new ezcAuthenticationTypekeyOptions();
        try
        {
            $options->keysFile = $path;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $expected = "The file '{$path}' could not be found.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testTypekeyPublicKeysFileNoPermission()
    {
        $tempDir = $this->createTempDir( 'ezcAuthenticationTypekeyTest' );
        $path = $tempDir . "/keys_unreadable.txt";
        $fh = fopen( $path, "wb" );
        fwrite( $fh, "some contents" );
        fclose( $fh );
        chmod( $path, 0 );
        try
        {
            $options = new ezcAuthenticationTypekeyOptions();
            $options->keysFile = $path;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for reading.", $e->getMessage() );
        }
        $this->removeTempDir();
    }

    public function testTypekeyOptions()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        try
        {
            $options->validity = 'wrong option value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong option value' that you were trying to assign to setting 'validity' is invalid. Allowed values are: int >= 0.", $e->getMessage() );
        }

        try
        {
            $options->keysFile = null;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '' that you were trying to assign to setting 'keysFile' is invalid. Allowed values are: string.", $e->getMessage() );
        }

        try
        {
            $options->requestSource = null;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '' that you were trying to assign to setting 'requestSource' is invalid. Allowed values are: array.", $e->getMessage() );
        }

        try
        {
            $options->wrong_option = 'wrong option value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'wrong_option'.", $e->getMessage() );
        }

        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testTypekeyProperties()
    {
        $filter = new ezcAuthenticationTypekeyFilter();
        $this->assertEquals( true, isset( $filter->lib ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->lib = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'lib' is invalid. Allowed values are: instance of ezcAuthenticationBignumLibrary.", $e->getMessage() );
        }

        try
        {
            $filter->no_such_property = "value";
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
