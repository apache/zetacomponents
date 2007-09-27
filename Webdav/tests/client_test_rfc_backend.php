<?php

class ezcWebdavClientRfcTestBackend
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        // Compat
        $testSetName = basename( $testSetName );

        $test->transport  = new ezcWebdavTransportTestMock();
        $test->transport->options->pathFactory = new ezcWebdavPathFactory( 'http://www.foo.bar' );

        switch( $testSetName )
        {
            case 'propfind_propname':
            case 'lockdiscovery':
            case 'supportedlock':
            case 'propfind_allprop':
            case 'delete':
                return self::getFooBarSetup1( $test );
            case 'propfind_prop':
                return self::getFooBarSetup2( $test );
            case 'proppatch':
                return self::getFooBarSetup3( $test );
            case 'copy_collection':
                return self::getFooBarSetup4( $test );
            case 'move_collection':
                return self::getFooBarSetup5( $test );
            case 'copy_success':
            case 'copy':
            case 'copy_overwrite':
            case 'options':
            case 'get_collection':
            case 'get_resource':
            case 'put_resource':
                return self::getIcsUciSetup1( $test );
            case 'move_resource':
                return self::getIcsUciSetup2( $test );
            case 'mkcol':
                return self::getServerOrgSetup( $test );
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }
    }

    public static function reset()
    {

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
                new ezcWebdavDateTime( '1997-12-01T17:42:21-08:00' )
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
                new ezcWebdavDateTime( '1997-12-01T18:27:21-08:00' )
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
                new ezcWebdavDateTime( 'Monday, 12-Jan-98 09:25:56 GMT' )
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
    
    protected static function getFooBarSetup2( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                'file' => ''
            )
        );

        $test->backend->setProperty(
            '/file',
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
            '/file',
            new ezcWebdavDeadProperty(
                'http://www.foo.bar/boxschema/',
                'author',
                <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<R:author xmlns:R="http://www.foo.bar/boxschema/">
<R:Name>J.J. Johnson</R:Name>
</R:author>
EOT
            )
        );

        return $test->backend;
    }
    
    protected static function getFooBarSetup3( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->options->failForRegexp     = '(bar.html)';
        $test->backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_PROPPATCH;
        
        $test->backend->addContents(
            array(
                'bar.html' => ''
            )
        );

        $test->backend->setProperty(
            '/bar.html',
            new ezcWebdavDeadProperty(
                'http://www.w3.com/standards/z39.50',
                'Z:Authors',
                <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<Z:authors xmlns:Z="http://www.w3.com/standards/z39.50">
<Z:author>John Doe</Z:author>
</Z:authors>
EOT
            )
        );

        return $test->backend;
    }

    protected static function getFooBarSetup4( ezcWebdavClientTest $test )
    {
        $test->transport->options->pathFactory = new ezcWebdavPathFactory( 'http://www.foo.bar' );

        $test->backend                             = new ezcWebdavMemoryBackend();
        // $test->backend->options->failForRegexp     = '(container/R2|container/resource3)';
        $test->backend->options->failForRegexp     = '(othercontainer/R2)';
        $test->backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_COPY;

        $test->backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
                    'R2/'         => array(),
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
                new ezcWebdavDateTime( '1997-12-01T17:42:21-08:00' )
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
                new ezcWebdavDateTime( '1997-12-01T18:27:21-08:00' )
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
                new ezcWebdavDateTime( 'Monday, 12-Jan-98 09:25:56 GMT' )
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

    protected static function getFooBarSetup5( ezcWebdavClientTest $test )
    {
        $test->transport->options->pathFactory = new ezcWebdavPathFactory( 'http://www.foo.bar' );

        $test->backend                             = new ezcWebdavMemoryBackend();
        $test->backend->options->failForRegexp     = '(othercontainer/C2)';
        $test->backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_MOVE;

        $test->backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
                    'C2/'         => array(),
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
                new ezcWebdavDateTime( '1997-12-01T17:42:21-08:00' )
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
                new ezcWebdavDateTime( '1997-12-01T18:27:21-08:00' )
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
                new ezcWebdavDateTime( 'Monday, 12-Jan-98 09:25:56 GMT' )
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

    protected static function getIcsUciSetup1( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                '~fielding' => array(
                    'index.html' => '<html><head><title>Foo Bar</title></head></html>',
                ),
            )
        );
        $test->backend->addContents(
            array(
                'users' => array(
                    'f' => array(
                        'fielding' => array(
                            'index.html' => ''
                        )
                    ),
                ),
            )
        );

        $test->backend->setProperty(
            '/~fielding/index.html',
            new ezcWebdavGetContentTypeProperty(
                'text/html', 'utf-8'
            )
        );

        $test->backend->setProperty(
            '/~fielding/index.html',
            new ezcWebdavGetContentLengthProperty(
                '49'
            )
        );

        return $test->backend;
    }

    protected static function getIcsUciSetup2( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                '~fielding' => array(
                    'index.html' => '',
                ),
            )
        );
        $test->backend->addContents(
            array(
                'users' => array(
                    'f' => array(
                        'fielding' => array(
                        )
                    ),
                ),
            )
        );

        return $test->backend;
    }

    protected static function getServerOrgSetup( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                'webdisc' => array(),
            )
        );

        return $test->backend;
    }
}

?>
