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
                    '/bar/',
                ),
                '/foo' => 'bar',
                '/bar/' => array(
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
                '/bar/' => array(),
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

        $request = new ezcWebdavGetRequest( '/bar/' );
        $response = $backend->get( $request );

        $this->assertEquals(
            $response,
            new ezcWebdavGetCollectionResponse(
                new ezcWebdavCollection(
                    '/bar/', array(), array(
                        new ezcWebdavResource(
                            '/bar/blubb', array()
                        ),
                        new ezcWebdavCollection(
                            '/bar/blah/', array()
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
}
?>
