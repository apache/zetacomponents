<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'data/openid_wrapper.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationOpenidTest extends ezcTestCase
{
    public static $url = "http://ezc.myopenid.com";
    public static $urlIncomplete = "ezc.myopenid.com";
    public static $urlNonexistent = "xxx";
    public static $urlEmpty = null;
    public static $urlNoOpenid = "http://www.google.com";

    public static $provider = "http://www.myopenid.com/server";

    public static $requestCheckAuthentication = array(
        'openid.assoc_handle' => '%7BHMAC-SHA1%7D%7B4640581a%7D%7B3X%2Frrw%3D%3D%7D',
        'openid.signed' => 'return_to%2Cmode%2Cidentity',
        'openid.sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E%3D',
        'openid.return_to' => 'http://localhost',
        'openid.identity' => 'http://ezc.myopenid.com',
        'openid.op_endpoint' => 'http://www.myopenid.com/server',
        'openid.mode' => 'check_authentication',
        );

    public static $requestCheckAuthenticationGet = array(
        'openid_assoc_handle' => '{HMAC-SHA1}{4640581a}{3X/rrw==}',
        'openid_signed' => 'return_to,mode,identity',
        'openid_sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E=',
        'openid_return_to' => 'http://localhost',
        'openid_identity' => 'http://ezc.myopenid.com',
        'openid_op_endpoint' => 'http://www.myopenid.com/server',
        'openid_mode' => 'check_authentication',
        );

    public static $requestCheckAuthenticationGetNoEndPoint = array(
        'openid_assoc_handle' => '{HMAC-SHA1}{4640581a}{3X/rrw==}',
        'openid_signed' => 'return_to,mode,identity',
        'openid_sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E=',
        'openid_return_to' => 'http://localhost',
        'openid_identity' => 'http://ezc.myopenid.com',
        'openid_mode' => 'check_authentication',
        );

    public static $requestEmpty = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationOpenidTest" );
    }

    public function setUp()
    {
        $_GET = self::$requestEmpty;
    }

    public function tearDown()
    {

    }

    public function testOpenidCliException()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationOpenidFilter();
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2F&openid.trust_root=http%3A%2F%2F&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidWrapperDiscoverHtmlUrl()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverHtml( self::$url );
        $expected = array( 'openid.server' => array( 0 => 'http://www.myopenid.com/server' ) );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverHtmlUrlIncomplete()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverHtml( self::$urlIncomplete );
        $expected = array( 'openid.server' => array( 0 => 'http://www.myopenid.com/server' ) );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverHtmlUrlNoOpenid()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverHtml( self::$urlNoOpenid );
        $expected = array();
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverHtmlUrlNonexistent()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNonexistent );
        $filter = new ezcAuthenticationOpenidWrapper();

        try
        {
            $result = $filter->discoverHtml( self::$urlNonexistent );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $expected = "Could not connect to host xxx:80: .";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidWrapperDiscoverYadisUrl()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverYadis( self::$url );
        $expected = array(
            'openid.server' => array( 'http://www.myopenid.com/server',
                                      'http://www.myopenid.com/server',
                                      'http://www.myopenid.com/server'
                                    ),
            'openid.delegate' => array( 'http://ezc.myopenid.com/',
                                        'http://ezc.myopenid.com/'
                                      )
                         );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverYadisUrlIncomplete()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverYadis( self::$urlIncomplete );
        $expected = array(
            'openid.server' => array( 'http://www.myopenid.com/server',
                                      'http://www.myopenid.com/server',
                                      'http://www.myopenid.com/server'
                                    ),
            'openid.delegate' => array( 'http://ezc.myopenid.com/',
                                        'http://ezc.myopenid.com/'
                                      )
                         );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverYadisUrlNoOpenid()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverYadis( self::$urlNoOpenid );
        $expected = array();
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverYadisUrlNonexistent()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNonexistent );
        $filter = new ezcAuthenticationOpenidWrapper();

        try
        {
            $result = $filter->discoverYadis( self::$urlNonexistent );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $expected = "Could not connect to host xxx:80: .";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidWrapperCheckSignature()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->checkSignature( self::$provider, self::$requestCheckAuthentication );
        $this->assertEquals( false, $result );
    }

    public function testOpenidWrapperRunModeNullUrlEmpty()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlEmpty );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeNullUrlNoOpenid()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNoOpenid );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdRes()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResNoEndPoint()
    {
        $_GET = self::$requestCheckAuthenticationGetNoEndPoint;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResNoEndPointUrlNoOpenid()
    {
        $_GET = self::$requestCheckAuthenticationGetNoEndPoint;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNoOpenid );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeCheckidSetup()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'checkid_setup';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_CANCELLED, $result );
    }

    public function testOpenidWrapperRunModeCancel()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'cancel';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_CANCELLED, $result );
    }

    public function testOpenidWrapperRunModeUnknown()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'no such mode';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        try
        {
            $result = $filter->run( $credentials );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $expected = "OpenID request not supported: 'openid_mode = no such mode'.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidOptions()
    {
        $options = new ezcAuthenticationOpenidOptions();

        try
        {
            $options->timeout = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'timeout' is invalid. Allowed values are: int >= 1.", $e->getMessage() );
        }

        try
        {
            $options->timeout = 0;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '0' that you were trying to assign to setting 'timeout' is invalid. Allowed values are: int >= 1.", $e->getMessage() );
        }

        try
        {
            $options->timeoutOpen = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'timeoutOpen' is invalid. Allowed values are: int >= 1.", $e->getMessage() );
        }

        try
        {
            $options->timeoutOpen = 0;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value '0' that you were trying to assign to setting 'timeoutOpen' is invalid. Allowed values are: int >= 1.", $e->getMessage() );
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
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $filter = new ezcAuthenticationOpenidFilter();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }
}
?>
