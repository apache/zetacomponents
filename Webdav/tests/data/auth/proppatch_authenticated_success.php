<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'         => '/b/b2',
            'REQUEST_METHOD'      => 'PROPPATCH',
            // foo:bar
            'HTTP_AUTHORIZATION'  => 'Basic Zm9vOmJhcg==',
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
        'status' => 'HTTP/1.1 200 OK',
        'headers' => array(
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Length' => '0',
        ),
        'body' => '',
    ),
);

?>
