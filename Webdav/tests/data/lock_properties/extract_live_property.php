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
                'Jane Smith',
                600,
                new ArrayObject( array( 'opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76' ) )
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

$emptyLockInfoProperty = new ezcWebdavLockInfoProperty();

$emptyLockInfoXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<ezc:lockinfo xmlns:D="DAV:" xmlns:ezc="http://ezcomponents.org/s/Webdav#lock" />
EOT;

$filledLockInfoProperty = new ezcWebdavLockInfoProperty();

$filledLockInfoXml = <<<EOT
<?xml version="1.0" encoding="utf-8" ?>
<ezclock:lockinfo xmlns:D="DAV:" xmlns:ezc="http://ezcomponents.org/s/Webdav#lock" />
    <ezclock:null />
    <ezclock:tokeninfo>
        <ezclock:token>opaquelocktoken:abc</ezclock:token>
        <ezclock:lockbase>/path/to/lock/base</ezclock:lockbase>
    </ezclock:tokeninfo>
    <ezclock:tokeninfo>
        <ezclock:token>opaquelocktoken:def</ezclock:token>
        <ezclock:lastaccess>2008-10-12T15:19:21+00:00</ezclock:lastaccess>
    </ezclocktokeninfo>
</ezclock:lockinfo>
EOT;

return array(
    array(
        $emptyLockDiscoveryXml,
        $emptyLockDiscoveryProperty,
        true, // Live property
    ),
    array(
        $filledLockDiscoveryXml,
        $filledLockDiscoveryProperty,
        true, // Live property
    ),
    array(
        $emptySupportedLockXml,
        $emptySupportedLockProperty,
        true, // Live property
    ),
    array(
        $filledSupportedLockXml,
        $filledSupportedLockProperty,
        true, // Live property
    ),
    array(
        $emptyLockInfoXml,
        $emptyLockInfoProperty,
        false, // Dead property
    ),
);

?>
