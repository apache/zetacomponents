<?php

class ezcWebdavClientCadaverTestBackend
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $test->transport = new ezcWebdavTransportTestMock();
        $test->transport->options->pathFactory = new ezcWebdavPathFactory(
            'http://foo.bar'
        );
        
        return self::getFooBarSetup1( $test );
    }

    protected static function getFooBarSetup1( ezcWebdavClientTest $test )
    {
        $test->backend                             = new ezcWebdavMemoryBackend();
        $test->backend->options->failForRegexp     = '(container/resource3)';
        $test->backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_DELETE;

        $test->backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
                    'R2'         => array(),
                    'resource3'  => '',
                ),
            )
        );

        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://www.foo.bar/boxschema/',
                'bigbox',
                <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<R:bigbox xmlns:R="http://www.foo.bar/boxschema/">
<R:BoxType>Box type A</R:BoxType>
</R:bigbox>
EOT
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDeadProperty(
                'http://www.foo.bar/boxschema/',
                'author',
                <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<R:author xmlns:R="http://www.foo.bar/boxschema/">
<R:Name>Hadrian</R:Name>
</R:author>
EOT
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavCreationDateProperty(
                new DateTime( '1997-12-01T17:42:21-08:00' )
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavDisplayNameProperty(
                'Example collection'
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavResourceTypeProperty(
                'collection'
            )
        );
        $test->backend->setProperty(
            '/container',
            new ezcWebdavSupportedLockProperty(
                array(
                    new ezcWebdavSupportedLockPropertyLockentry(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_EXCLUSIVE
                    ),
                    new ezcWebdavSupportedLockPropertyLockentry(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED
                    ),
                )
            )
        );

        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavDeadProperty(
                'http://www.foo.bar/boxschema/',
                'bigbox',
                <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<R:bigbox xmlns:R="http://www.foo.bar/boxschema/">
<R:BoxType>Box type B</R:BoxType>
</R:bigbox>
EOT
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavCreationDateProperty(
                new DateTime( '1997-12-01T18:27:21-08:00' )
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavDisplayNameProperty(
                'Example HTML resource'
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentLengthProperty(
                '4525'
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentTypeProperty(
                'text/html'
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetEtagProperty(
                'zzyzx'
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetLastModifiedProperty(
                new DateTime( 'Monday, 12-Jan-98 09:25:56 GMT' )
            )
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavResourceTypeProperty()
        );
        $test->backend->setProperty(
            '/container/front.html',
            new ezcWebdavSupportedLockProperty(
                array(
                    new ezcWebdavSupportedLockPropertyLockentry(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_EXCLUSIVE
                    ),
                    new ezcWebdavSupportedLockPropertyLockentry(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_SHARED
                    ),
                )
            )
        );

        return $test->backend;
    }
}

?>
