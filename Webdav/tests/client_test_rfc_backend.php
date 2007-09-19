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
                return self::getFooBarSetup();
            default:
                throw new RuntimeException( "Could not find setup for test set '$testSetName'." );
        }
    }

    protected static function getFooBarSetup()
    {
        $backend = new ezcWebdavMemoryBackend();
        $backend->addContents(
            array(
                'container' => array(
                    'front.html' => '',
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
}

?>
