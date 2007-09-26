<?php

class ezcWebdavClientLitmusTestBackend
{
    protected static $transport;

    protected static $backend;

    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        if ( self::$transport === null )
        {
            self::$transport = new ezcWebdavTransportTestMock();
            self::$transport->options->pathFactory = new ezcWebdavPathFactory( 'http://webdav' );
        }
        if ( self::$backend === null )
        {
            self::$backend = self::setupBackend();
        }
        $test->transport = self::$transport;
        $test->backend   = self::$backend;
    }

    protected static function setupBackend()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->options->fakeLiveProperties = true;
        $backend->addContents(
            array(
                'test_collection' => array(
                    'foo.txt'  => 'Test foo content',
                    'bar'      => 'Test bar content',
                    'baz_coll' => array(
                        'baz_1.html' => '<html></html>',
                        'baz_2.html' => '<html><body><h1>Test</h1></body></html>',
                    ),
                ),
            )
        );

        // Properties requested by Cadaver on first request

        $backend->setProperty(
            '/test_collection',
            new ezcWebdavGetLastModifiedProperty(
                new ezcWebdavDateTime()
            )
        );

        // Make GET requests work

        $backend->setProperty(
            '/test_collection/foo.txt',
            new ezcWebdavGetContentTypeProperty(
                'text/plain', 'utf-8'
            )
        );
        $backend->setProperty(
            '/test_collection/bar',
            new ezcWebdavGetContentTypeProperty(
                'text/plain', 'utf-8'
            )
        );
        $backend->setProperty(
            '/test_collection/baz_coll/baz_1.html',
            new ezcWebdavGetContentTypeProperty(
                'text/html', 'utf-8'
            )
        );
        $backend->setProperty(
            '/test_collection/baz_coll/baz_2.html',
            new ezcWebdavGetContentTypeProperty(
                'text/xhtml', 'utf-8'
            )
        );
        return $backend;
    }
}

?>
