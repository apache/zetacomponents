<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'    => '/c/c2',
            'REQUEST_METHOD' => 'PROPFIND',
            'HTTP_DEPTH'     => '1',
            'CONTENT_TYPE'   => 'text/xml; charset="utf-8"',
            'HTTP_CONTENT_LENGTH' => '1234',
        ),
        'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:allprop/>
</D:propfind>',
    ),
    array(
        'status' => 'HTTP/1.1 207 Multi-Status',
        'headers' => array(
            'Content-Type' => 'text/xml; charset="utf-8"',
            'Server'       => 'eZComponents/dev/ezcWebdavTransportTestMock',
        ),
       'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/c/c2</D:href>
    <D:propstat>
      <D:prop>
        <D:creationdate>2003-05-27T11:27:00+0000</D:creationdate>
        <D:displayname>c2</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>application/octet-stream</D:getcontenttype>
        <D:getetag>68ac210a7de0bf83cc80b339c67dbf4c</D:getetag>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>2</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
    ),
);

?>
