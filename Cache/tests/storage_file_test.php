<?php
/**
 * ezcCacheStorageTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**;
 * Test suite for ezcStorageFile class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileTest extends ezcTestCase
{
    public function testGenerateIdentifier1()
    {
        $obj = new ezcCacheStorageFileArray( '/tmp' );
        $id = $obj->generateIdentifier( 'contentstructuremenu/show_content_structure-2 file:foobar' );
        $this->assertEquals( 'contentstructuremenu'.DIRECTORY_SEPARATOR.'show_content_structure-2_file:foobar-.cache', $id );
    }

    public function testGenerateIdentifier2()
    {
        $obj = new ezcCacheStorageFileArray( '/tmp' );
        $id = $obj->generateIdentifier( 'contentstructuremenu\show_content_structure-2 file:foobar' );
        $this->assertEquals( 'contentstructuremenu'.DIRECTORY_SEPARATOR.'show_content_structure-2_file:foobar-.cache', $id );
    }

    public function testGenerateIdentifier3()
    {
        $obj = new ezcCacheStorageFileArray( '/tmp', array( 'extension' => '.c' ) );
        $id = $obj->generateIdentifier( 'contentstructuremenu\show_content_structure-2 file:foobar' );
        $this->assertEquals( 'contentstructuremenu'.DIRECTORY_SEPARATOR.'show_content_structure-2_file:foobar-.c', $id );
    }

    public function testGenerateIdentifier4()
    {
        $obj = new ezcCacheStorageFileArray( '/tmp', array( 'extension' => '.c' ) );
        $id = $obj->generateIdentifier( 1 );
        $this->assertEquals( '1-.c', $id );
    }

    public function testGenerateIdentifier5()
    {
        $obj = new ezcCacheStorageFileArray( '/tmp', array( 'extension' => '.c' ) );
        $id = $obj->generateIdentifier( 1, array( "foo" => "bar", "baz" => "bam" ) );
        $this->assertEquals( '1-baz=bam-foo=bar.c', $id );
    }

    public function testInvalidConfigurationOption()
    {
        try
        {
            $obj = new ezcCacheStorageFileArray( '/tmp', array( 'eXtEnSiOn' => '.c' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingNotFoundException $e )
        {
            $this->assertTrue( true );
        }
    }

    public function testCountDataItems()
    {
        $cache = new ezcCacheStorageFileArray( $this->createTempDir( 'ezcCacheStorageFileTest' ), array( 'extension' => '.c' ) );
        $data = array( 
            array( 
                'attributes' => array( 'lang' => 'en', 'section' => 'articles' ),
                'content'    => array( 'lang' => 'en', 'section' => 'articles' ),
            ),
            array( 
                'attributes' => array( 'lang' => 'de', 'section' => 'articles' ),
                'content'    => array( 'lang' => 'de', 'section' => 'articles' ),
            ),
            array( 
                'attributes' => array( 'lang' => 'no', 'section' => 'articles' ),
                'content'    => array( 'lang' => 'no', 'section' => 'articles' ),
            )
        );
        foreach ( $data as $id => $dataArr )
        {
            $cache->store( $id, $dataArr['content'], $dataArr['attributes'] );
        }

        $this->assertEquals( $cache->countDataItems( 0 ), 1, 'Count data items failed with ID.' );
        $this->assertEquals( $cache->countDataItems( null, array( 'lang' => 'no' ) ), 1, 'Count data items failed with attribute <lang>.' );
        $this->assertEquals( $cache->countDataItems( null, array( 'section' => 'articles' ) ), 3, 'Count data items failed with attribute <articles>.' );
        $this->removeTempDir();
    }

    public function testFalseLifetime()
    {
        $cache = new ezcCacheStorageFileArray(
            $this->createTempDir( 'ezcCacheStorageFileTest' ), 
            array( 'extension' => '.c', 'ttl' => false )
        );
        $data = array( 
            'attributes' => array( 'lang' => 'en', 'section' => 'articles' ),
            'content'    => array( 'lang' => 'en', 'section' => 'articles' ),
        );

        $cache->store( 0, $data['attributes'], $data['content'] );

        sleep( 2 );
        
        $this->assertNotEquals( false, $cache->restore( 0 ) );
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcCacheStorageFileTest" );
    }
}
?>
