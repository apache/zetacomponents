<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'    => '/b/b2',
            'REQUEST_METHOD' => 'PROPPATCH',
        ),
        'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"
xmlns:Z="http://www.w3.com/standards/z39.50/">
  <D:set>
       <D:prop>
            <Z:authors>
                 <Z:Author>Jim Whitehead</Z:Author>
                 <Z:Author>Roy Fielding</Z:Author>
            </Z:authors>
       </D:prop>
  </D:set>
  <D:remove>
       <D:prop><Z:Copyright-Owner/></D:prop>
  </D:remove>
</D:propertyupdate>
        ',
    ),
    array(
        'status' => 'HTTP/1.1 207 Multi-Status',
        'headers' => array(
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'   => 'text/xml; charset="utf-8"',
        ),
        'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/b/b2</D:href>
  <D:propstat xmlns:ezc00000="http://www.w3.com/standards/z39.50/">
    <D:prop>
      <ezc00000:authors xmlns:ezc00000="http://www.w3.com/standards/z39.50/"/>
      <ezc00000:Copyright-Owner xmlns:ezc00000="http://www.w3.com/standards/z39.50/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
    ),
);

?>
