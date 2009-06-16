<?php
/**
 * Basic test cases for the memory backend.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */

/**
 * Tests for ezcWebdavMemoryBackend class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavMemoryBackendTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavMemoryBackendTest' );
	}

    public function setUp()
    {
        $this->tmp = $this->createTempDir( __CLASS__ );
    }

    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testEmptyMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend( false );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(),
            ),
            'Expected empty content array.'
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(),
            'Expected empty property array.'
        );

        $this->assertSame(
            0,
            $backend->getFeatures(),
            'Memory backend should not support any special features.'
        );
    }

    public function testFileListMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'blubb' => 'Somme blubb blubbs.',
            'ignored',
            'ignored' => true,
        ) );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            array(
                '/' => array(
                    '/foo',
                    '/blubb',
                ),
                '/foo' => 'bar',
                '/blubb' => 'Somme blubb blubbs.',
            ),
            $content
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            array(
                '/foo' => new ezcWebdavBasicPropertyStorage(),
                '/blubb' => new ezcWebdavBasicPropertyStorage(),
            ),
            $props,
            'Expected empty property array.'
        );
    }

    public function testCollectionMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            array(
                '/foo' => new ezcWebdavBasicPropertyStorage(),
                '/bar' => new ezcWebdavBasicPropertyStorage(),
                '/bar/blubb' => new ezcWebdavBasicPropertyStorage(),
            ),
            $props,
            'Expected empty property array.'
        );
    }

    public function testFakedLiveProperties()
    {
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        // Expected properties
        $propertyStorage = new ezcWebdavBasicPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
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
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_RESSOURCE
            )
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $propertyStorage,
            $props['/foo'],
            'Expected filled property array.'
        );
    }

    public function testMemoryBackendOptionsInMemoryBackend()
    {
        $server = new ezcWebdavMemoryBackend( false );

        $this->assertEquals(
            $server->options,
            new ezcWebdavMemoryBackendOptions(),
            'Expected initially unmodified backend options class.'
        );

        $this->assertSame(
            0,
            $server->options->failingOperations,
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

    public function testMemoryBackendOptionsSetInMemoryBackend()
    {
        $server = new ezcWebdavMemoryBackend( false );

        $options = new ezcWebdavMemoryBackendOptions();
        $options->failingOperations = 1;

        $this->assertSame(
            0,
            $server->options->failingOperations,
            'Wrong initial value before changed option class.'
        );

        $server->options = $options;

        $this->assertSame(
            1,
            $server->options->failingOperations,
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

    public function testMemoryBackendOptionsLockFile()
    {
        $options = new ezcWebdavMemoryBackendOptions();

        $lockFile = $this->tmp . '/test.lock';

        $this->assertSetProperty(
            $options,
            'lockFile',
            array( $lockFile )
        );
        
        $this->assertSetPropertyFails(
            $options,
            'lockFile',
            array( '/foo/bar/baz/test.lock', $this->tmp . '/foo/test.lock' )
        );
    }

    public function testSettingProperty()
    {
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        $backend->setProperty( 
            '/foo',
            new ezcWebdavDeadProperty( 'wcv:', 'ctime', '123456' )
        );

        // Expected properties
        $propertyStorage = new ezcWebdavBasicPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
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
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_RESSOURCE
            )
        );
        $propertyStorage->attach(
            new ezcWebdavDeadProperty( 'wcv:', 'ctime', '123456' )
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $propertyStorage,
            $props['/foo'],
            'Expected filled property array.'
        );
    }

    public function testSettingPropertyOnUnknownRessource()
    {
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        $this->assertFalse( 
            $backend->setProperty( 
                '/bar',
                new ezcWebdavDeadProperty( 'wcv:', 'ctime', '123456' )
            ),
            'Setting on unknown ressource sould return false.'
        );
    }

    public function testResourceHead()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavHeadRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $expectedResponse = new ezcWebdavHeadResponse(
            new ezcWebdavResource(
                '/foo', $backend->initializeProperties( '/foo' )
            )
        );
        $expectedResponse->setHeader( 'ETag', '1effb2475fcfba4f9e8b8a1dbc8f3caf' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCollectionHead()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavHeadRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->head( $request );
        
        $expectedResponse = new ezcWebdavHeadResponse(
            new ezcWebdavCollection(
                '/bar', $backend->initializeProperties( '/bar', true )
            )
        );
        $expectedResponse->setHeader( 'ETag', '6a764eebfa109a9ef76c113f3f608c6b' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceHeadError()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavHeadRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->head( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceGet()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavGetRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $expectedResponse = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                '/foo', $backend->initializeProperties( '/foo' ), 'bar'
            )
        );
        $expectedResponse->setHeader( 'ETag', '1effb2475fcfba4f9e8b8a1dbc8f3caf' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceGetError()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavGetRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceGetWithProperties()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        // Expected properties
        $propertyStorage = new ezcWebdavBasicPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
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
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_RESSOURCE
            )
        );

        $request = new ezcWebdavGetRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $expectedResponse = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                '/foo', 
                $propertyStorage,
                'bar'
            )
        );
        $expectedResponse->setHeader( 'ETag', '1effb2475fcfba4f9e8b8a1dbc8f3caf' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testCollectionGet()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
                'blah' => array(
                    'fumdiidudel.txt' => 'Willst du an \'was Rundes denken, denk\' an einen Plastikball. Willst du \'was gesundes schenken, schenke einen Plastikball. Plastikball, Plastikball, ...',
                ),
            )
        ) );

        $request = new ezcWebdavGetRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $expectedResponse = new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                '/bar', $backend->initializeProperties( '/bar', true ), array(
                    new ezcWebdavResource(
                        '/bar/blubb'
                    ),
                    new ezcWebdavCollection(
                        '/bar/blah'
                    ),
                )
            )
        );
        $expectedResponse->setHeader( 'ETag', '6a764eebfa109a9ef76c113f3f608c6b' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceDeepGet()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
                'blah' => array(
                    'fumdiidudel.txt' => 'Willst du an \'was Rundes denken, denk\' an einen Plastikball. Willst du \'was gesundes schenken, schenke einen Plastikball. Plastikball, Plastikball, ...',
                ),
            )
        ) );

        $request = new ezcWebdavGetRequest( '/bar/blah/fumdiidudel.txt' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $expectedResponse = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                '/bar/blah/fumdiidudel.txt', 
                $backend->initializeProperties( '/bar/blah/fumdiidudel.txt' ), 
                'Willst du an \'was Rundes denken, denk\' an einen Plastikball. Willst du \'was gesundes schenken, schenke einen Plastikball. Plastikball, Plastikball, ...'
            )
        );
        $expectedResponse->setHeader( 'ETag', '1c4cc7ffb86ee1feec13f05fb667e806' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopy()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/dest' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavCopyResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $this->assertNotSame(
            $backend->getAllProperties( '/foo' ),
            $backend->getAllProperties( '/dest' ),
            'Properties not cloned on copy.'
        );
    }

    public function testResourceCopyError()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/unknown', '/irrelevant' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyF()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/dest' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavCopyResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyOverwrite()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/bar' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavCopyResponse(
                true
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyOverwriteFailed()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/bar' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDestinationNotExisting()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/dum/di' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopySourceEqualsDest()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/foo', '/foo' );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceCopyDepthZero()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavCopyResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testResourceCopyDepthInfinity()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
            )
        ) );

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            new ezcWebdavCopyResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testResourceCopyDepthInfinityErrors()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
                '_3' => 'contents',
                '_4' => 'contents',
                '_5' => 'contents',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_COPY;
        $backend->options->failForRegexp = '(_[24]$)';

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
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
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testResourceMove()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/dest' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavMoveResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveError()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/unknown', '/irrelevant' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveF()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/dest' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavMoveResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveOverwrite()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/bar' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavMoveResponse(
                true
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveOverwriteFailed()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/bar' );
        $request->setHeader( 'Overwrite', 'F' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                '/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDestinationNotExisting()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/dum/di' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveSourceEqualsDest()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/foo', '/foo' );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceMoveDepthInfinity()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
            )
        ) );

        $request = new ezcWebdavMoveRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            new ezcWebdavMoveResponse(
                false
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testResourceMoveDepthInfinityErrors()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
                '_3' => 'contents',
                '_4' => 'contents',
                '_5' => 'contents',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_COPY;
        $backend->options->failForRegexp = '(_[24]$)';

        $request = new ezcWebdavMoveRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
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
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testResourceDelete()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavDeleteRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            new ezcWebdavDeleteResponse(
                '/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            array(
                '/' => array(
                    '/bar',
                ),
                '/bar' => array(
                    '/bar/blubb',
                ),
                '/bar/blubb' => 'Somme blubb blubbs.',
            ),
            $content
        );
    }

    public function testCollectionDelete()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavDeleteRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            new ezcWebdavDeleteResponse(
                '/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            array(
                '/' => array(
                    '/foo',
                ),
                '/foo' => 'bar',
            ),
            $content
        );
    }

    public function testResourceDeleteError404()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavDeleteRequest( '/unknown' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                '/unknown'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testResourceDeleteCausedError()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_DELETE;
        $backend->options->failForRegexp = '(foo)';

        $request = new ezcWebdavDeleteRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            new ezcWebdavMultistatusResponse(
                array(
                    new ezcWebdavErrorResponse(
                        ezcWebdavResponse::STATUS_423,
                        '/foo'
                    ),
                )
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testMakeCollectionOnExistingCollection()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/bar' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionOnExistingRessource()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                '/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionMissingParent()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/dum/di' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionInRessource()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/foo/bar' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                '/foo/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollectionWithRequestBody()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/bar/foo', 'with request body' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_415,
                '/bar/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testMakeCollection()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavMakeCollectionRequest( '/bar/foo' );
        $request->validateHeaders();
        $response = $backend->makeCollection( $request );

        $this->assertEquals(
            new ezcWebdavMakeCollectionResponse(
                '/bar/foo'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testPutOnExistingCollection()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPutRequest( '/bar', 'some content' );
        $request->setHeader( 'Content-Type', 'text/plain' );
        $request->setHeader( 'Content-Length', strlen( $request->body ) );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPutMissingParent()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPutRequest( '/dum/di', 'some content' );
        $request->setHeader( 'Content-Type', 'text/plain' );
        $request->setHeader( 'Content-Length', strlen( $request->body ) );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/dum/di'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPutInRessource()
    {
        $backend = new ezcWebdavMemoryBackend( false );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPutRequest( '/foo/bar', 'some content' );
        $request->setHeader( 'Content-Type', 'text/plain' );
        $request->setHeader( 'Content-Length', strlen( $request->body ) );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $this->assertEquals(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                '/foo/bar'
            ),
            $response,
            'Expected response does not match real response.',
            0,
            20
        );
    }

    public function testPut()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPutRequest( '/bar/foo', 'some content' );
        $request->setHeader( 'Content-Type', 'text/plain' );
        $request->setHeader( 'Content-Length', strlen( $request->body ) );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $expectedResponse = new ezcWebdavPutResponse(
            '/bar/foo'
        );
        $expectedResponse->setHeader( 'ETag', 'e5bb98b3adcbc2496f67c8917c44191f' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testPutOnExistingRessource()
    {
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
            return;
        }

        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPutRequest( '/foo', 'some content' );
        $request->setHeader( 'Content-Type', 'text/plain' );
        $request->setHeader( 'Content-Length', strlen( $request->body ) );
        $request->validateHeaders();
        $response = $backend->put( $request );

        $expectedResponse = new ezcWebdavPutResponse(
            '/foo'
        );
        $expectedResponse->setHeader( 'ETag', '1effb2475fcfba4f9e8b8a1dbc8f3caf' );

        $this->assertEquals(
            $expectedResponse,
            $response,
            'Expected response does not match real response.',
            0,
            20
        );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
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
            ),
            $content
        );
    }

    public function testPropFindOnResource()
    {
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetLastModifiedProperty()
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetContentLengthProperty()
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        
        $response = $backend->propfind( $request );

        $prop200 = new ezcWebdavBasicPropertyStorage();
        $prop1->date = new ezcWebdavDateTime( '@1124118780' );
        $prop200->attach( $prop1 );
        $prop2->length = '3';
        $prop200->attach( $prop2 );
        $prop200->rewind();

        $prop404 = new ezcWebdavBasicPropertyStorage();
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $requestedProperties = new ezcWebdavBasicPropertyStorage();
        $requestedProperties->attach(
            $prop1 = new ezcWebdavGetLastModifiedProperty()
        );
        $requestedProperties->attach(
            $prop2 = new ezcWebdavGetContentLengthProperty()
        );
        $requestedProperties->attach(
            $prop3 = new ezcWebdavDeadProperty( 'http://apache.org/dav/props/', 'executable' )
        );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->prop = $requestedProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $prop200c = new ezcWebdavBasicPropertyStorage();
        $prop1c = clone $prop1;
        $prop1c->date = new ezcWebdavDateTime( '@1124118780' );
        $prop200c->attach( $prop1c );
        $prop2c = clone $prop2;
        $prop2c->length = '4096';
        $prop200c->attach( $prop2c );

        $prop404c = new ezcWebdavBasicPropertyStorage();
        $prop404c->attach( $prop3 );

        $prop200r = new ezcWebdavBasicPropertyStorage();
        $prop1r = clone $prop1;
        $prop1r->date = new ezcWebdavDateTime( '@1124118780' );
        $prop200r->attach( $prop1r );
        $prop2r = clone $prop2;
        $prop2r->length = '19';
        $prop200r->attach( $prop2r );

        $prop404r = new ezcWebdavBasicPropertyStorage();
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

        $prop200c->rewind();
        $prop404c->rewind();
        $prop200r->rewind();
        $prop404r->rewind();

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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->propName = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
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
            $test = new ezcWebdavGetContentLengthProperty()
        );
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty()
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
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
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty()
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blah' => array(
                    'dum' => array(
                        'di' => 'blah blah',
                    ),
                ),
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
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
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty()
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blah' => array(
                    'dum' => array(
                        'di' => 'blah blah',
                    ),
                ),
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ONE );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
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
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty()
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blah' => array(
                    'dum' => array(
                        'di' => 'blah blah',
                    ),
                ),
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->propName = true;
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
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
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty()
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorage = new ezcWebdavBasicPropertyStorage();
        $propertyStorage->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
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
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorage->attach(
            new ezcWebdavGetContentLengthProperty( '3' )
        );
        $propertyStorage->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_RESSOURCE
            )
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavPropFindRequest( '/bar' );
        $request->allProp = true;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $propertyStorageC = new ezcWebdavBasicPropertyStorage();
        $propertyStorageC->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavDisplayNameProperty( 'bar' )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentLanguageProperty( array( 'en' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentTypeProperty( 'httpd/unix-directory' )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetEtagProperty( md5( '/bar' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorageC->attach(
            new ezcWebdavGetContentLengthProperty( ezcWebdavGetContentLengthProperty::COLLECTION )
        );
        $propertyStorageC->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_COLLECTION
            )
        );

        $propertyStorageR = new ezcWebdavBasicPropertyStorage();
        $propertyStorageR->attach(
            new ezcWebdavCreationDateProperty( new ezcWebdavDateTime( '@1054034820' ) )
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
            new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $propertyStorageR->attach(
            new ezcWebdavGetContentLengthProperty( '19' )
        );
        $propertyStorageR->attach(
            new ezcWebdavResourceTypeProperty(
                ezcWebdavResourceTypeProperty::TYPE_RESSOURCE
            )
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_PROPPATCH;
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $newProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        // We expect the first to fail "normally".
        $failed = new ezcWebdavBasicPropertyStorage();
        $failed->attach( $p_bar );
        $failed->rewind();

        // All other will cause dep errors.
        $depError = new ezcWebdavBasicPropertyStorage();
        $depError->attach( $p_blubb );
        $depError->attach( $p_blah );
        $depError->rewind();

        $this->assertEquals(
            new ezcWebdavMultistatusResponse(
                new ezcWebdavPropPatchResponse(
                    new ezcWebdavResource( '/foo' ),
                    new ezcWebdavPropStatResponse(
                        $failed,
                        ezcWebdavResponse::STATUS_403
                    ),
                    new ezcWebdavPropStatResponse(
                        new ezcWebdavBasicPropertyStorage,
                        ezcWebdavResponse::STATUS_409
                    ),
                    new ezcWebdavPropStatResponse(
                        $depError,
                        ezcWebdavResponse::STATUS_424
                    )
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );

        $removedProperties = new ezcWebdavBasicPropertyStorage();
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
        $leftProperties = new ezcWebdavBasicPropertyStorage();
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
        // First add some custom properties.
        $newProperties = new ezcWebdavFlaggedPropertyStorage();
        $newProperties->attach( $p_bar = new ezcWebdavDeadProperty( 
            'foo:', 'bar', 'some content'
        ), ezcWebdavPropPatchRequest::SET );
        $newProperties->attach( $p_blubb = new ezcWebdavDeadProperty( 
            'foo:', 'blubb', 'some other content'
        ), ezcWebdavPropPatchRequest::SET );

        $newProperties->rewind();

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
        $removeProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $removeProperties->attach(  
            $p_length = new ezcWebdavGetContentLengthProperty(),
            ezcWebdavPropPatchRequest::REMOVE
        );
        $removeProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );
        $removeProperties->attach(  
            $p_last = new ezcWebdavGetLastModifiedProperty(),
            ezcWebdavPropPatchRequest::REMOVE
        );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
        $request->updates = $removeProperties;
        $request->validateHeaders();
        $response = $backend->proppatch( $request );

        $failed = new ezcWebdavBasicPropertyStorage();
        $failed->attach( $p_length );

        $depError = new ezcWebdavBasicPropertyStorage();
        $depError->attach( $p_bar );
        $depError->attach( $p_last );

        $failed->rewind();
        $depError->rewind();
        $this->assertEquals(
            new ezcWebdavMultistatusResponse(
                new ezcWebdavPropPatchResponse(
                    new ezcWebdavResource( '/foo' ),
                    new ezcWebdavPropStatResponse(
                        $failed,
                        ezcWebdavResponse::STATUS_403
                    ),
                    new ezcWebdavPropStatResponse(
                        new ezcWebdavBasicPropertyStorage,
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

        // Ensure nothing has been removed, and the transactions has been
        // properly reverted.
        $leftProperties = new ezcWebdavBasicPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/foo' );
        $request->prop = $removeProperties;
        $request->validateHeaders();
        $response = $backend->propfind( $request );

        $checkProperties = new ezcWebdavBasicPropertyStorage();
        $checkProperties->attach(  
            $p_last = new ezcWebdavGetLastModifiedProperty( new ezcWebdavDateTime( '@1124118780' ) )
        );
        $checkProperties->attach(  
            $p_length = new ezcWebdavGetContentLengthProperty( '3' )
        );
        $checkProperties->attach( $p_bar );
        $checkProperties->attach( $p_blubb );
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );

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
        $leftProperties = new ezcWebdavBasicPropertyStorage();
        $leftProperties->attach( $p_bar );

        $request = new ezcWebdavPropFindRequest( '/foo' );
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
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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

        $request = new ezcWebdavPropPatchRequest( '/foo' );
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
                    new ezcWebdavResource( '/foo' ),
                    new ezcWebdavPropStatResponse(
                        $failed,
                        ezcWebdavResponse::STATUS_403
                    ),
                    new ezcWebdavPropStatResponse(
                        new ezcWebdavBasicPropertyStorage,
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

    public function testPropPatchCombinedSetDeleteValidationError()
    {
        $backend = new ezcWebdavMemoryBackend( true );
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );
    
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
        $updateProperties->attach( $p_blubb, ezcWebdavPropPatchRequest::REMOVE );
        $updateProperties->attach( 
            $p_length = new ezcWebdavGetContentLengthProperty(), 
            ezcWebdavPropPatchRequest::REMOVE
        );

        // Cause validation error
        $p_length->length = 'not a number';

        $updateProperties->attach( 
            $p_foo = new ezcWebdavDeadProperty( 'foo:', 'foo', 'random content' ),
            ezcWebdavPropPatchRequest::SET
        );
        $updateProperties->attach( $p_bar, ezcWebdavPropPatchRequest::REMOVE );

        $request = new ezcWebdavPropPatchRequest( '/foo' );
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
                    new ezcWebdavResource( '/foo' ),
                    new ezcWebdavPropStatResponse(
                        new ezcWebdavBasicPropertyStorage,
                        ezcWebdavResponse::STATUS_403
                    ),
                    new ezcWebdavPropStatResponse(
                        $failed,
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

    public function testLock()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->lockFile = $this->tmp . 'backend.lock';

        $backend->lock( 1000, 200000 );

        $this->assertFileExists(
            $backend->options->lockFile,
            'Lock file not created'
        );

        $backend->unlock();

        $this->assertFileNotExists(
            $backend->options->lockFile,
            'Lock file not removed.'
        );
    }
}

?>
