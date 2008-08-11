<?php
/**
 * Basic test cases for the simple backend.
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
 * Tests for ezcWebdavSimpleBackend class.
 *
 * This test suite takes the {@link ezcWebdavFileBackend} class to test
 * functionality that is globally implemented in {@link
 * ezcWebdavSimpleBackend}.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavSimpleBackendTest extends ezcWebdavTestCase
{
    protected $tempDir;

    protected $oldTimezone;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

    // ******************************
    // Tool methods
    // ******************************

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

    // ******************************
    // HEAD request tests
    // ******************************

    public function testHeadResourceETagHeader()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavHeadRequest(
            $testPath
        );
        $req->validateHeaders();

        $res = $backend->head( $req );

        $expectedRes = new ezcWebdavHeadResponse(
            new ezcWebdavResource(
                $testPath,
                $backend->getAllProperties( $testPath )
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testHeadCollectionETagHeader()
    {
        $testPath = '/collection/';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavHeadRequest(
            $testPath
        );
        $req->validateHeaders();

        $res = $backend->head( $req );

        $expectedRes = new ezcWebdavHeadResponse(
            new ezcWebdavCollection(
                $testPath,
                $backend->getAllProperties( $testPath )
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // GET request tests
    // ******************************

    public function testGetResourceWithValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( $etag ) );
        $req->validateHeaders();

        $res = $backend->get( $req );
        $expectedRes = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                $testPath,
                $backend->getAllProperties( $testPath ),
                "Some other contents...\n"
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceWithMultipleAndValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'sometag', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $expectedRes = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                $testPath,
                $backend->getAllProperties( $testPath ),
                "Some other contents...\n"
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceIfNoneMatchMultipleInvalidETags()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-None-Match', array( 'sometag', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );
        $expectedRes = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                $testPath,
                $backend->getAllProperties( $testPath ),
                "Some other contents...\n"
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }
 
    public function testGetResourceWithInvalidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'someinvalidetag' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_412,
                    $testPath,
                    'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceWithMultipleInvalidETags()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'sometag', 'some other tag', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_412,
                    $testPath,
                    'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceIfNoneMatchFailure()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-None-Match', array( 'sometag', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_412,
                    $testPath,
                    'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceIfNoneMatchFailureStar()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-None-Match', true );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_412,
                    $testPath,
                    'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetResourceFailureBeforeInvalidETagsMatch()
    {
        $testPath = '/collection/notexistent.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'sometag', 'some other tag', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_404,
                    $testPath
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetCollectionWithValidETag()
    {
        $testPath = '/collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( $etag ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $expectedRes = new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                $testPath,
                $backend->getAllProperties( $testPath ),
                array(
                    new ezcWebdavCollection(
                        '/collection/deep_collection'
                    ),
                    new ezcWebdavResource(
                        '/collection/test.txt'
                    ),
                )
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetCollectionWithMultipleAndValidETag()
    {
        $testPath = '/collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'sometag', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        $expectedRes = new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                $testPath,
                $backend->getAllProperties( $testPath ),
                array(
                    new ezcWebdavCollection(
                        '/collection/deep_collection'
                    ),
                    new ezcWebdavResource(
                        '/collection/test.txt'
                    ),
                )
            )
        );
        $expectedRes->setHeader( 'ETag', $etag );

        $this->assertEquals(
            $expectedRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetCollectionWithInvalidETag()
    {
        $testPath = '/collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'someinvalidetag' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        // Collection ETags are ignored on purpose!
        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection',
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testGetCollectionWithMultipleInvalidETags()
    {
        $testPath = '/collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavGetRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'sometag', 'some other tag', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->get( $req );

        // Collection ETags are ignored on purpose!
        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection',
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // PROPFIND request tests
    // ******************************

    public function testPropfindResourceWithValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavPropFindRequest(
            $testPath
        );
        $req->allProp = true;
        $req->validateHeaders();

        // Create fake response without If-Match
        $fakeRes = $backend->propFind( $req );

        // Ensure no error occurred
        $this->assertType(
            'ezcWebdavMultistatusResponse',
            $fakeRes,
            'Generation of expected response failed.'
        );
        
        $req->setHeader( 'If-Match', array( $etag ) );
        $req->validateHeaders();

        $res = $backend->propFind( $req );

        $this->assertEquals(
            $fakeRes,
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPropfindResourceWithInvalidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $req = new ezcWebdavPropFindRequest(
            $testPath
        );
        $req->allProp = true;
        $req->setHeader( 'If-Match', array( 'sometag' ) );
        $req->validateHeaders();

        $res = $backend->propFind( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testPath,
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // PROPPATCH request tests
    // ******************************

    public function testProppatchResourceWithValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;
        
        // Properties to patch
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            $p1 = new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );
        $newProperties->attach( 
            $p2 = new ezcWebdavDeadProperty(
                'foo:',
                'bar',
                "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
            ), 
            ezcWebdavPropPatchRequest::SET
        );

        $req = new ezcWebdavProppatchRequest(
            $testPath
        );
        $req->updates = $newProperties;
        $req->setHeader( 'If-Match', array( 'abc23', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->propPatch( $req );

        $this->assertEquals(
            new ezcWebdavPropPatchResponse( 
                new ezcWebdavResource( $testPath )
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testProppatchResourceWithInvalidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );

        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;
        
        // Properties to patch
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( 
            $p1 = new ezcWebdavGetContentTypeProperty( 'text/xml' ),
            ezcWebdavPropPatchRequest::SET
        );
        $newProperties->attach( 
            $p2 = new ezcWebdavDeadProperty(
                'foo:',
                'bar',
                "<?xml version=\"1.0\"?>\n<bar xmlns=\"foo:\">some content</bar>\n"
            ), 
            ezcWebdavPropPatchRequest::SET
        );

        $req = new ezcWebdavProppatchRequest(
            $testPath
        );
        $req->updates = $newProperties;
        $req->setHeader( 'If-None-Match', array( 'abc23', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->propPatch( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testPath,
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // PUT request tests
    // ******************************

    public function testPutResourceWithValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $req = new ezcWebdavPutRequest(
            $testPath,
            "Some new text to PUT into test.txt.\n"
        );
        $req->setHeader( 'Content-Length', strlen( $req->body ) );
        $req->setHeader( 'Content-Type', 'text/plain; charset=utf8' );
        $req->setHeader( 'If-None-Match', array( 'abc23', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->put( $req );

        $this->assertEquals(
            new ezcWebdavPutResponse( 
                new ezcWebdavResource( $testPath )
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPutResourceWithInvalidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $req = new ezcWebdavPutRequest(
            $testPath,
            "Some new text to PUT into test.txt.\n"
        );
        $req->setHeader( 'Content-Length', strlen( $req->body ) );
        $req->setHeader( 'Content-Type', 'text/plain; charset=utf8' );
        $req->setHeader( 'If-Match', array( 'abc23', 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->put( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testPath,
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // DELETE request tests
    // ******************************

    public function testDeleteResourceWithValidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavDeleteRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'abc23', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->delete( $req );

        $this->assertEquals(
            new ezcWebdavDeleteResponse(),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testDeleteResourceWithInvalidETag()
    {
        $testPath = '/collection/test.txt';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $etag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavDeleteRequest(
            $testPath
        );
        $req->setHeader( 'If-None-Match', array( 'abc23', $etag, 'foobar' ) );
        $req->validateHeaders();

        $res = $backend->delete( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testPath,
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testDeleteCollectionWithValidETag()
    {
        $testPath = '/collection/deep_collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        clearstatcache();
        
        // Needs to determine resource tag first, since .ezc property dir is created.
        $resourceEtag = $backend->getProperty( $testPath . '/deep_test.txt', 'getetag' )->etag;
        $collectionEtag = $backend->getProperty( $testPath, 'getetag' )->etag;

        $req = new ezcWebdavDeleteRequest(
            $testPath
        );
        $req->setHeader( 'If-Match', array( 'abc23', $collectionEtag, $resourceEtag ) );
        $req->validateHeaders();

        $res = $backend->delete( $req );

        $this->assertEquals(
            new ezcWebdavDeleteResponse(),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testDeleteCollectionWithInvalidETag()
    {
        $testPath = '/collection/deep_collection';

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $collectionEtag = $backend->getProperty( $testPath, 'getetag' )->etag;
        $resourceEtag = $backend->getProperty( $testPath . '/deep_test.txt', 'getetag' )->etag;

        $req = new ezcWebdavDeleteRequest(
            $testPath
        );
        $req->setHeader( 'If-None-Match', array( 'abc23', $resourceEtag ) );
        $req->validateHeaders();

        $res = $backend->delete( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                "$testPath/deep_test.txt",
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // COPY request tests
    // ******************************

    public function testCopyResourceWithValidETag()
    {
        $testSourcePath = '/collection/';
        $testSource     = "$testSourcePath/test.txt";
        $testDestPath   = "$testSourcePath/deep_collection";
        $testDest       = "$testDestPath/test.txt";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $sourceEtag = $backend->getProperty( $testSource, 'getetag' )->etag;
        $destEtag = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavCopyRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', array( 'abc23', $sourceEtag, $destEtag ) );
        $req->validateHeaders();

        $res = $backend->copy( $req );

        $this->assertEquals(
            new ezcWebdavCopyResponse( false ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCopyResourceWithInvalidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/test.txt";
        $testDestPath   = "$testSourcePath/deep_collection";
        $testDest       = "$testDestPath/test.txt";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $sourceEtag = $backend->getProperty( $testSource, 'getetag' )->etag;
        $destEtag = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavCopyRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', array( 'abc23', $sourceEtag ) );
        $req->validateHeaders();

        $res = $backend->copy( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testDestPath,
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCopyCollectionWithValidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/deep_collection";
        $testDestPath   = $testSourcePath;
        $testDest       = "$testDestPath/copied_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTags = array();
       
        // Retrieve source etags
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->prop = new ezcWebdavBasicPropertyStorage();
        $req->prop->attach( new ezcWebdavGetEtagProperty() );
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $res = $backend->propFind( $req );
        foreach ( $res->responses as $propFind )
        {
            $eTags[] = $propFind->responses[0]->storage->get( 'getetag' )->etag;
        }

        $eTags[] = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavCopyRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', $eTags );
        $req->validateHeaders();

        $res = $backend->copy( $req );

        $this->assertEquals(
            new ezcWebdavCopyResponse( false ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCopyCollectionWithInvalidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/deep_collection";
        $testDestPath   = $testSourcePath;
        $testDest       = "$testDestPath/copied_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTag = $backend->getProperty( $testDestPath, 'getetag' )->etag;
        
        $req = new ezcWebdavCopyRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-None-Match', array( 'abc23', $eTag ) );
        $req->validateHeaders();

        $res = $backend->copy( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection',
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // MOVE request tests
    // ******************************

    public function testMoveResourceWithValidETag()
    {
        $testSourcePath = '/collection/';
        $testSource     = "$testSourcePath/test.txt";
        $testDestPath   = "$testSourcePath/deep_collection";
        $testDest       = "$testDestPath/test.txt";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $sourceEtag = $backend->getProperty( $testSource, 'getetag' )->etag;
        $destEtag = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavMoveRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', array( 'abc23', $sourceEtag, $destEtag ) );
        $req->validateHeaders();

        $res = $backend->move( $req );

        $this->assertEquals(
            new ezcWebdavMoveResponse( false ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMoveResourceWithInvalidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/test.txt";
        $testDestPath   = "$testSourcePath/deep_collection";
        $testDest       = "$testDestPath/test.txt";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        $sourceEtag = $backend->getProperty( $testSource, 'getetag' )->etag;
        $destEtag = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavMoveRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', array( 'abc23', $sourceEtag ) );
        $req->validateHeaders();

        $res = $backend->move( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $testDestPath,
                'If-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMoveCollectionWithValidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/deep_collection";
        $testDestPath   = $testSourcePath;
        $testDest       = "$testDestPath/copied_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTags = array();
       
        // Retrieve source etags
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->prop = new ezcWebdavBasicPropertyStorage();
        $req->prop->attach( new ezcWebdavGetEtagProperty() );
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $res = $backend->propFind( $req );
        foreach ( $res->responses as $propFind )
        {
            $eTags[] = $propFind->responses[0]->storage->get( 'getetag' )->etag;
        }

        $eTags[] = $backend->getProperty( $testDestPath, 'getetag' )->etag;

        $req = new ezcWebdavMoveRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-Match', $eTags );
        $req->validateHeaders();

        $res = $backend->move( $req );

        $this->assertEquals(
            new ezcWebdavMoveResponse( false ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMoveCollectionWithInvalidETag()
    {
        $testSourcePath = '/collection';
        $testSource     = "$testSourcePath/deep_collection";
        $testDestPath   = $testSourcePath;
        $testDest       = "$testDestPath/copied_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( $testSource );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTag = $backend->getProperty( $testDestPath, 'getetag' )->etag;
        
        $req = new ezcWebdavMoveRequest(
            $testSource, $testDest
        );
        $req->setHeader( 'If-None-Match', array( 'abc23', $eTag ) );
        $req->validateHeaders();

        $res = $backend->move( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection',
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    // ******************************
    // MKCOL request tests
    // ******************************

    public function testMakeCollectionWithValidETag()
    {
        $testDest       = "/collection/new_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( '' );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTag = $backend->getProperty( '/collection', 'getetag' )->etag;

        $req = new ezcWebdavMakeCollectionRequest(
            $testDest
        );
        $req->setHeader( 'If-Match', array( $eTag ) );
        $req->validateHeaders();

        $res = $backend->makeCollection( $req );

        $this->assertEquals(
            new ezcWebdavMakeCollectionResponse(),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionWithInvalidETag()
    {
        $testDest       = "/collection/new_collection";

        $backend = new ezcWebdavFileBackend( $this->tempDir . 'backend/' );
        
        // Initialize all property directories
        $req = new ezcWebdavPropFindRequest( '' );
        $req->allProp = true;
        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
        $backend->propFind( $req );

        $eTag = $backend->getProperty( '/collection', 'getetag' )->etag;

        $req = new ezcWebdavMakeCollectionRequest(
            $testDest
        );
        $req->setHeader( 'If-None-Match', array( $eTag ) );
        $req->validateHeaders();

        $res = $backend->makeCollection( $req );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/collection',
                'If-None-Match header check failed.'
            ),
            $res,
            'Expected response does not match real response.',
            0,
            20
        );
    }
}

?>
