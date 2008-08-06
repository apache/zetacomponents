<?php
/**
 * Basic test cases for the file backend.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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

    protected $oldTimezone;

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
                touch( $path, $time, $time );
                $this->recursiveTouch( $path, $time );
            }
            else
            {
                touch( $path, $time, $time );
            }
        }
    }

    /**
    * Recursively copy a file or directory.
    *
    * Recursively copy a file or directory in $source to the given
    * destination. If a depth is given, the operation will stop, if the given
    * recursion depth is reached. A depth of -1 means no limit, while a depth
    * of 0 means, that only the current file or directory will be copied,
    * without any recursion.
    *
    * You may optionally define modes used to create files and directories.
    *
    * @throws ezcBaseFileNotFoundException
    *      If the $sourceDir directory is not a directory or does not exist.
    * @throws ezcBaseFilePermissionException
    *      If the $sourceDir directory could not be opened for reading, or the
    *      destination is not writeable.
    *
    * @param string $source
    * @param string $destination
    * @param int $depth
    * @param int $dirMode
    * @param int $fileMode
    * @return void
    */
    static protected function copyRecursive( $source, $destination, $depth = -1, $dirMode = 0775, $fileMode = 0664 )
    {
        // Check if source file exists at all.
        if ( !is_file( $source ) && !is_dir( $source ) )
        {
            throw new ezcBaseFileNotFoundException( $source );
        }

        // Destination file should NOT exist
        if ( is_file( $destination ) || is_dir( $destination ) )
        {
            throw new ezcBaseFilePermissionException( $destination, ezcBaseFileException::WRITE );
        }

        // Skip non readable files in source directory
        if ( !is_readable( $source ) )
        {
            return;
        }

        // Copy
        if ( is_dir( $source ) )
        {
            mkdir( $destination );
            // To ignore umask, umask() should not be changed with
            // multithreaded servers...
            chmod( $destination, $dirMode );
        }
        elseif ( is_file( $source ) )
        {
            copy( $source, $destination );
            chmod( $destination, $fileMode );
        }

        if ( ( $depth === 0 ) ||
            ( !is_dir( $source ) ) )
        {
            // Do not recurse (any more)
            return;
        }

        // Recurse
        //
        // Read directory using glob(), to get a pre-sorted result.
        $files = glob( $source . '/*' );
        foreach ( $files as $fullName )
        {
            $file = basename( $fullName );

            if ( empty( $file ) )
            {
                continue;
            }

            self::copyRecursive(
                $source . '/' . $file,
                $destination . '/' . $file,
                $depth - 1, $dirMode, $fileMode
            );
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
        
        self::copyRecursive( 
            dirname( __FILE__ ) . '/data/backend_file', 
            $this->tempDir . 'backend/'
        );

        // Remove SVN directories from temporary backend
        $svnDirs = ezcFile::findRecursive(
            $this->tempDir . 'backend/',
            array( '(/\.svn/entries$)' )
        );

        foreach ( $svnDirs as $dir )
        {
            ezcFile::removeRecursive( dirname( $dir ) );
        }

        // Explicitely set mtime and ctime
        $this->recursiveTouch(
            $this->tempDir . 'backend/',
            // Change this once 64bit systems are common, or we reached year 2038
            2147483647
        );

        // Store current timezone and switch to UTC for test
        $this->oldTimezone = date_default_timezone_get();
        date_default_timezone_set( 'UTC' );
    }

    public function tearDown()
    {
        // Reset old timezone
        date_default_timezone_set( $this->oldTimezone );

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
                            '/collection/deep_collection'
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

        $request = new ezcWebdavGetRequest( '/collection/deep_collection/deep_test.txt' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/collection/deep_collection/deep_test.txt',
                    $backend->getAllProperties( '/collection/deep_collection/deep_test.txt' ),
                    "=========\nTest file\n=========\n\nAnd again some randome contents...\n"
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

    public function testResourceCopyProperties()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        $backend->options->useMimeExts = false;

        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            $p1 = new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );
        $newProperties->attach( 
            $p2 = new ezcWebdavDeadProperty( 'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n" ), 
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

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

        $this->assertTrue(
            is_file( $this->tempDir . 'backend/.ezc/new_resource.xml' ),
            'Expected creation of property storage.'
        );

        $request = new ezcWebdavPropFindRequest( '/new_resource' );
        $request->prop = $newProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $responseProperty = new ezcWebdavBasicPropertyStorage();
        $responseProperty->attach( $p1 );
        $responseProperty->attach( $p2 );

        $responseProperty->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/new_resource' ),
                new ezcWebdavPropStatResponse(
                    $responseProperty
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
            is_file( $this->tempDir . 'backend/new_collection/deep_collection/deep_test.txt' ),
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
            is_file( $this->tempDir . 'backend/new_collection/deep_collection/deep_test.txt' ),
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
            is_file( $this->tempDir . 'backend/new_collection/deep_collection/deep_test.txt' ),
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
            is_file( $this->tempDir . 'backend/new_collection/deep_collection/deep_test.txt' ),
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

        chmod ( $this->tempDir . 'backend/collection', 0 );

        // @TODO: This can be removed with the latest PHPUnit release, but for
        // now we need it, or the is_file() call on backend/collection/test.txt
        // will return a wrong cached result.
        clearstatcache();

        $request = new ezcWebdavDeleteRequest( '/collection/test.txt' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
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

        chmod ( $this->tempDir . 'backend/collection', 0777 );
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

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection/new_collection/.ezc' ),
            'Expected property storage in directory.'
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

        $this->assertTrue(
            is_dir( $this->tempDir . 'backend/collection/.ezc' ),
            'Expected property storage in directory.'
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

    public function testPropMimeTypeOnResourceNoExt()
    {
        if ( ezcBaseFeatures::hasExtensionSupport( 'fileinfo' ) ||
             ezcBaseFeatures::hasExtensionSupport( 'mime_magic' ) )
        {
            $this->markTestSkipped( 'Test is run only, when no mime type detection is available.' );
        }

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            new ezcWebdavGetContentTypeProperty()
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $responseProperty = new ezcWebdavBasicPropertyStorage();
        $responseProperty->attach(
            new ezcWebdavGetContentTypeProperty( 'text/xml' )
        );

        $responseProperty->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $responseProperty
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

    public function testPropMimeTypeOnResourceMimeMagicExt()
    {
        if ( ezcBaseFeatures::hasExtensionSupport( 'fileinfo' ) ||
             !ezcBaseFeatures::hasExtensionSupport( 'mime_magic' ) )
        {
            $this->markTestSkipped( 'Test is run only, when only mime magic extension is available.' );
        }

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            new ezcWebdavGetContentTypeProperty()
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $responseProperty = new ezcWebdavBasicPropertyStorage();
        $responseProperty->attach(
            new ezcWebdavGetContentTypeProperty( 'text/plain' )
        );

        $responseProperty->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $responseProperty
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

    public function testPropMimeTypeOnResourcePeclFileInfo()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'fileinfo' ) )
        {
            $this->markTestSkipped( 'Test is run only, when pecl/fileinfo extension is available.' );
        }

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            new ezcWebdavGetContentTypeProperty()
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $responseProperty = new ezcWebdavBasicPropertyStorage();
        $responseProperty->attach(
            new ezcWebdavGetContentTypeProperty( 'text/plain; charset=us-ascii' )
        );

        $responseProperty->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $responseProperty
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

    public function testPropMimeTypeOnResourceWithoutGuessingPriorSet()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        $backend->options->useMimeExts = false;

        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            new ezcWebdavGetContentTypeProperty()
        );

        $request = new ezcWebdavPropFindRequest( '/resource' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $responseProperty = new ezcWebdavBasicPropertyStorage();
        $responseProperty->attach(
            new ezcWebdavGetContentTypeProperty( 'text/xml' )
        );

        $responseProperty->rewind();
        $expectedResponse = new ezcWebdavMultistatusResponse(
            new ezcWebdavPropFindResponse(
                new ezcWebdavResource( '/resource' ),
                new ezcWebdavPropStatResponse(
                    $responseProperty
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

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetContentLengthProperty( '22' )
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@2147483647' ) )
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p2 = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
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
            'Setting properties on ressource failed.',
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
            'Properties are not available for ressource.',
            0,
            20
        );
    }

    public function testPropPatchSetLiveProperty()
    {
        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
    
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            $p = new ezcWebdavGetContentLengthProperty( '23' ), 
            ezcWebdavPropPatchRequest::SET
        );

        $request = new ezcWebdavPropPatchRequest( '/resource' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $failed = new ezcWebdavBasicPropertyStorage();
        $failed->attach( $p );
        $failed->rewind();

        $this->assertEquals(
            new ezcWebdavMultistatusResponse(
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
                        new ezcWebdavBasicPropertyStorage(),
                        ezcWebdavResponse::STATUS_424
                    )
                )
            ),
            $response,
            'Expected property removing PROPPATCH response does not match real response.',
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blah = new ezcWebdavDeadProperty( 
            'foo:', 'blah', "<?xml version=\"1.0\"?>\n<blah xmlns=\"foo:\">even more content</blah>\n"
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
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
            'Setting properties failed.',
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
            'Deletion of properties failed.',
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
            'Property has not been properly removed.',
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
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
            $p_last = new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@2147483647' ) ),
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
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
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', "<?xml version=\"1.0\"?>\n<foo xmlns=\"foo:\">random content</foo>\n" ),
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
            'foo:', 'bar', "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', "<?xml version=\"1.0\"?>\n<blubb xmlns=\"foo:\">some other content</blubb>\n"
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
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', "<?xml version=\"1.0\"?>\n<foo xmlns=\"foo:\">random content</foo>\n" ),
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
            new ezcWebdavMultistatusResponse(
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
                )
            ),
            $response,
            'Expected property removing PROPPATCH response does not match real response.',
            0,
            20
        );
    }

    public function testETagGeneration()
    {
        $backendDir = $this->tempDir . 'backend/';
        $backend = new ezcWebdavFileBackend( $backendDir );

        $this->assertEquals(
            md5( '/resource' . filesize( $backendDir . 'resource' ) . filemtime( $backendDir . 'resource' ) ),
            $backend->getProperty( '/resource', 'getetag' )->etag 
        );
    }
}

?>
