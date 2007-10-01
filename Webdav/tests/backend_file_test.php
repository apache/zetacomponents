<?php
/**
 * Basic test cases for the file backend.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Tests for ezcWebdavFileBackend class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavFileBackendTest extends ezcWebdavTestCase
{
    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavFileBackendTest' );
	}

    protected function recursiveTouch( $source, $time )
    {
        $dh = opendir( $source );
        while( $file = readdir( $dh ) )
        {
            if ( ( $file === '.' ) ||
                ( $file === '..' ) )
            {
                continue;
            }

            if ( is_dir( $path = $source . '/' . $file ) )
            {
                $this->recursiveTouch( $path, $time );
            }
            else
            {
                touch( $path, $time, $time );
            }
        }
    }

    protected function compareResponse( $test, ezcWebdavResponse $response )
    {
        $dataDir = dirname( __FILE__ ) . '/data/responses/file';

        if ( !is_file( $file = $dataDir . '/' . $test . '.ser' ) )
        {
            file_put_contents( $file, serialize( $response ) );
            return $this->markTestSkipped( 'Reponse serialized. Please check generated response.' );
        }

        $this->assertEquals(
            $response,
            unserialize( file_get_contents( $file ) ),
            'Response does not equal serialzed response.',
            20
        );
    }

    public function setUp()
    {
        static $i = 0;

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d', ++$i ) ) . '/';
        
        ezcBaseFile::copyRecursive( 
            dirname( __FILE__ ) . '/data/backend_file', 
            $this->tempDir . 'backend/'
        );
        $this->recursiveTouch(
            $this->tempDir . 'backend/',
            12345678
        );
    }

    public function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testFileBackendOptionsInFileBackend()
    {
        $server = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertEquals(
            $server->options,
            new ezcWebdavFileBackendOptions(),
            'Expected initially unmodified backend options class.'
        );

        $this->assertSame(
            $server->options->noLock,
            false,
            'Expected successfull access on option.'
        );

        try
        {
            // Read access
            $server->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testFileBackendOptionsSetInFileBackend()
    {
        $server = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $options = new ezcWebdavFileBackendOptions();
        $options->noLock = true;

        $this->assertSame(
            $server->options->noLock,
            false,
            'Wrong initial value before changed option class.'
        );

        $server->options = $options;

        $this->assertSame(
            $server->options->noLock,
            true,
            'Expected modified value, because of changed option class.'
        );

        try
        {
            $server->unknownProperty = $options;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testResourceHead()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavHeadRequest( '/resource' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavHeadResponse(
                new ezcWebdavResource(
                    '/resource', 
                    $backend->getAllProperties( '/resource' )
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCollectionHead()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavHeadRequest( '/collection' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavHeadResponse(
                new ezcWebdavCollection(
                    '/collection',
                    $backend->getAllProperties( '/collection' )
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceHeadError()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavHeadRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceGet()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavGetRequest( '/resource' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/resource', 
                    $backend->getAllProperties( '/resource' ),
                    "Some webdav contents.\n"
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceGetError()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavGetRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCollectionGet()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavGetRequest( '/collection' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetCollectionResponse(
                new ezcWebdavCollection(
                    '/collection',
                    $backend->getAllProperties( '/collection' ),
                    array(
                        new ezcWebdavCollection(
                            '/collection/.svn'
                        ),
                        new ezcWebdavResource(
                            '/collection/test.txt'
                        ),
                    )
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceDeepGet()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavGetRequest( '/collection/.svn/text-base/test.txt.svn-base' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/collection/.svn/text-base/test.txt.svn-base', 
                    $backend->getAllProperties( '/collection/.svn/text-base/test.txt.svn-base' ),
                    "Some other contents...\n"
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopy()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/new_resource' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyError()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/unknown', '/irrelevant' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyF()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/collection/resource' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyOverwrite()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/collection/test.txt' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavCopyResponse(
                true
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyOverwriteFailed()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/collection/test.txt' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection/test.txt'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDestinationNotExisting()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/dum/di' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopySourceEqualsDest()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/resource', '/resource' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDepthZero()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/collection', '/new_collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/new_collection' ),
            'Expected created collection.'
        );
    }

    public function testResourceCopyDepthInfinity()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/collection', '/new_collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/new_collection' ),
            'Expected created collection.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/test.txt' ),
            'Expected created file in collection.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/.svn/text-base/test.txt.svn-base' ),
            'Expected created deep file in collection.'
        );
    }

    public function testResourceCopyDepthInfinityErrors()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        // Cause error by making file not readable
        chmod ( $this->tempDir . 'backend/collection/test.txt', 0 );

        $request = new ezcWebdavCopyRequest( '/collection', '/new_collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/collection/test.txt'
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/new_collection' ),
            'Expected created collection.'
        );

        $this->assertFalse(
            is_file( $this->tempDir . 'backend/new_collection/test.txt' ),
            'Expected file in collection not to be created.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/.svn/text-base/test.txt.svn-base' ),
            'Expected created deep file in collection.'
        );

        chmod ( $this->tempDir . 'backend/collection/test.txt', 0777 );
    }

    public function testResourceMove()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/dest' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveError()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/unknown', '/irrelevant' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveF()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/dest' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveOverwrite()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/collection/test.txt' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMoveResponse(
                true
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveOverwriteFailed()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/collection/test.txt' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection/test.txt'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDestinationNotExisting()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/dum/di' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveSourceEqualsDest()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/resource', '/resource' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDepthInfinity()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected existing collection before request.'
        );

        $request = new ezcWebdavMoveRequest( '/collection', '/new_collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertFalse(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected removed collection.'
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/new_collection' ),
            'Expected created collection.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/test.txt' ),
            'Expected created file in collection.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/.svn/text-base/test.txt.svn-base' ),
            'Expected created deep file in collection.'
        );
    }

    public function testResourceMoveDepthInfinityErrors()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        // Cause error by making file not readable
        chmod ( $this->tempDir . 'backend/collection/test.txt', 0 );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected existing collection before request.'
        );

        $request = new ezcWebdavMoveRequest( '/collection', '/new_collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/collection/test.txt'
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected collection not to be removed.'
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/new_collection' ),
            'Expected created collection.'
        );

        $this->assertFalse(
            is_file( $this->tempDir . 'backend/new_collection/test.txt' ),
            'Expected file in collection not to be created.'
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/new_collection/.svn/text-base/test.txt.svn-base' ),
            'Expected created deep file in collection.'
        );

        chmod ( $this->tempDir . 'backend/collection/test.txt', 0777 );
    }

    public function testResourceDelete()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/resource' ),
            'Expected existing file.'
        );

        $request = new ezcWebdavDeleteRequest( '/resource' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavDeleteResponse(
                '/resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertFalse(
            is_file( $this->tempDir . 'backend/resource' ),
            'Expected file to be removed.'
        );
    }

    public function testCollectionDelete()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected existing directory.'
        );

        $request = new ezcWebdavDeleteRequest( '/collection' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavDeleteResponse(
                '/collection'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertFalse(
            is_dir( $this->tempDir . 'backend/collection' ),
            'Expected directory to be removed.'
        );
    }

    public function testResourceDeleteError404()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavDeleteRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceDeleteCausedError()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/collection/test.txt' ),
            'Expected existing file.'
        );

        chmod ( $this->tempDir . 'backend/collection/test.txt', 0 );

        $request = new ezcWebdavDeleteRequest( '/collection/test.txt' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
                '/collection/test.txt'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/resource' ),
            'Expected still existing file.'
        );

        chmod ( $this->tempDir . 'backend/collection/test.txt', 0777 );
    }

    public function testMakeCollectionOnExistingCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/collection' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/collection'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionOnExistingRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/resource' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionMissingParent()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/dum/di' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionInRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/resource/collection' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/resource/collection'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionWithRequestBody()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/collection/new_collection', 'with request body' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_415,
                '/collection/new_collection'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertFalse(
            is_dir( $this->tempDir . 'backend/collection/new_collection' ),
            'Expected collection not existing yet.'
        );

        $request = new ezcWebdavMakeCollectionRequest( '/collection/new_collection' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMakeCollectionResponse(
                '/bar/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection/new_collection' ),
            'Expected created collection.'
        );
    }

    public function testPutOnExistingCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/collection', 'some content' );
        $request->setHeader( 'Content-Length', 23 );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/collection'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPutMissingParent()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/dum/di', 'some content' );
        $request->setHeader( 'Content-Length', 23 );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPutInRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/resource/new_resource', 'some content' );
        $request->setHeader( 'Content-Length', 23 );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/resource/new_resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPut()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertFalse(
            is_file( $this->tempDir . 'backend/collection/new_resource' ),
            'Expected resource not existing yet.'
        );

        $request = new ezcWebdavPutRequest( '/collection/new_resource', 'some content' );
        $request->setHeader( 'Content-Length', 23 );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavPutResponse(
                '/collection/new_resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/collection/new_resource' ),
            'Expected created resource.'
        );

        $this->assertEquals(
            'some content',
            file_get_contents( $this->tempDir . 'backend/collection/new_resource' )
        );
    }

    public function testPutOnExistingRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/resource' ),
            'Expected created resource.'
        );

        $this->assertEquals(
            "Some webdav contents.\n",
            file_get_contents( $this->tempDir . 'backend/resource' )
        );

        $request = new ezcWebdavPutRequest( '/resource', 'some content' );
        $request->setHeader( 'Content-Length', 23 );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavPutResponse(
                '/resource'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/resource' ),
            'Expected created resource.'
        );

        $this->assertEquals(
            'some content',
            file_get_contents( $this->tempDir . 'backend/resource' )
        );
    }

    public function testPropFindOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetContentLengthProperty()
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetLastModifiedProperty()
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindOnCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetContentLengthProperty( '22' )
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@12345678' ) )
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/collection' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ONE );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindNamesOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->propName = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindNamesOnCollectionDepthZero()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/collection' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindNamesOnCollectionDepthOne()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/collection' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ONE );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindNamesOnCollectionDepthInfinite()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/collection' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindAllPropsOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropFindAllPropsOnCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/collection' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__, $response );
    }

    public function testPropPatchAddProperty()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p1 = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p2 = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $addedProperties = new ezcWebdavBasicPropertyStorage();
        $addedProperties->attach( $p1 );
        $addedProperties->attach( $p2 );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $addedProperties->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $addedProperties
                )
            )
        );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPropPatchAddPropertyFail()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        // Add properties, but cause errors
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blah = new ezcWebdavDeadProperty( 
            'foo:', 'blah', 'evn more content'
        ), ezcWebdavPropPatchRequest::SET );

        $addedProperties = new ezcWebdavBasicPropertyStorage();
        $addedProperties->attach( $p_bar );
        $addedProperties->attach( $p_blubb );
        $addedProperties->attach( $p_blah );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->compareResponse( __FUNCTION__ . '_1', $response );

        // Verfify that none of the properties has been added.
        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__ . '_2', $response );
    }

    public function testPropPatchRemoveProperty()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        // First add some custom properties.
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        // Then remove one of them using proppatch
        $removeProperties = new ezcWebdavFlaggedPropertyStorage();
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );

        $removedProperties = new ezcWebdavBasicPropertyStorage();
        $removedProperties->attach( $p_blubb );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $removeProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        // Ensure property has been deleted by requesting both, expecting a 404
        // for the removed property.
        $leftProperties = new ezcWebdavBasicPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $leftProperties->rewind();
        $removedProperties->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $leftProperties
                ),
                new ezcWebdavPropStatResponse(
                    $removedProperties,
                    ezcWebdavResponse::STATUS_404
                )
            )
        );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPropPatchFailOnRemoveProperty()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        // First add some custom properties.
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $removeProperties = new ezcWebdavFlaggedPropertyStorage();
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $removeProperties->attach(  
            $p_length = new ezcWebdavGetContentLengthProperty(),
            ezcWebdavPropPatchRequest::REMOVE
        );
        $removeProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );
        $removeProperties->attach(  
            $p_last = new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@12345678' ) ),
            ezcWebdavPropPatchRequest::REMOVE
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $removeProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->compareResponse( __FUNCTION__ . '_1', $response );

        // Ensure nothing has been removed, and the transactions has been
        // properly reverted.
        $leftProperties = new ezcWebdavBasicPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $removeProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $this->compareResponse( __FUNCTION__ . '_2', $response );
    }

    public function testPropPatchCombinedSetDelete()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        // First add some custom properties.
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $updateProperties = new ezcWebdavFlaggedPropertyStorage();
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $updateProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected property removing PROPPATCH response does not match real response.',
            0,
            20
        );

        // Ensure nothing has been removed, and the transactions has been
        // properly reverted.
        $leftProperties = new ezcWebdavBasicPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $updateProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $failed = new ezcWebdavBasicPropertyStorage();
        $failed->attach( $p_blubb );
        $failed->attach( $p_bar );
        $failed->rewind();

        $success = new ezcWebdavBasicPropertyStorage();
        $success->attach( $p_foo );
        $success->rewind();

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $success
                ),
                new ezcWebdavPropStatResponse(
                    $failed,
                    ezcWebdavResponse::STATUS_404
                )
            )
        );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected validating PROPFIND response does not match real response.',
            0,
            20
        );
    }

    public function testPropPatchCombinedSetDeleteFail()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        // First add some custom properties.
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $updateProperties = new ezcWebdavFlaggedPropertyStorage();
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $updateProperties->attach( 
            $p_length = new ezcWebdavGetContentLengthProperty(), 
            ezcWebdavPropPatchRequest::REMOVE
        );
        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $updateProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $failed = new ezcWebdavBasicPropertyStorage();
        $failed->attach( $p_length );

        $depError = new ezcWebdavBasicPropertyStorage();
        $depError->attach( $p_foo );
        $depError->attach( $p_bar );

        $failed->rewind();
        $depError->rewind();
        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $failed,
                    ezcWebdavResponse::STATUS_403
                ),
                new ezcWebdavPropStatResponse(
                    new ezcWebdavBasicPropertyStorage(),
                    ezcWebdavResponse::STATUS_409
                ),
                new ezcWebdavPropStatResponse(
                    $depError,
                    ezcWebdavResponse::STATUS_424
                )
            ),
            $response,
            'Expected property removing PROPPATCH response does not match real response.',
            0,
            20
        );
    }
}

?>
