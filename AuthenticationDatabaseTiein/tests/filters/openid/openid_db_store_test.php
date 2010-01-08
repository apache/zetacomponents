<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 */

include_once( 'AuthenticationDatabaseTiein/tests/test.php' );
include_once( 'Authentication/tests/filters/openid/data/openid_wrapper.php' );
include_once( 'data/openid_db_store_helper.php' );

/**
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 */
class ezcAuthenticationOpenidDbStoreTest extends ezcAuthenticationDatabaseTieinTest
{
    protected static $tableNonces = 'openid_nonces';
    protected static $tableAssociations = 'openid_associations';

    protected static $nonce1 = '123456';
    protected static $nonce2 = '999999';
    protected static $urlServer = 'http://www.myopenid.com/server';
    protected static $url = 'http://ezc.myopenid.com/';

    public static $provider = "http://www.myopenid.com/server";

    public static $requestCheckAuthenticationGet = array(
        'openid_assoc_handle' => '{HMAC-SHA1}{4640581a}{3X/rrw==}',
        'openid_signed' => 'return_to,mode,identity',
        'openid_sig' => 'SkaCB2FA9EysKoDkybyBD46zb0E=',
        'openid_return_to' => 'http://localhost',
        'openid_identity' => 'http://ezc.myopenid.com',
        'openid_op_endpoint' => 'http://www.myopenid.com/server',
        'openid_mode' => 'check_authentication',
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
    public static $associationArray;
    
    public static $server = array(
        'HTTP_HOST' => 'localhost',
        'REQUEST_URI' => '/openid.php?action=login&openid_identifier=http%3A%2F%2Fezc.myopenid.com',
        );

    public static function suite()
    {
        self::$associationArray = array(
            'handle' => '{HMAC-SHA1}{465d66d3}{6K1aSw==}',
            'secret' => 'W0ixM9SYQviSG9TF6HrnXaxHudQ=',
            'issued' => time(),
            'validity' => 1209600,
            'type' => 'HMAC-SHA1',
            );

        self::$association = new ezcAuthenticationOpenidAssociation( '{HMAC-SHA1}{465d8eb9}{NQN84Q==}',
                                                                     'foz3UXCxQJ5lKvau78Oqen9dTUc=',
                                                                     1180536597,
                                                                     time() - 1180536597 + 604800, // valid 1 week from current time
                                                                     'HMAC-SHA1' );

        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $this->origGet = $_GET;
        $this->origServer = $_SERVER;
        $_GET = null;
        $_SERVER = self::$server;

        try
        {
            $this->db = ezcDbInstance::get();

            $schema = ezcDbSchema::createFromFile(
                                                   'array',
                                                   dirname( __FILE__ ) . '/../../../docs/tutorial/openid_db_store_schema.dba'
                                                 );
            $schema->writeToDb( $this->db );
        }

        catch ( Exception $e )
        {
            $this->markTestSkipped( "You must provide a database to runtests.php: " . $e->getMessage() );
        }

    }

    public function tearDown()
    {
        if ( $this->db !== null )
        {
            $this->cleanupTables();
        }

        $this->db = null;
        $_GET = $this->origGet;
        $_SERVER = $this->origServer;
    }

    public function cleanupTables()
    {
        $this->db->exec( 'DROP TABLE ' . $this->db->quoteIdentifier( self::$tableNonces ) );
        $this->db->exec( 'DROP TABLE ' . $this->db->quoteIdentifier( self::$tableAssociations ) );
    }

    public function testOpenidDbStoreStoreNonceNormal()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );
    }

    public function testOpenidDbStoreStoreNonceExistent()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $store->storeNonce( $nonce );
        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );
    }

    public function testOpenidDbStoreUseNonceStillValid()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );

        $ret = $store->useNonce( $nonce );
        $this->assertEquals( true, abs( time() - $ret ) < 10 ); // to allow for delays in the program
        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );
    }

    public function testOpenidDbStoreUseNonceNonexistent()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );

        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );

        ezcAuthenticationOpenidDbStoreHelper::deleteNonce( $this->db, $nonce );

        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );

        $ret = $store->useNonce( $nonce );
        $this->assertEquals( false, $ret );
        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidDbStoreHelper::getNonces( $this->db ) ) );
    }

    public function testOpenidDbStoreStoreAssociationNormal()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$associationArray );
        $url = self::$urlServer;
        $store->storeAssociation( $url, $association );

        $data = ezcAuthenticationOpenidDbStoreHelper::getAssociations( $this->db, $url );

        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );
    }

    public function testOpenidDbStoreStoreAssociationExistent()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$associationArray );
        $url = self::$urlServer;
        $store->storeAssociation( $url, $association );
        $store->storeAssociation( $url, $association );
        $data = ezcAuthenticationOpenidDbStoreHelper::getAssociations( $this->db, $url );

        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );
    }

    public function testOpenidDbStoreRemoveAssociationNormal()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$associationArray );
        $url = self::$urlServer;
        $store->storeAssociation( $url, $association );
        $data = ezcAuthenticationOpenidDbStoreHelper::getAssociations( $this->db, $url );

        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );

        $this->assertEquals( true, $store->removeAssociation( $url ) );
        $this->assertEquals( false, $store->getAssociation( $url ) );
    }

    public function testOpenidDbStoreRemoveAssociationNonexistent()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$associationArray );
        $url = self::$urlServer;

        // for DbStore, removeAssociation() returns always true, but for FileStore it could be false
        $this->assertEquals( true, $store->removeAssociation( $url ) );

        $this->assertEquals( false, $store->getAssociation( $url ) );
    }

    public function testOpenidWrapperRunModeIdResSmartModeDbStore()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResSmartModeDbStoreExistent()
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

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );
        $options->store->storeAssociation( self::$provider, $association );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResSmartModeDbStoreExistentCorrect()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $association = self::$association;
        $_GET = self::$requestSmartGet;
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $options = new ezcAuthenticationOpenidOptions();
        $options->mode = ezcAuthenticationOpenidFilter::MODE_SMART;
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );
        $options->store->storeAssociation( self::$provider, $association );
        $options->store->storeNonce( $_GET['nonce'] );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );

        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_OK, $result );
    }

    public function testOpenidWrapperRunModeIdResDbStore()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResDbStoreExistent()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResDbStoreNonceValid()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'openssl' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-openssl.' );
        }

        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $nonce = '123456';
        $_GET['openid_return_to'] = ezcAuthenticationUrl::appendQuery( $_GET['openid_return_to'], 'nonce', $nonce );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );
        $options->store->storeNonce( $nonce );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );
        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_SIGNATURE_INCORRECT, $result );
    }

    public function testOpenidWrapperRunModeIdResDbStoreNonceInvalid()
    {
        $_GET = self::$requestCheckAuthenticationGet;
        $_GET['openid_mode'] = 'id_res';
        $nonce = '123456';
        $_GET['openid_return_to'] = ezcAuthenticationUrl::appendQuery( $_GET['openid_return_to'], 'nonce', $nonce );

        $options = new ezcAuthenticationOpenidOptions();
        $options->store = new ezcAuthenticationOpenidDbStore( $this->db );

        $credentials = new ezcAuthenticationIdCredentials( self::$url );

        $filter = new ezcAuthenticationOpenidWrapper( $options );
        $result = $filter->run( $credentials );

        $this->assertEquals( ezcAuthenticationOpenidFilter::STATUS_NONCE_INCORRECT, $result );
    }

    public function testOpenidDbStoreOptions()
    {
        $options = new ezcAuthenticationOpenidDbStoreOptions();

        $this->invalidPropertyTest( $options, 'tableNonces', 'wrong value', 'array' );
        $this->invalidPropertyTest( $options, 'tableAssociations', 'wrong value', 'array' );
        $this->missingPropertyTest( $options, 'no_such_property' );
    }

    public function testOpenidDbStoreOptionsGetSet()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $options = new ezcAuthenticationOpenidDbStoreOptions();
        $store->setOptions( $options );
        $this->assertEquals( $options, $store->getOptions() );
    }

    public function testOpenidDbStoreProperties()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $this->invalidPropertyTest( $store, 'instance', 'wrong value', 'ezcDbHandler' );
        $this->missingPropertyTest( $store, 'no_such_property' );
    }

    public function testOpenidDbStorePropertiesIsSet()
    {
        $store = new ezcAuthenticationOpenidDbStore( $this->db );

        $this->issetPropertyTest( $store, 'instance', true );
        $this->issetPropertyTest( $store, 'no_such_property', false );
    }
}
?>
