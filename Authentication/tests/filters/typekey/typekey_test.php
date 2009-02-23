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
include_once( 'data/typekey_wrapper.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationTypekeyTest extends ezcAuthenticationTest
{
    public static $token = '391jbj25WAQANzJrKvb5';
    public static $keysFile = 'http://www.typekey.com/extras/regkeys.txt';
    public static $keysFileMissing = '/tmp/this file cannot possibly exist';
    public static $keysFileUrlMissing = 'http://localhost/this file cannot possibly exist';
    public static $keysFileUrlUnconnectable = 'http://localhost.nothere/this file cannot possibly exist';

    public static $response = array(
        'name' => 'ezc',
        'nick' => 'ezctest',
        'email' => '5098f1e87a608675ded4d933f31899cae6b4f968',
        'ts' => '1176888597',
        'sig' => 'RaJ5rx U6tKZvs1dbOGktNxPmzA=:aSNNjdE/ZAuk/GQ7mTiQZe83a6E='
        );

    public static $responseWithEmail = array(
        'name' => 'ezc',
        'nick' => 'ezctest',
        'email' => 'alex.stanoi@gmail.com',
        'ts' => '1186560659',
        'sig' => 'iJxr041JbZ9jWNo84QPT3EuRjxg=:V4YOiYh7FeTFzRgwDSYLqcE4wKA='
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

        $filter = new ezcAuthenticationTypekeyWrapper();

        try
        {
            $filter->fetchPublicKeys( $path );
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

        $filter = new ezcAuthenticationTypekeyWrapper();

        try
        {
            $filter->fetchPublicKeys( $path );
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
        $options = new ezcAuthenticationTypekeyOptions();

        $this->missingFileTest( $options, 'keysFile', self::$keysFileMissing );
    }

    /**
     * Test for files not found at an existing host.
     *
     * If Apache or another web server is running on 'localhost' then it can
     * interfere with this test as a normal page can be returned even for non-existing
     * pages, instead of 404. So if a web server is running, this test is skipped.
     */
    public function testTypekeyPublicKeysFileUrlMissing()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        $headers = @get_headers( self::$keysFileUrlMissing );
        if ( $headers !== false && count( $headers ) > 0 )
        {
            $this->markTestSkipped( "This test works only if the web server (Apache, etc.) at 'localhost' is stopped." );
        }
        else
        {
            $this->missingFileTest( $options, 'keysFile', self::$keysFileUrlMissing );
        }
    }

    public function testTypekeyPublicKeysFileUrlUnconnectable()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        $this->missingFileTest( $options, 'keysFile', self::$keysFileUrlUnconnectable );
    }

    public function testTypekeyPublicKeysFileNoPermission()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        $this->unreadableFileTest( $options, 'keysFile', 'keys_unreadable.txt' );
    }

    public function testTypeKeyFetchExtraData()
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

        $expected = array( 'name' => array( 'ezc' ), 'nick' => array( 'ezctest' ) );
        $this->assertEquals( $expected, $filter->fetchData() );
    }

    public function testTypeKeyFetchExtraDataWithEmail()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }
        $_GET = self::$responseWithEmail;
        $credentials = new ezcAuthenticationIdCredentials( self::$token );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );
        $authentication->addFilter( $filter );
        $this->assertEquals( true, $authentication->run() );

        $expected = array( 'name' => array( 'ezc' ), 'nick' => array( 'ezctest' ), 'email' => array( 'alex.stanoi@gmail.com' ) );
        $this->assertEquals( $expected, $filter->fetchData() );
    }

    public function testTypekeyOptions()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        $this->invalidPropertyTest( $options, 'validity', 'wrong value', 'int >= 0' );
        $this->invalidPropertyTest( $options, 'validity', -1, 'int >= 0' );
        $this->invalidPropertyTest( $options, 'keysFile', null, 'string' );
        $this->invalidPropertyTest( $options, 'requestSource', null, 'array' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testTypekeyOptionsGetSet()
    {
        $options = new ezcAuthenticationTypekeyOptions();

        $filter = new ezcAuthenticationTypekeyFilter();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testTypekeyProperties()
    {
        $filter = new ezcAuthenticationTypekeyFilter();

        $this->invalidPropertyTest( $filter, 'lib', 'wrong value', 'ezcAuthenticationBignumLibrary' );
        $this->missingPropertyTest( $filter, 'no_such_property' );
    }

    public function testTypekeyPropertiesIsSet()
    {
        $filter = new ezcAuthenticationTypekeyFilter();

        $this->issetPropertyTest( $filter, 'lib', true );
        $this->issetPropertyTest( $filter, 'no_such_property', false );
    }
}
?>
