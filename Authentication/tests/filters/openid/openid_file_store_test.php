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

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationOpenidFileStoreTest extends ezcAuthenticationTest
{
    protected static $nonce1 = '123456';
    protected static $nonce2 = '999999';
    protected static $url = 'http://www.myopenid.com/server';
    protected static $association;

    public static function suite()
    {
        self::$association = array(
            'handle' => '{HMAC-SHA1}{465d66d3}{6K1aSw==}',
            'secret' => 'W0ixM9SYQviSG9TF6HrnXaxHudQ=',
            'issued' => time(),
            'validity' => 1209600,
            'type' => 'HMAC-SHA1',
            );
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationOpenidFileStoreTest" );
    }

    public function setUp()
    {
        $this->path = $this->createTempDir( get_class( $this ) );
    }

    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testOpenidFileStoreStoreNonceNormal()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
    }

    public function testOpenidFileStoreStoreNonceExistent()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $store->storeNonce( $nonce );
        $this->assertEquals( true, in_array( $nonce, ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
    }

    public function testOpenidFileStoreStoreNonceUnwritable()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $nonce = self::$nonce1;
        chmod( $path, 0444 );

        try
        {
            $store->storeNonce( $nonce );
            chmod( $path, 0777 );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}" . DIRECTORY_SEPARATOR . "{$nonce}' can not be opened for writing.", $e->getMessage() );
        }

        chmod( $path, 0777 );
        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
    }

    public function testOpenidFileStoreUseNonceStillValid()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );
        $ret = $store->useNonce( $nonce );
        $this->assertEquals( true, abs( time() - $ret ) < 10 ); // to allow for delays in the program
        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
    }

    public function testOpenidFileStoreUseNonceNonexistent()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $nonce = self::$nonce1;
        $store->storeNonce( $nonce );

        unlink( $path . DIRECTORY_SEPARATOR . $nonce );

        $ret = $store->useNonce( $nonce );
        $this->assertEquals( false, $ret );
        $this->assertEquals( false, in_array( $nonce, ezcAuthenticationOpenidFileStoreHelper::getFiles( $path ) ) );
    }

    public function testOpenidFileStoreStoreAssociationNormal()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$association );
        $url = self::$url;
        $store->storeAssociation( $url, $association );
        $files = ezcAuthenticationOpenidFileStoreHelper::getFiles( $path );
        foreach ( $files as $file )
        {
            if ( $file !== '.' && $file !== '..' )
            {
                break;
            }
        }
        $data = file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );
    }

    public function testOpenidFileStoreStoreAssociationExistent()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$association );
        $url = self::$url;
        $store->storeAssociation( $url, $association );
        $store->storeAssociation( $url, $association );
        $files = ezcAuthenticationOpenidFileStoreHelper::getFiles( $path );
        foreach ( $files as $file )
        {
            if ( $file !== '.' && $file !== '..' )
            {
                break;
            }
        }
        $data = file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );
    }

    public function testOpenidFileStoreHelperStoreAssociationUnwritable()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStoreHelper( $path );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$association );
        $url = self::$url;

        chmod( $path, 0444 );

        try
        {
            $store->storeAssociation( $url, $association );
            chmod( $path, 0777 );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}" . DIRECTORY_SEPARATOR . $store->convertToFilename( $url ) . "' can not be opened for writing.", $e->getMessage() );
        }

        chmod( $path, 0777 );
        $this->assertEquals( false, $store->getAssociation( $url ) );
    }

    public function testOpenidFileStoreRemoveAssociationNormal()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$association );
        $url = self::$url;
        $store->storeAssociation( $url, $association );
        $files = ezcAuthenticationOpenidFileStoreHelper::getFiles( $path );
        foreach ( $files as $file )
        {
            if ( $file !== '.' && $file !== '..' )
            {
                break;
            }
        }
        $data = file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
        $this->assertEquals( unserialize( $data ), $store->getAssociation( $url ) );
        $this->assertEquals( true, $store->removeAssociation( $url ) );
        $this->assertEquals( false, $store->getAssociation( $url ) );
    }

    public function testOpenidFileStoreRemoveAssociationNonexistent()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $association = ezcAuthenticationOpenidAssociation::__set_state( self::$association );
        $url = self::$url;
        $this->assertEquals( false, $store->removeAssociation( $url ) );
        $this->assertEquals( false, $store->getAssociation( $url ) );
    }

    public function testOpenidFileStoreOptions()
    {
        $options = new ezcAuthenticationOpenidFileStoreOptions();

        $this->missingPropertyTest( $options, 'no_such_property' );
    }

    public function testOpenidFileStoreOptionsGetSet()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $options = new ezcAuthenticationOpenidFileStoreOptions();
        $store->setOptions( $options );
        $this->assertEquals( $options, $store->getOptions() );
    }

    public function testOpenidFileStoreProperties()
    {
        $path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data';
        $store = new ezcAuthenticationOpenidFileStore( $path );

        // the DirTest functions already create temporary directories, so the
        // next line removes the directory created in setUp() so there are no
        // leftovers at the end of the tests
        $this->removeTempDir();

        $this->invalidPropertyTest( $store, 'path', 0, 'string' );
        $this->missingDirTest( $store, 'path', 'missing' );
        $this->unreadableDirTest( $store, 'path', 'unreadable' );
        $this->unwritableDirTest( $store, 'path', 'unwritable' );
        $this->missingPropertyTest( $store, 'no_such_property' );
    }

    public function testOpenidFileStorePropertiesIsSet()
    {
        $path = $this->path;
        $store = new ezcAuthenticationOpenidFileStore( $path );

        $this->issetPropertyTest( $store, 'path', true );
        $this->issetPropertyTest( $store, 'no_such_property', false );
    }
}
?>
