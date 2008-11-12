<?php

$emptyLockDiscoveryXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:lockdiscovery xmlns:D='DAV:'/>
EOT;

$emptyLockDiscoveryProperty = new ezcWebdavLockDiscoveryProperty();

$filledLockDiscoveryXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:lockdiscovery xmlns:D='DAV:'>
     <D:activelock>
          <D:locktype><D:write/></D:locktype>
          <D:lockscope><D:exclusive/></D:lockscope>
          <D:depth>0</D:depth>
          <D:owner>Jane Smith</D:owner>
          <D:timeout>Second-600</D:timeout>
          <D:locktoken>
               <D:href>
opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76
               </D:href>
          </D:locktoken>
     </D:activelock>
</D:lockdiscovery>
EOT;

$filledLockDiscoveryProperty = new ezcWebdavLockDiscoveryProperty(
    new ArrayObject(
        array(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent( 'Jane Smith' ),
                600,
                new ezcWebdavPotentialUriContent( 'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76', true )
            ),
        )
    )
);

$filledLockDiscoveryXmlLastAccess = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:lockdiscovery xmlns:D='DAV:' xmlns:ezc="http://ezcomponents.org/s/Webdav#lock">
     <D:activelock>
          <D:locktype><D:write/></D:locktype>
          <D:lockscope><D:exclusive/></D:lockscope>
          <D:depth>0</D:depth>
          <D:owner>Jane Smith</D:owner>
          <D:timeout>Second-600</D:timeout>
          <D:locktoken>
               <D:href>
opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76
               </D:href>
          </D:locktoken>
          <ezc:lastaccess>2008-11-12T22:12:15+01:00</ezc:lastaccess>
     </D:activelock>
</D:lockdiscovery>
EOT;

$filledLockDiscoveryPropertyLastAccess = new ezcWebdavLockDiscoveryProperty(
    new ArrayObject(
        array(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent( 'Jane Smith' ),
                600,
                new ezcWebdavPotentialUriContent( 'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76', true ),
                null,
                new ezcWebdavDateTime( '2008-11-12T22:12:15+01:00' )
            ),
        )
    )
);

$filledLockDiscoveryXmlBaseUri = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:lockdiscovery xmlns:D='DAV:' xmlns:ezc="http://ezcomponents.org/s/Webdav#lock">
     <D:activelock>
          <D:locktype><D:write/></D:locktype>
          <D:lockscope><D:exclusive/></D:lockscope>
          <D:depth>0</D:depth>
          <D:owner>Jane Smith</D:owner>
          <D:timeout>Second-600</D:timeout>
          <D:locktoken>
               <D:href>
opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76
               </D:href>
          </D:locktoken>
          <ezc:baseuri>/some/path</ezc:baseuri>
     </D:activelock>
</D:lockdiscovery>
EOT;

$filledLockDiscoveryPropertyBaseUri = new ezcWebdavLockDiscoveryProperty(
    new ArrayObject(
        array(
            new ezcWebdavLockDiscoveryPropertyActiveLock(
                ezcWebdavLockRequest::TYPE_WRITE,
                ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                ezcWebdavRequest::DEPTH_ZERO,
                new ezcWebdavPotentialUriContent( 'Jane Smith' ),
                600,
                new ezcWebdavPotentialUriContent( 'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76', true ),
                '/some/path'
            ),
        )
    )
);

$emptySupportedLockXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:supportedlock xmlns:D="DAV:" />
EOT;

$emptySupportedLockProperty = new ezcWebdavSupportedLockProperty();

$filledSupportedLockXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<D:supportedlock xmlns:D="DAV:">
     <D:lockentry>
          <D:lockscope><D:exclusive/></D:lockscope>
          <D:locktype><D:write/></D:locktype>
     </D:lockentry>
     <D:lockentry>
          <D:lockscope><D:shared/></D:lockscope>
          <D:locktype><D:write/></D:locktype>
     </D:lockentry>
</D:supportedlock>
EOT;

$filledSupportedLockProperty = new ezcWebdavSupportedLockProperty(
    new ArrayObject(
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

return array(
    array(
        $emptyLockDiscoveryXml,
        $emptyLockDiscoveryProperty,
    ),
    array(
        $filledLockDiscoveryXml,
        $filledLockDiscoveryProperty,
    ),
    array(
        $filledLockDiscoveryXmlLastAccess,
        $filledLockDiscoveryPropertyLastAccess,
    ),
    array(
        $filledLockDiscoveryXmlBaseUri,
        $filledLockDiscoveryPropertyBaseUri,
    ),
    array(
        $emptySupportedLockXml,
        $emptySupportedLockProperty,
    ),
    array(
        $filledSupportedLockXml,
        $filledSupportedLockProperty,
    )
);

?>
