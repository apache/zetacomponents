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
        $filter->method = array( $filter, 'gmpCheck' );
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
        $filter->method = array( $filter, 'gmpCheck' );
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
        $filter->method = array( $filter, 'gmpCheck' );
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
        $filter->method = array( $filter, 'bcmathCheck' );
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
        $filter->method = array( $filter, 'bcmathCheck' );
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
        $filter->method = array( $filter, 'bcmathCheck' );
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

    public function testTypekeyOptions()
    {
        $_GET = self::$response;
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
        $_GET = self::$response;
        $filter = new ezcAuthenticationTypekeyFilter();
        $this->assertEquals( true, isset( $filter->method ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->method = array();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'a:0:{}' that you were trying to assign to setting 'method' is invalid. Allowed values are: callback.", $e->getMessage() );
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

    public function testTypekeyExceptions()
    {
        $e = new ezcAuthenticationTypekeyException( "Could not connect to host 'localhost'." );
        $this->assertEquals( "Could not connect to host 'localhost'.", $e->getMessage() );
    }
}
?>
