<?php

class ezcWebdavClientRfcTestBackend
{
    public static function getSetup( $testSetName )
    {
        switch( $testSetName )
        {
            case 'propfind_propname':
            case 'lockdiscovery':
            case 'supportedlock':
            case 'propfind_allprop':
            case 'move_collection':
            case 'copy_collection':
            case 'delete':
                return self::getFooBarSetup1();
            case 'propfind_prop':
                return self::getFooBarSetup2();
            case 'proppatch':
                return self::getFooBarSetup3();
            case 'copy_success':
            case 'copy':
            case 'copy_overwrite':
            case 'options':
            case 'get_collection':
            case 'get_resource':
                return self::getIcsUciSetup1();
            case 'move_resource':
                return self::getIcsUciSetup2();
            case 'mkcol':
                return self::getServerOrgSetup();
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }
    }

    protected static function getFooBarSetup1()
    {
        $backend                             = new ezcWebdavMemoryBackend();
        // $backend->options->failForRegexp     = '(container/R2|container/resource3)';
        $backend->options->failForRegexp     = '(container)';
        $backend->options->failingOperations = ezcWebdavMemoryBackendOptions::REQUEST_COPY | ezcWebdavMemoryBackendOptions::REQUEST_DELETE;

        $backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
                    'R2'         => array(),
                    'resource3'  => '',
                ),
            )
        );

        $backend->setProperty(
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
        $backend->setProperty(
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
        $backend->setProperty(
            '/container',
            new ezcWebdavCreationDateProperty(
                new DateTime( '1997-12-01T17:42:21-08:00' )
            )
        );
        $backend->setProperty(
            '/container',
            new ezcWebdavDisplayNameProperty(
                'Example collection'
            )
        );
        $backend->setProperty(
            '/container',
            new ezcWebdavResourceTypeProperty(
                'collection'
            )
        );
        $backend->setProperty(
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

        $backend->setProperty(
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
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavCreationDateProperty(
                new DateTime( '1997-12-01T18:27:21-08:00' )
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavDisplayNameProperty(
                'Example HTML resource'
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentLengthProperty(
                '4525'
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetContentTypeProperty(
                'text/html'
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetEtagProperty(
                'zzyzx'
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavGetLastModifiedProperty(
                new DateTime( 'Monday, 12-Jan-98 09:25:56 GMT' )
            )
        );
        $backend->setProperty(
            '/container/front.html',
            new ezcWebdavResourceTypeProperty()
        );
        $backend->setProperty(
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

        return $backend;
    }
    
    protected static function getFooBarSetup2()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                'file' => ''
            )
        );

        $backend->setProperty(
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
        $backend->setProperty(
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

        return $backend;
    }
    
    protected static function getFooBarSetup3()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                'bar.html' => ''
            )
        );

        $backend->setProperty(
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

        return $backend;
    }

    protected static function getIcsUciSetup1()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                '~fielding' => array(
                    'index.html' => '<html><head><title>Foo Bar</title></head></html>',
                ),
            )
        );
        $backend->addContents(
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

        $backend->setProperty(
            '/~fielding/index.html',
            new ezcWebdavGetContentTypeProperty(
                'text/html', 'utf-8'
            )
        );

        $backend->setProperty(
            '/~fielding/index.html',
            new ezcWebdavGetContentLengthProperty(
                '49'
            )
        );

        return $backend;
    }

    protected static function getIcsUciSetup2()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                '~fielding' => array(
                    'index.html' => '',
                ),
            )
        );
        $backend->addContents(
            array(
                'users' => array(
                    'f' => array(
                        'fielding' => array(
                        )
                    ),
                ),
            )
        );

        return $backend;
    }

    protected static function getServerOrgSetup()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                'webdisc' => array(),
            )
        );

        return $backend;
    }
}

?>
