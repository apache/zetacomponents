<?php
/**
 * Basic test cases for the memory backend.
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
 * Tests for ezcWebdavMemoryBackend class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavMemoryBackendTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavMemoryBackendTest' );
	}

    public function testEmptyMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend();

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
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'blubb' => 'Somme blubb blubbs.',
            'ignored',
            'ignored' => true,
        ) );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(
                '/' => array(
                    '/foo',
                    '/blubb',
                ),
                '/foo' => 'bar',
                '/blubb' => 'Somme blubb blubbs.',
            )
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(
                '/foo' => array(),
                '/blubb' => array(),
            ),
            'Expected empty property array.'
        );
    }

    public function testCollectionMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

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

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(
                '/foo' => array(),
                '/bar' => array(),
                '/bar/blubb' => array(),
            ),
            'Expected empty property array.'
        );
    }

    public function testFakedLiveProperties()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->fakeLiveProperties = true;
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(
                '/foo' => array(
                    'creationdate'          => 1054034820,
                    'displayname'           => 'foo',
                    'getcontentlanguage'    => 'en',
                    'getcontentlength'      => 3,
                    'getcontenttype'        => 'application/octet-stream',
                    'getetag'               => '1effb2475fcfba4f9e8b8a1dbc8f3caf',
                    'getlastmodified'       => 1124118780,
                    'resourcetype'          => null,
                    'source'                => null,
                ),
            ),
            'Expected filled property array.'
        );
    }

    public function testMemoryBackendOptionsInMemoryBackend()
    {
        $server = new ezcWebdavMemoryBackend();

        $this->assertEquals(
            $server->options,
            new ezcWebdavMemoryBackendOptions(),
            'Expected initially unmodified backend options class.'
        );

        $this->assertSame(
            $server->options->fakeLiveProperties,
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

    public function testMemoryBackendOptionsSetInMemoryBackend()
    {
        $server = new ezcWebdavMemoryBackend();

        $options = new ezcWebdavMemoryBackendOptions();
        $options->fakeLiveProperties = true;

        $this->assertSame(
            $server->options->fakeLiveProperties,
            false,
            'Wrong initial value before changed option class.'
        );

        $server->options = $options;

        $this->assertSame(
            $server->options->fakeLiveProperties,
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

    public function testSettingProperty()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->fakeLiveProperties = true;
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        $backend->setProperty( '/foo', 'wcv:ctime', '123456' );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(
                '/foo' => array(
                    'creationdate'          => 1054034820,
                    'displayname'           => 'foo',
                    'getcontentlanguage'    => 'en',
                    'getcontentlength'      => 3,
                    'getcontenttype'        => 'application/octet-stream',
                    'getetag'               => '1effb2475fcfba4f9e8b8a1dbc8f3caf',
                    'getlastmodified'       => 1124118780,
                    'resourcetype'          => null,
                    'source'                => null,
                    'wcv:ctime'             => '123456',
                ),
            ),
            'Expected filled property array.'
        );
    }

    public function testSettingPropertyOnUnknownRessource()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->fakeLiveProperties = true;
        $backend->addContents( array(
            'foo' => 'bar',
        ) );

        $this->assertFalse( 
            $backend->setProperty( '/bar', 'wcv:ctime', '123456' ),
            'Setting on unknown ressource sould return false.'
        );
    }

    public function testResourceGet()
    {
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

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/foo', array(), 'bar'
                )
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceGetError()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                '/unknown'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceGetWithProperties()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->fakeLiveProperties = true;
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $request = new ezcWebdavGetRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/foo', 
                    array(
                        'creationdate' => 1054034820,
                        'displayname' => 'foo',
                        'getcontentlanguage' => 'en',
                        'getcontentlength' => 3,
                        'getcontenttype' => 'application/octet-stream',
                        'getetag' => '1effb2475fcfba4f9e8b8a1dbc8f3caf',
                        'getlastmodified' => 1124118780,
                        'resourcetype' => null,
                        'source' => null,
                    ), 
                    'bar'
                )
            ),
            'Expected response does not match real response.'
        );
    }

    public function testCollectionGet()
    {
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

        $this->assertEquals(
            $response,
            new ezcWebdavGetCollectionResponse(
                new ezcWebdavCollection(
                    '/bar', array(), array(
                        new ezcWebdavResource(
                            '/bar/blubb', array()
                        ),
                        new ezcWebdavCollection(
                            '/bar/blah', array()
                        ),
                    )
                )
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceDeepGet()
    {
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

        $this->assertEquals(
            $response,
            new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    '/bar/blah/fumdiidudel.txt', 
                    array(), 
                    'Willst du an \'was Rundes denken, denk\' an einen Plastikball. Willst du \'was gesundes schenken, schenke einen Plastikball. Plastikball, Plastikball, ...'
                )
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopy()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopyF()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopyOverwrite()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavCopyResponse(
                true
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopyOverwriteFailed()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_412,
                '/bar'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopyDestinationNotExisting()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopySourceEqualsDest()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_403,
                '/foo'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceCopyDepthZero()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavCopyResponse(
                false
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
                '_3' => 'contents',
                '_4' => 'contents',
                '_5' => 'contents',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavRequest::COPY;
        $backend->options->failForRegexp = '(_[24]$)';

        $request = new ezcWebdavCopyRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->copy( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavErrorResponse::STATUS_423,
                    '/bar/_2'
                ),
                new ezcWebdavErrorResponse(
                    ezcWebdavErrorResponse::STATUS_423,
                    '/bar/_4'
                )
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveF()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveOverwrite()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavMoveResponse(
                true
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveOverwriteFailed()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_412,
                '/bar'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveDestinationNotExisting()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                '/dum/di'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveSourceEqualsDest()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_403,
                '/foo'
            ),
            'Expected response does not match real response.'
        );
    }

    public function testResourceMoveDepthInfinity()
    {
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavMoveResponse(
                false
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'bar' => array(
                '_1' => 'contents',
                '_2' => 'contents',
                '_3' => 'contents',
                '_4' => 'contents',
                '_5' => 'contents',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavRequest::COPY;
        $backend->options->failForRegexp = '(_[24]$)';

        $request = new ezcWebdavMoveRequest( '/bar', '/foo' );
        $request->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $request->validateHeaders();
        $response = $backend->move( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavErrorResponse::STATUS_423,
                    '/bar/_2'
                ),
                new ezcWebdavErrorResponse(
                    ezcWebdavErrorResponse::STATUS_423,
                    '/bar/_4'
                )
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavDeleteResponse(
                '/foo'
            ),
            'Expected response does not match real response.'
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
        $backend = new ezcWebdavMemoryBackend();
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
            $response,
            new ezcWebdavDeleteResponse(
                '/bar'
            ),
            'Expected response does not match real response.'
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

    public function testResourceDeleteError()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents( array(
            'foo' => 'bar',
            'bar' => array(
                'blubb' => 'Somme blubb blubbs.',
            )
        ) );

        $backend->options->failingOperations = ezcWebdavRequest::DELETE;
        $backend->options->failForRegexp = '(foo)';

        $request = new ezcWebdavDeleteRequest( '/foo' );
        $request->validateHeaders();
        $response = $backend->delete( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_423,
                '/foo'
            ),
            'Expected response does not match real response.'
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
}
?>
