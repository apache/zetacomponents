<?php

require_once 'client_test_setup.php';

class ezcWebdavClientTestRfcSetup extends ezcWebdavClientTestSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $pathFactory  = new ezcWebdavBasicPathFactory( 'http://www.foo.bar' );

        $testSetName = basename( $testSetName );
        switch( $testSetName )
        {
            case '014_propfind_propname':
            case 'lockdiscovery':
            case 'supportedlock':
            case '012_propfind_allprop':
            case '005_delete':
                $customPathFactory = self::getFooBarSetup1( $test );
                break;
            case '013_propfind_prop':
                $customPathFactory = self::getFooBarSetup2( $test );
                break;
            case '015_proppatch':
                $customPathFactory = self::getFooBarSetup3( $test );
                break;
            case '002_copy_collection':
                $customPathFactory = self::getFooBarSetup4( $test );
                break;
            case '009_move_collection':
                $customPathFactory = self::getFooBarSetup5( $test );
                break;
            case '004_copy_success':
            case '001_copy':
            case '003_copy_overwrite':
            case '011_options':
            case '006_get_collection':
            case '007_get_resource':
            case '016_put_resource':
                $customPathFactory = self::getIcsUciSetup1( $test );
                break;
            case '010_move_resource':
                $customPathFactory = self::getIcsUciSetup2( $test );
                break;
            case '008_mkcol':
                $customPathFactory = self::getServerOrgSetup( $test );
                break;
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }

        $test->server = self::getServer( ( $customPathFactory === null ? $pathFactory : $customPathFactory ) );
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
    }

    protected static function getFooBarSetup4( ezcWebdavClientTest $test )
    {

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

        return new ezcWebdavBasicPathFactory( 'http://www.foo.bar' );
    }

    protected static function getFooBarSetup5( ezcWebdavClientTest $test )
    {
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

        return new ezcWebdavBasicPathFactory( 'http://www.foo.bar' );
    }

    protected static function getIcsUciSetup1( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                '~fielding' => array(
                    'index.html' => "<html><head><title>Foo Bar</title></head></html>\n",
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
    }

    protected static function getServerOrgSetup( ezcWebdavClientTest $test )
    {
        $test->backend = new ezcWebdavMemoryBackend();
        $test->backend->addContents(
            array(
                'webdisc' => array(),
            )
        );
    }
}

?>
