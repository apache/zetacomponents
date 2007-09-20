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

    public function setUp()
    {
        static $i = 0;

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d', ++$i ) ) . '/';
        
        ezcBaseFile::copyRecursive( 
            dirname( __FILE__ ) . '/data/backend_file', 
            $this->tempDir . 'backend/'
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

        $request = new ezcWebdavHeadRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavHeadResponse(
                new ezcWebdavResource(
                    '/foo', new ezcWebdavPropertyStorage()
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

        $request = new ezcWebdavHeadRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavHeadResponse(
                new ezcWebdavCollection(
                    '/bar', new ezcWebdavPropertyStorage()
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

        $request = new ezcWebdavGetRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/foo', new ezcWebdavPropertyStorage(), 'bar'
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

    public function testResourceGetWithProperties()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        // Expected properties
        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new DateTime( '@1054034820' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty( 'foo' )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty( 'application/octet-stream' )
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty( md5( '/foo' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty( new DateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );

        $request = new ezcWebdavGetRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/foo', 
                    $propertyStorage,
                    'bar'
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCollectionGet()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavGetRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetCollectionResponse(
                new ezcWebdavCollection(
                    '/bar', new ezcWebdavPropertyStorage(), array(
                        new ezcWebdavResource(
                            '/bar/blubb'
                        ),
                        new ezcWebdavCollection(
                            '/bar/blah'
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

        $request = new ezcWebdavGetRequest( '/bar/blah/fumdiidudel.txt' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/bar/blah/fumdiidudel.txt', 
                    new ezcWebdavPropertyStorage(), 
                    'Willst du an \'was Rundes denken, denk\' an einen Plastikball. Willst du \'was gesundes schenken, schenke einen Plastikball. Plastikball, Plastikball, ...'
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

        $request = new ezcWebdavCopyRequest( '/foo', '/dest' );
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

        $request = new ezcWebdavCopyRequest( '/foo', '/dest' );
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

        $request = new ezcWebdavCopyRequest( '/foo', '/bar' );
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

        $request = new ezcWebdavCopyRequest( '/foo', '/bar' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDestinationNotExisting()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/foo', '/dum/di' );
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

        $request = new ezcWebdavCopyRequest( '/foo', '/foo' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDepthZero()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
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

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/bar',
                    '/foo',
                ),
                '/bar' => array(
                    '/bar/_1',
                    '/bar/_2',
                ),
                '/bar/_1' => 'contents',
                '/bar/_2' => 'contents',
                '/foo' => array(),
            )
        );
    }

    public function testResourceCopyDepthInfinity()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
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

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/bar',
                    '/foo',
                ),
                '/bar' => array(
                    '/bar/_1',
                    '/bar/_2',
                ),
                '/bar/_1' => 'contents',
                '/bar/_2' => 'contents',
                '/foo' => array(
                    '/foo/_1',
                    '/foo/_2',
                ),
                '/foo/_1' => 'contents',
                '/foo/_2' => 'contents',
            )
        );
    }

    public function testResourceCopyDepthInfinityErrors()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/bar/_2'
                ),
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/bar/_4'
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/bar',
                    '/foo',
                ),
                '/bar' => array(
                    '/bar/_1',
                    '/bar/_2',
                    '/bar/_3',
                    '/bar/_4',
                    '/bar/_5',
                ),
                '/bar/_1' => 'contents',
                '/bar/_2' => 'contents',
                '/bar/_3' => 'contents',
                '/bar/_4' => 'contents',
                '/bar/_5' => 'contents',
                '/foo' => array(
                    '/foo/_1',
                    '/foo/_3',
                    '/foo/_5',
                ),
                '/foo/_1' => 'contents',
                '/foo/_3' => 'contents',
                '/foo/_5' => 'contents',
            )
        );
    }

    public function testResourceMove()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/foo', '/dest' );
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

        $request = new ezcWebdavMoveRequest( '/foo', '/dest' );
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

        $request = new ezcWebdavMoveRequest( '/foo', '/bar' );
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

        $request = new ezcWebdavMoveRequest( '/foo', '/bar' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDestinationNotExisting()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/foo', '/dum/di' );
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

        $request = new ezcWebdavMoveRequest( '/foo', '/foo' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDepthInfinity()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/bar', '/foo' );
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

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                ),
                '/foo' => array(
                    '/foo/_1',
                    '/foo/_2',
                ),
                '/foo/_1' => 'contents',
                '/foo/_2' => 'contents',
            )
        );
    }

    public function testResourceMoveDepthInfinityErrors()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMoveRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/bar/_2'
                ),
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    '/bar/_4'
                )
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/bar',
                    '/foo',
                ),
                '/bar' => array(
                    '/bar/_1',
                    '/bar/_2',
                    '/bar/_3',
                    '/bar/_4',
                    '/bar/_5',
                ),
                '/bar/_1' => 'contents',
                '/bar/_2' => 'contents',
                '/bar/_3' => 'contents',
                '/bar/_4' => 'contents',
                '/bar/_5' => 'contents',
                '/foo' => array(
                    '/foo/_1',
                    '/foo/_3',
                    '/foo/_5',
                ),
                '/foo/_1' => 'contents',
                '/foo/_3' => 'contents',
                '/foo/_5' => 'contents',
            )
        );
    }

    public function testResourceDelete()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavDeleteRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavDeleteResponse(
                '/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/bar',
                ),
                '/bar' => array(
                    '/bar/blubb',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
            )
        );
    }

    public function testCollectionDelete()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavDeleteRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavDeleteResponse(
                '/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                ),
                '/foo' => 'bar',
            )
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

        $request = new ezcWebdavDeleteRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
                '/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                    '/bar',
                ),
                '/foo' => 'bar',
                '/bar' => array(
                    '/bar/blubb',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
            )
        );
    }

    public function testMakeCollectionOnExistingCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionOnExistingRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/foo'
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

        $request = new ezcWebdavMakeCollectionRequest( '/foo/bar' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionWithRequestBody()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/bar/foo', 'with request body' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_415,
                '/bar/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavMakeCollectionRequest( '/bar/foo' );
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

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                    '/bar',
                ),
                '/foo' => 'bar',
                '/bar' => array(
                    '/bar/blubb',
                    '/bar/foo',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
                '/bar/foo' => array(),
            )
        );
    }

    public function testPutOnExistingCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/bar', 'some content' );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/bar'
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

        $request = new ezcWebdavPutRequest( '/foo/bar', 'some content' );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/foo/bar'
            ),
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPut()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/bar/foo', 'some content' );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavPutResponse(
                '/bar/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                    '/bar',
                ),
                '/foo' => 'bar',
                '/bar' => array(
                    '/bar/blubb',
                    '/bar/foo',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
                '/bar/foo' => 'some content',
            )
        );
    }

    public function testPutOnExistingRessource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPutRequest( '/foo', 'some content' );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavPutResponse(
                '/foo'
            ),
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                    '/bar',
                ),
                '/foo' => 'some content',
                '/bar' => array(
                    '/bar/blubb',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
            )
        );
    }

    public function testPropFindOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $requestedProperties = new ezcWebdavPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetContentLengthProperty()
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetLastModifiedProperty()
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $prop200 = new ezcWebdavPropertyStorage();
        $prop200->attach( $prop1 );
        $prop200->attach( $prop2 );
        $prop200->rewind();

        $prop404 = new ezcWebdavPropertyStorage();
        $prop404->attach( $prop3 );
        $prop404->rewind();

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $prop200
                    ),
                    new ezcWebdavPropStatResponse(
                        $prop404,
                        ezcWebdavResponse::STATUS_404
                    ),
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

    public function testPropFindOnCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $requestedProperties = new ezcWebdavPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetContentLengthProperty()
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetLastModifiedProperty()
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $prop200c = new ezcWebdavPropertyStorage();
        $prop200c->attach( $prop1 );
        $prop200c->attach( $prop2 );

        $prop404c = new ezcWebdavPropertyStorage();
        $prop404c->attach( $prop3 );

        $prop200r = new ezcWebdavPropertyStorage();
        $prop200r->attach( $prop1 );
        $prop200r->attach( $prop2 );

        $prop404r = new ezcWebdavPropertyStorage();
        $prop404r->attach( $prop3 );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $prop200c
                    ),
                    new ezcWebdavPropStatResponse(
                        $prop404c,
                        ezcWebdavResponse::STATUS_404
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blubb' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $prop200r
                    ),
                    new ezcWebdavPropStatResponse(
                        $prop404r,
                        ezcWebdavResponse::STATUS_404
                    ),
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

    public function testPropFindNamesOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->propName = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty()
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindNamesOnCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty()
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blubb' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindNamesOnCollectionDepthZero()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty()
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindNamesOnCollectionDepthOne()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ONE );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty()
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar/blah' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blubb' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindNamesOnCollectionDepthInfinite()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty()
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar/blah' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blubb' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar/blah/dum' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blah/dum/di' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindAllPropsOnResource()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new DateTime( '@1054034820' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavDisplayNameProperty( 'foo' )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentTypeProperty( 'application/octet-stream' )
        );
        $propertyStorage->attach(
            new ezcWebdavGetEtagProperty( md5( '/foo' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetLastModifiedProperty( new DateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorage
                    ),
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

    public function testPropFindAllPropsOnCollection()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorageC = new ezcWebdavPropertyStorage();
        $propertyStorageC->attach(
            new ezcWebdavCreationDateProperty( new DateTime( '@1054034820' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavDisplayNameProperty( 'bar' )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentTypeProperty( 'application/octet-stream' )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetEtagProperty( md5( '/bar' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetLastModifiedProperty( new DateTime( '@1124118780' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentLengthProperty( ezcWebdavGetContentLengthProperty::COLLECTION )
        );

        $propertyStorageR = new ezcWebdavPropertyStorage();
        $propertyStorageR->attach(
            new ezcWebdavCreationDateProperty( new DateTime( '@1054034820' ) )
        );
        $propertyStorageR->attach(
            new ezcWebdavDisplayNameProperty( 'blubb' )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetContentTypeProperty( 'application/octet-stream' )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetEtagProperty( md5( '/bar/blubb' ) )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetLastModifiedProperty( new DateTime( '@1124118780' ) )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetContentLengthProperty( '19' )
        );

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavCollection( '/bar' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorageC
                    ),
                )
            ),
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/bar/blubb' ),
                array(
                    new ezcWebdavPropStatResponse(
                        $propertyStorageR
                    ),
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

        $addedProperties = new ezcWebdavPropertyStorage();
        $addedProperties->attach( $p1 );
        $addedProperties->attach( $p2 );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $addedProperties->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
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

        $addedProperties = new ezcWebdavPropertyStorage();
        $addedProperties->attach( $p_bar );
        $addedProperties->attach( $p_blubb );
        $addedProperties->attach( $p_blah );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        // We expect the first to fail "normally".
        $failed = new ezcWebdavPropertyStorage();
        $failed->attach( $p_bar );
        $failed->rewind();

        // All other will cause dep errors.
        $depError = new ezcWebdavPropertyStorage();
        $depError->attach( $p_blubb );
        $depError->attach( $p_blah );
        $depError->rewind();

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' ),
                new ezcWebdavPropStatResponse(
                    $failed,
                    ezcWebdavResponse::STATUS_403
                ),
                new ezcWebdavPropStatResponse(
                    $depError,
                    ezcWebdavResponse::STATUS_424
                )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        // Verfify that none of the properties has been added.
        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $addedProperties->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
                new ezcWebdavPropStatResponse(
                    $addedProperties,
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        // Then remove one of them using proppatch
        $removeProperties = new ezcWebdavFlaggedPropertyStorage();
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::DELETE );

        $removedProperties = new ezcWebdavPropertyStorage();
        $removedProperties->attach( $p_blubb );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $removeProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        // Ensure property has been deleted by requesting both, expecting a 404
        // for the removed property.
        $leftProperties = new ezcWebdavPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $leftProperties->rewind();
        $removedProperties->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $removeProperties = new ezcWebdavFlaggedPropertyStorage();
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::DELETE );
        $removeProperties->attach(  
            $p_length = new ezcWebdavGetContentLengthProperty(),
            ezcWebdavPropPatchRequest::DELETE
        );
        $removeProperties->attach( $p_bar, ezcWebdavPropPatchRequest::DELETE );
        $removeProperties->attach(  
            $p_last = new ezcWebdavGetLastModifiedProperty(),
            ezcWebdavPropPatchRequest::DELETE
        );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $removeProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $failed = new ezcWebdavPropertyStorage();
        $failed->attach( $p_length );

        $depError = new ezcWebdavPropertyStorage();
        $depError->attach( $p_bar );
        $depError->attach( $p_last );

        $failed->rewind();
        $depError->rewind();
        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' ),
                new ezcWebdavPropStatResponse(
                    $failed,
                    ezcWebdavResponse::STATUS_403
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

        // Ensure nothing has been removed, and the transactions has been
        // properly reverted.
        $leftProperties = new ezcWebdavPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $removeProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $checkProperties = new ezcWebdavPropertyStorage();
        $checkProperties->attach( $p_blubb );
        $checkProperties->attach( $p_bar );
        $checkProperties->attach(  
            $p_length = new ezcWebdavGetContentLengthProperty()
        );
        $checkProperties->attach(  
            $p_last = new ezcWebdavGetLastModifiedProperty()
        );
        $checkProperties->rewind();

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
                new ezcWebdavPropStatResponse(
                    $checkProperties
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $updateProperties = new ezcWebdavFlaggedPropertyStorage();
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::DELETE );
        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::DELETE );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $updateProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected property removing PROPPATCH response does not match real response.',
            0,
            20
        );

        // Ensure nothing has been removed, and the transactions has been
        // properly reverted.
        $leftProperties = new ezcWebdavPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $updateProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $failed = new ezcWebdavPropertyStorage();
        $failed->attach( $p_blubb );
        $failed->attach( $p_bar );
        $failed->rewind();

        $success = new ezcWebdavPropertyStorage();
        $success->attach( $p_foo );
        $success->rewind();

        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/foo' ),
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' )
            ),
            $response,
            'Expected property adding PROPPATCH response does not match real response.',
            0,
            20
        );

        // Then remove them again, with one live property in the middle to
        // check for proper failed dependency response codes.
        $updateProperties = new ezcWebdavFlaggedPropertyStorage();
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::DELETE );
        $updateProperties->attach( 
            $p_length = new ezcWebdavGetContentLengthProperty(), 
            ezcWebdavPropPatchRequest::DELETE
        );
        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::DELETE );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $updateProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $failed = new ezcWebdavPropertyStorage();
        $failed->attach( $p_length );

        $depError = new ezcWebdavPropertyStorage();
        $depError->attach( $p_foo );
        $depError->attach( $p_bar );

        $failed->rewind();
        $depError->rewind();
        $this->assertEquals(
            new ezcWebdavPropPatchResponse(
                new ezcWebdavResource( '/foo' ),
                new ezcWebdavPropStatResponse(
                    $failed,
                    ezcWebdavResponse::STATUS_403
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
