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
include_once( 'data/openid_store_helper.php' );
include_once( 'data/openid_wrapper.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationOpenidTest extends ezcAuthenticationTest
{
    public static $url = "http://ezc.myopenid.com/";
    public static $urlIncomplete = "ezc.myopenid.com";
    public static $urlNonexistent = "xxx";
    public static $urlEmpty = null;
    public static $urlNoOpenid = "http://www.google.com";

    public static $provider = "http://www.myopenid.com/server";

    public static $requestCheckImmediate = array(
        'openid.return_to' => 'http://localhost',
        'openid.trust_root' => 'http://ezc.myopenid.com',
        'openid.identity' => 'http://ezc.myopenid.com',
        'openid.mode' => 'checkid_immediate',
        );

    public static $requestCheckImmediateGoogle = array(
        // uses OpenID 2.0
        'openid.return_to' => 'http://localhost',
        'openid.trust_root' => 'https://www.google.com/accounts/o8/ud', // this is the endpoint actually
        'openid.identity' => 'https://www.google.com/accounts/o8/id?id=AItOawl5aAXS9Ue7hH2Nrs5LpIquof19wRCTwN4', // ezcomponents at gmail.com
        'openid.mode' => 'checkid_immediate',
        );

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
        'openid_mode' => 'check_authentication'
        );

    public static $requestCheckAuthenticationGetExtraData = array(
        'openid_assoc_handle' => '{HMAC-SHA1}{4640581a}{3X/rrw==}',
        'openid_signed' => 'return_to,mode,identity,sreg.fullname,sreg.gender,sreg.country,sreg.language',
        'openid_sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E=',
        'openid_return_to' => 'http://localhost',
        'openid_identity' => 'http://ezc.myopenid.com',
        'openid_op_endpoint' => 'http://www.myopenid.com/server',
        'openid_mode' => 'check_authentication',
        'openid_sreg_fullname' => 'John Doe',
        'openid_sreg_gender' => 'M',
        'openid_sreg_country' => 'US',
        'openid_sreg_language' => 'FR'
        );

    public static $requestCheckAuthenticationGetNoEndPoint = array(
        'openid_assoc_handle' => '{HMAC-SHA1}{4640581a}{3X/rrw==}',
        'openid_signed' => 'return_to,mode,identity',
        'openid_sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E=',
        'openid_return_to' => 'http://localhost',
        'openid_identity' => 'http://ezc.myopenid.com',
        'openid_mode' => 'check_authentication',
        );

    public static $requestSmart = array(
       'openid.assoc_handle' => '{HMAC-SHA1}{465d8eb9}{NQN84Q==}',
       'openid.signed' => 'assoc_handle,identity,mode,op_endpoint,response_nonce,return_to,signed',
       'openid.sig' => 'HkLMUymWy3/GmHWVuWYOs9IHkrs=',
       'openid.mode' => 'id_res',
       'openid.identity' => 'http://ezc.myopenid.com/',
       'openid.op_endpoint' => 'http://www.myopenid.com/server',
       'openid.response_nonce' => '2007-05-31T08:33:59ZLdyyJF',
       'openid.return_to' => 'http://localhost/openid.php?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com&nonce=770890',
       );

    public static $requestSmartGet = array(
       'nonce' => '770890',
       'openid_assoc_handle' => '{HMAC-SHA1}{465d8eb9}{NQN84Q==}',
       'openid_signed' => 'assoc_handle,identity,mode,op_endpoint,response_nonce,return_to,signed',
       'openid_sig' => 'HkLMUymWy3/GmHWVuWYOs9IHkrs=',
       'openid_mode' => 'id_res',
       'openid_identity' => 'http://ezc.myopenid.com/',
       'openid_op_endpoint' => 'http://www.myopenid.com/server',
       'openid_response_nonce' => '2007-05-31T08:33:59ZLdyyJF',
       'openid_return_to' => 'http://localhost/openid.php?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com&nonce=770890',
       );

    public static $association;

    public static $requestEmpty = null;

    public static $server = array(
        'HTTP_HOST' => 'localhost',
        'REQUEST_URI' => '/openid.php?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com',
        );

    public static $p = '155172898181473697471232257763715539915724801966915404479707795314057629378541917580651227423698188993727816152646631438561595825688188889951272158842675419950341258706556549803580104870537681476726513255747040765857479291291572334510643245094715007229621094194349783925984760375594985848253359305585439638443';

    public static $q = '2';

    public static function suite()
    {
        self::$association = new ezcAuthenticationOpenidAssociation( '{HMAC-SHA1}{465d8eb9}{NQN84Q==}',
                                                                     'foz3UXCxQJ5lKvau78Oqen9dTUc=',
                                                                     1180536597,
                                                                     time() - 1180536597 + 604800, // valid 1 week from current time
                                                                     'HMAC-SHA1' );

        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationOpenidTest" );
    }

    public function setUp()
    {
        $this->origGet = $_GET;
        $this->origServer = $_SERVER;
        $_GET = self::$requestEmpty;
        $_SERVER = self::$server;
    }

    public function tearDown()
    {
        $_GET = $this->origGet;
        $_SERVER = $this->origServer;
    }

    public function testOpenidWrapperCheckSignatureSmart()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->checkSignatureSmart( self::$association, self::$requestSmart );
        $this->assertEquals( true, $result );
    }

    public function testOpenidWrapperCheckSignatureSmartWrong()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        self::$requestSmart['openid.mode'] = 'check_authentication';
        $result = $filter->checkSignatureSmart( self::$association, self::$requestSmart );
        $this->assertEquals( false, $result );
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
            $result = $e->getMessage();
            $result = preg_replace( '@nonce%3D.{6}@', 'nonce%3Dxxxxxx', $result );

            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3Dxxxxxx&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";

            $this->assertEquals( $expected, $result );
        }
    }

    /**
     * Test for feature request #12935 (Customize return URL on OpenID authentification).
     *
     * As redirection does not work with CLI, only the redirection error message is checked.
     */
    public function testOpenidCliExceptionReturnUrl()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );

        $options = new ezcAuthenticationOpenidOptions();
        $options->returnUrl = 'http://another.localhost/';

        $filter = new ezcAuthenticationOpenidFilter( $options );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Fanother.localhost%2F%3Fnonce%3D145395&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 115 ), substr( $result, 0, 115 ) );
            $this->assertEquals( substr( $expected, 121 ), substr( $result, 121 ) );
        }
    }

    public function testOpenidCliExceptionRegisterFetchData()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $filter = new ezcAuthenticationOpenidFilter();
        $filter->registerFetchData( array( 'fullname', 'gender', 'country', 'language' ) );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D859610&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.sreg.optional=fullname,gender,country,language&openid.ns.sreg=http%3A%2F%2Fopenid.net%2Fsreg%2F1.0&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 192 ), substr( $result, 0, 192 ) );
            $this->assertEquals( substr( $expected, 198 ), substr( $result, 198 ) );
        }
    }

    public function testOpenidCliExceptionFileStoreNonce()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $path = $this->createTempDir( get_class( $this ) );
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $filter = new ezcAuthenticationOpenidFilter( $options );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D859610&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 192 ), substr( $result, 0, 192 ) );
            $this->assertEquals( substr( $expected, 198 ), substr( $result, 198 ) );

            // on Linux there are also the files '.' and '..'
            if ( substr( php_uname( 's' ), 0, 7 ) === 'Windows' )
            {
                $this->assertEquals( 1, count( ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
            }
            else
            {
                $this->assertEquals( 3, count( ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
            }

            $this->removeTempDir();
        }
    }

    public function testOpenidWrapperDiscoverHtmlUrl()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverHtml( self::$url );
        $expected = array( 
            'openid.server' => array( 0 => 'http://www.myopenid.com/server' ),
            'openid2.provider' => array( 0 => 'http://www.myopenid.com/server' ) );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverHtmlUrlIncomplete()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverHtml( self::$urlIncomplete );
        $expected = array( 
            'openid.server' => array( 0 => 'http://www.myopenid.com/server' ),
            'openid2.provider' => array( 0 => 'http://www.myopenid.com/server' ) );
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
            $expected = "Could not connect to http://xxx. Type 'text/html' not supported.";
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
            $expected = "Could not connect to http://xxx. Type 'application/xrds+xml' not supported.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidWrapperDiscoverXrdsUrl()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverXrds( self::$url );
        $expected = array(
            'openid2.provider' => array( 'http://www.myopenid.com/server',
                                         'http://www.myopenid.com/server',
                                         'http://www.myopenid.com/server'
                                    ),
                         );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverXrdsUrlIncomplete()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverXrds( self::$urlIncomplete );
        $expected = array(
            'openid2.provider' => array( 'http://www.myopenid.com/server',
                                         'http://www.myopenid.com/server',
                                         'http://www.myopenid.com/server'
                                    ),
                         );
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverXrdsUrlNoOpenid()
    {
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->discoverXrds( self::$urlNoOpenid );
        $expected = array();
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidWrapperDiscoverXrdsUrlNonexistent()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNonexistent );
        $filter = new ezcAuthenticationOpenidWrapper();

        try
        {
            $result = $filter->discoverXrds( self::$urlNonexistent );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $expected = "Could not connect to http://xxx. Type 'application/xrds+xml' not supported.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testOpenidWrapperCheckSignature()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->checkSignature( self::$provider, self::$requestCheckAuthentication );
        $this->assertEquals( false, $result );
    }

    public function testOpenidWrapperCheckSignaturePost()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->checkSignature( self::$provider, self::$requestCheckAuthentication, 'POST' );

        // for some reason POST requests don't work, whereas GET requests work
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

    public function testOpenidCaseNullSmartModeNoStore()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $filter = new ezcAuthenticationOpenidFilter( $options );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D859610&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 192 ), substr( $result, 0, 192 ) );
            $this->assertEquals( substr( $expected, 198 ), substr( $result, 198 ) );
        }
    }

    public function testOpenidCaseNullSmartModeFileStore()
    {
        if ( ! ( ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) || ezcBaseFeatures::hasExtensionSupport( 'gmp' ) ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-bcmath or --with-gmp.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;

        $path = $this->createTempDir( get_class( $this ) );
        $options->store = new ezcAuthenticationOpenidFileStore( $path );
        $filter = new ezcAuthenticationOpenidFilter( $options );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D859610&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup&openid.assoc_handle=%7BHMAC-SHA1%7D%7B465e9054%7D%7BIUO7yw%3D%3D%7D'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 192 ), substr( $result, 0, 192 ) );

            $files = ezcAuthenticationOpenidFileStoreHelper::getFiles( $path );
            foreach ( $files as $file )
            {
                if ( $file !== '.' && $file !== '..' )
                {
                    break;
                }
            }
            $data = unserialize( file_get_contents( $path . DIRECTORY_SEPARATOR . $file ) );
            $this->assertEquals( 'HMAC-SHA1', $data->type );
        }
        
        $this->removeTempDir();
    }

    public function testOpenidCaseNullSmartModeFileStoreFailHostInaccessible()
    {
        if ( ! ( ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) || ezcBaseFeatures::hasExtensionSupport( 'gmp' ) ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-bcmath or --with-gmp.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;

        $path = $this->createTempDir( get_class( $this ) );
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'discover' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'discover' )
               ->will( $this->returnValue( array( 'openid.server' => array( '' ) ) ) );

        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not connect to host :443:";
            $this->assertEquals( $expected, substr( $result, 0, strlen( $expected ) ) );
        }
        $this->removeTempDir();
    }

    public function testOpenidCaseNullSmartModeFileStoreExistent()
    {
        if ( ! ( ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) || ezcBaseFeatures::hasExtensionSupport( 'gmp' ) ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-bcmath or --with-gmp.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $res = $filter->associate( self::$provider, $params );
        $secret = isset( $res['enc_mac_key'] ) ? $res['enc_mac_key'] : $res['mac_key'];
        $association = new ezcAuthenticationOpenidAssociation( $res['assoc_handle'],
                                                               $secret,
                                                               time(),
                                                               $res['expires_in'],
                                                               $res['assoc_type'] );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;

        $path = $this->createTempDir( get_class( $this ) );
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $options->store->storeAssociation( self::$provider, $association );

        $filter = new ezcAuthenticationOpenidFilter( $options );
        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not redirect to 'http://www.myopenid.com/server?openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D859610&openid.trust_root=http%3A%2F%2Flocalhost&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.mode=checkid_setup'. Most probably your browser does not support redirection or JavaScript.";
            $this->assertEquals( substr( $expected, 0, 192 ), substr( $result, 0, 192 ) );

            $files = ezcAuthenticationOpenidFileStoreHelper::getFiles( $path );
            foreach ( $files as $file )
            {
                if ( $file !== '.' && $file !== '..' )
                {
                    break;
                }
            }
            $data = unserialize( file_get_contents( $path . DIRECTORY_SEPARATOR . $file ) );
            $this->assertEquals( 'HMAC-SHA1', $data->type );
        }
        
        $this->removeTempDir();
    }

    public function testOpenidImmediateCaseNullUrlNonexistent()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNonexistent );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;

        $filter = new ezcAuthenticationOpenidFilter( $options );

        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not connect to http://xxx. Type 'application/xrds+xml' not supported.";
            $this->assertEquals( $expected, substr( $result, 0, strlen( $expected ) ) );
        }
    }

    public function testOpenidWrapperImmediateCheckImmediateUrlNoOpenid()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNoOpenid );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;

        $filter = new ezcAuthenticationOpenidWrapper( $options );

        $setupUrl = $filter->checkImmediate( self::$provider, self::$requestCheckImmediate );

        $setupUrl = $filter->getSetupUrl();
        $this->assertEquals( false, $setupUrl );
        $this->assertEquals( true, is_bool( $setupUrl ) );
    }

    public function testOpenidWrapperImmediateCheckImmediateUrlNoOpenidGoogle()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$urlNoOpenid );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;
        $options->openidVersion = ezcAuthenticationOpenidFilter::VERSION_2_0;

        $filter = new ezcAuthenticationOpenidWrapper( $options );

        $setupUrl = $filter->checkImmediate( self::$provider, self::$requestCheckImmediateGoogle );

        $setupUrl = $filter->getSetupUrl();
        $this->assertEquals( false, $setupUrl );
        $this->assertEquals( true, is_bool( $setupUrl ) );
    }

    public function testOpenidWrapperImmediateNoSetupUrl()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'generateNonce', 'discover' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'generateNonce' )
               ->will( $this->returnValue( '123456' ) );

        $filter->expects( $this->any() )
               ->method( 'discover' )
               ->will( $this->returnValue( array( 'openid.server' => array( 'http://www.google.com/' ) ) ) );

        $result = $filter->run( $credentials );

        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_URL_INCORRECT, $result );

        $setupUrl = $filter->getSetupUrl();
        $this->assertEquals( false, $setupUrl );
        $this->assertEquals( true, is_bool( $setupUrl ) );
    }

    public function testOpenidMockImmediateCaseNull()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'generateNonce' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'generateNonce' )
               ->will( $this->returnValue( '123456' ) );

        $authentication->addFilter( $filter );

        $authentication->run();
        $setupUrl = $filter->getSetupUrl();
        $expected = "http://www.myopenid.com/server?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com&nonce=123456&openid.assoc_handle=%7BHMAC-SHA1%7D%7B46c3086c%7D%7B%2F3r4xA%3D%3D%7D&openid.mode=checkid_setup&openid.sig=miZkmdlb3%2BPDCASwZzAqxQfZqn4%3D&openid.signed=assoc_handle%2Cmode%2Csigned%2Cuser_setup_url&openid.user_setup_url=http%3A%2F%2Fwww.myopenid.com%2Fserver%3Fopenid.claimed_id%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.identity%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.mode%3Dcheckid_setup%26openid.return_to%3Dhttp%253A%252F%252Flocalhost%252Fopenid.php%253Faction%253Dlogin%2526openid_identifier%253Dhttp%25253A%25252F%25252Fezc.myopenid.com%2526nonce%253D123456%26openid.trust_root%3Dhttp%253A%252F%252Flocalhost&openid.claimed_id=http%3A%2F%2Fezc.myopenid.com%2F&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D123456&openid.trust_root=http%3A%2F%2Flocalhost";
        $this->assertEquals( substr( $expected, 0, 138 ), substr( $setupUrl, 0, 138 ) );
        $this->assertEquals( substr( $expected, strpos( $expected, 'openid.signed' ) ), substr( $setupUrl, strpos( $setupUrl, 'openid.signed' ) ) );
    }

    public function testOpenidMockImmediateCaseNullFailHostInaccessible()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();

        $options->immediate = true;

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'generateNonce', 'discover' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'generateNonce' )
               ->will( $this->returnValue( '123456' ) );

        $filter->expects( $this->any() )
               ->method( 'discover' )
               ->will( $this->returnValue( array( 'openid.server' => array( '' ) ) ) );

        $authentication->addFilter( $filter );

        try
        {
            $authentication->run();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not connect to host :80:";
            $this->assertEquals( $expected, substr( $result, 0, strlen( $expected ) ) );
        }
    }

    public function testOpenidMockImmediateCaseNullSmartModeNoStore()
    {
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;

        $options->immediate = true;

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'generateNonce' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'generateNonce' )
               ->will( $this->returnValue( '123456' ) );

        $authentication->addFilter( $filter );

        $authentication->run();
        $setupUrl = $filter->getSetupUrl();
        $expected = "http://www.myopenid.com/server?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com&nonce=123456&openid.assoc_handle=%7BHMAC-SHA1%7D%7B46c3086c%7D%7B%2F3r4xA%3D%3D%7D&openid.mode=checkid_setup&openid.sig=miZkmdlb3%2BPDCASwZzAqxQfZqn4%3D&openid.signed=assoc_handle%2Cmode%2Csigned%2Cuser_setup_url&openid.user_setup_url=http%3A%2F%2Fwww.myopenid.com%2Fserver%3Fopenid.claimed_id%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.identity%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.mode%3Dcheckid_setup%26openid.return_to%3Dhttp%253A%252F%252Flocalhost%252Fopenid.php%253Faction%253Dlogin%2526openid_identifier%253Dhttp%25253A%25252F%25252Fezc.myopenid.com%2526nonce%253D123456%26openid.trust_root%3Dhttp%253A%252F%252Flocalhost&openid.claimed_id=http%3A%2F%2Fezc.myopenid.com%2F&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D123456&openid.trust_root=http%3A%2F%2Flocalhost";
        $this->assertEquals( substr( $expected, 0, 138 ), substr( $setupUrl, 0, 138 ) );
        $this->assertEquals( substr( $expected, strpos( $expected, 'openid.signed' ) ), substr( $setupUrl, strpos( $setupUrl, 'openid.signed' ) ) );
    }

    public function testOpenidMockImmediateCaseNullSmartModeFileStore()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) &&
             !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath or --with-gmp.' );
        }

        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $authentication = new ezcAuthentication( $credentials );
        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $path = $this->createTempDir( get_class( $this ) );
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $options->immediate = true;

        $filter = $this->getMock( 'ezcAuthenticationOpenidFilter', array( 'generateNonce' ), array( $options ) );
        $filter->expects( $this->any() )
               ->method( 'generateNonce' )
               ->will( $this->returnValue( '123456' ) );

        $authentication->addFilter( $filter );

        $authentication->run();
        $this->removeTempDir();

        $setupUrl = $filter->getSetupUrl();
        $expected = "http://www.myopenid.com/server?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com&nonce=123456&openid.assoc_handle=%7BHMAC-SHA1%7D%7B46c3086c%7D%7B%2F3r4xA%3D%3D%7D&openid.mode=checkid_setup&openid.sig=miZkmdlb3%2BPDCASwZzAqxQfZqn4%3D&openid.claimed_id%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.identity%3Dhttp%253A%252F%252Fezc.myopenid.com%252F%26openid.mode%3Dcheckid_setup%26openid.return_to%3Dhttp%253A%252F%252Flocalhost%252Fopenid.php%253Faction%253Dlogin%2526openid_identifier%253Dhttp%25253A%25252F%25252Fezc.myopenid.com%2526nonce%253D123456%26openid.trust_root%3Dhttp%253A%252F%252Flocalhost&openid.claimed_id=http%3A%2F%2Fezc.myopenid.com%2F&openid.identity=http%3A%2F%2Fezc.myopenid.com%2F&openid.return_to=http%3A%2F%2Flocalhost%2Fopenid.php%3Faction%3Dlogin%26openid_identifier%3Dhttp%253A%252F%252Fezc.myopenid.com%26nonce%3D123456&openid.trust_root=http%3A%2F%2Flocalhost";
        $this->assertEquals( substr( $expected, 0, 138 ), substr( $setupUrl, 0, 138 ) );
        $this->assertEquals( substr( $expected, strpos( $expected, 'openid.claimed_id' ) ), substr( $setupUrl, strpos( $setupUrl, 'openid.claimed_id' ) ) );
    }

    public function testOpenidWrapperRunModeIdRes()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );
        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResFailHostInaccessible()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $_GET['openid_op_endpoint'] = '';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper();

        try
        {
            $filter->run( $credentials );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcAuthenticationOpenidException $e )
        {
            $result = $e->getMessage();
            $expected = "Could not connect to host :443:";
            $this->assertEquals( $expected, substr( $result, 0, strlen( $expected ) ) );
        }
    }

    public function testOpenidWrapperRunModeIdResSmartModeFileStore()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResSmartModeFileStoreExistent()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $res = $filter->associate( self::$provider, $params );
        $secret = isset( $res['enc_mac_key'] ) ? $res['enc_mac_key'] : $res['mac_key'];
        $association = new ezcAuthenticationOpenidAssociation( $res['assoc_handle'],
                                                               $secret,
                                                               time(),
                                                               $res['expires_in'],
                                                               $res['assoc_type'] );

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidFileStore( $path );
        $options->store->storeAssociation( self::$provider, $association );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResSmartModeFileStoreExistentCorrect()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $association = self::$association;
        $_GET = self::$requestSmartGet;
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidFileStore( $path );
        $options->store->storeAssociation( self::$provider, $association );
        $options->store->storeNonce( $_GET['nonce'] );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );

        $this->removeTempDir();

        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_OK, $result );
    }

    public function testOpenidWrapperRunModeIdResFileStore()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResFileStoreExistent()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResFileStoreNonceValid()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $nonce = '123456';
        $_GET['openid_return_to'] = ezcAuthenticationUrl::appendQuery( $_GET['openid_return_to'], 'nonce', $nonce );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidFileStore( $path );
        $options->store->storeNonce( $nonce );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResFileStoreNonceValidFetchExtraData()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGetExtraData;
        $_GET['openid_mode'] = 'id_res';
        $nonce = '123456';
        $_GET['openid_return_to'] = ezcAuthenticationUrl::appendQuery( $_GET['openid_return_to'], 'nonce', $nonce );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidFileStore( $path );
        $options->store->storeNonce( $nonce );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper( $options );

        // not necessary at this step (id_res), would have been necessary at the previous step (login)
        $filter->registerFetchData( array( 'fullname', 'gender', 'country', 'language' ) );

        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );

        $this->removeTempDir();

        $expected = array( 'fullname' => array( 'John Doe' ),
                           'gender' => array( 'M' ),
                           'country' => array( 'US' ),
                           'language' => array( 'FR' )
                         );
        $this->assertEquals( $expected, $filter->fetchData() );
    }

    public function testOpenidWrapperRunModeIdResFileStoreNonceInvalid()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $nonce = '123456';
        $_GET['openid_return_to'] = ezcAuthenticationUrl::appendQuery( $_GET['openid_return_to'], 'nonce', $nonce );

        $path = $this->createTempDir( get_class( $this ) );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidFileStore( $path );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );

        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_NONCE_INCORRECT, $result );

        $this->removeTempDir();
    }

    public function testOpenidWrapperRunModeIdResNoEndPoint()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

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

    public function testOpenidWrapperGenerateNonce()
    {
        $filter = new ezcAuthenticationOpenidWrapper();

        $this->assertEquals( 6, strlen( $filter->generateNonce() ) );

        $this->assertEquals( 1, strlen( $filter->generateNonce( 1 ) ) );
        $this->assertEquals( 2, strlen( $filter->generateNonce( 2 ) ) );
        $this->assertEquals( 3, strlen( $filter->generateNonce( 3 ) ) );
        $this->assertEquals( 4, strlen( $filter->generateNonce( 4 ) ) );
        $this->assertEquals( 5, strlen( $filter->generateNonce( 5 ) ) );
        $this->assertEquals( 6, strlen( $filter->generateNonce( 6 ) ) );
        $this->assertEquals( 7, strlen( $filter->generateNonce( 7 ) ) );
    }

    public function testOpenidWrapperAssociatePlainText()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->associate( self::$provider, $params );
        $this->assertNotEquals( false, $result );
        $this->assertEquals( true, isset( $result['assoc_handle'] ) );
        $this->assertEquals( true, isset( $result['mac_key'] ) );
    }

    public function testOpenidWrapperAssociatePlainTextPost()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->associate( self::$provider, $params, 'POST' );

        // for some reason POST requests don't work, whereas GET requests work
        $this->assertEquals( false, $result );
        $this->assertEquals( false, isset( $result['assoc_handle'] ) );
        $this->assertEquals( false, isset( $result['mac_key'] ) );
    }

    public function testOpenidWrapperAssociateDhSha1Bcmath()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        $private = $lib->rand( self::$p );
        $private = $lib->add( $private, 1 );
        $public = $lib->powmod( self::$q, $private, self::$p );

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            // 'openid.session_type' => 'DH-SHA1',
            'openid.dh_modulus' => urlencode( base64_encode( $lib->btwoc( self::$p ) ) ),
            'openid.dh_gen' => 2, urlencode( base64_encode( $lib->btwoc( self::$q ) ) ),
            'openid.dh_consumer_public' => urlencode( base64_encode( $lib->btwoc( $public ) ) )
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->associate( self::$provider, $params );
        $this->assertNotEquals( false, $result );
        $this->assertEquals( true, isset( $result['assoc_handle'] ) );
        $this->assertEquals( true, isset( $result['mac_key'] ) );
    }

    public function testOpenidWrapperAssociateDhSha1Gmp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        $private = $lib->rand( self::$p );
        $private = $lib->add( $private, 1 );
        $public = $lib->powmod( self::$q, $private, self::$p );

        $params = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' => 'HMAC-SHA1',
            // 'openid.session_type' => 'DH-SHA1',
            'openid.dh_modulus' => urlencode( base64_encode( $lib->btwoc( self::$p ) ) ),
            'openid.dh_gen' => 2, urlencode( base64_encode( $lib->btwoc( self::$q ) ) ),
            'openid.dh_consumer_public' => urlencode( base64_encode( $lib->btwoc( $public ) ) )
            );

        $filter = new ezcAuthenticationOpenidWrapper();
        $result = $filter->associate( self::$provider, $params );
        $this->assertNotEquals( false, $result );
        $this->assertEquals( true, isset( $result['assoc_handle'] ) );
        $this->assertEquals( true, isset( $result['mac_key'] ) );
    }

    public function testOpenidOptions()
    {
        $options = new ezcAuthenticationOpenidOptions();

        $this->invalidPropertyTest( $options, 'mode', 'wrong value', '1, 2' );
        $this->invalidPropertyTest( $options, 'mode', '1', '1, 2' );
        $this->invalidPropertyTest( $options, 'mode', 1000, '1, 2' );
        $this->invalidPropertyTest( $options, 'store', 'wrong value', 'ezcAuthenticationOpenidStore || null' );
        $this->invalidPropertyTest( $options, 'nonceKey', 0, 'string' );
        $this->invalidPropertyTest( $options, 'nonceLength', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'nonceLength', 0, 'int >= 1' );
        $this->invalidPropertyTest( $options, 'nonceValidity', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'nonceValidity', 0, 'int >= 1' );
        $this->invalidPropertyTest( $options, 'timeout', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'timeout', 0, 'int >= 1' );
        $this->invalidPropertyTest( $options, 'timeoutOpen', 'wrong value', 'int >= 1' );
        $this->invalidPropertyTest( $options, 'timeoutOpen', 0, 'int >= 1' );
        $this->invalidPropertyTest( $options, 'requestSource', null, 'array' );
        $this->invalidPropertyTest( $options, 'immediate', 'wrong value', 'bool' );
        $this->invalidPropertyTest( $options, 'returnUrl', array(), 'string' );
        $this->missingPropertyTest( $options, 'no_such_option' );
    }

    public function testOpenidOptionsGetSet()
    {
        $options = new ezcAuthenticationOpenidOptions();

        $filter = new ezcAuthenticationOpenidFilter();
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }
}
?>
