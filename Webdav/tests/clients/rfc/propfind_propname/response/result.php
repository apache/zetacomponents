<?php
return array (
  'headers' => 
  array (
    0 => 'HTTP/1.1 204 No Content',
    1 => 'HTTP/1.1 207 Multi-Status',
    2 => 'HTTP/1.1 412 Precondition Failed',
    3 => 'HTTP/1.1 204 No Content',
    4 => 'HTTP/1.1 423 Locked',
    5 => 'HTTP/1.1 207 Multi-Status',
    6 => 'HTTP/1.1 207 Multi-Status',
    7 => 'HTTP/1.1 207 Multi-Status',
    8 => 'HTTP/1.1 207 Multi-Status',
    9 => 'HTTP/1.1 207 Multi-Status',
  ),
  'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:"><D:repsonse xmlns:ezc00000="http://www.foo.bar/boxschema/"><D:href>http://foo.bar/container</D:href><D:propstat xmlns:ezc00000="http://www.foo.bar/boxschema/"><D:prop><ezc00000:bigbox xmlns:ezc00000="http://www.foo.bar/boxschema/"/><ezc00000:author xmlns:ezc00000="http://www.foo.bar/boxschema/"/><D:creationdate/><D:displayname/><D:resourcetype/><D:supportedlock/></D:prop><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse xmlns:ezc00000="http://www.foo.bar/boxschema/"><D:href>http://foo.bar/container/front.html</D:href><D:propstat xmlns:ezc00000="http://www.foo.bar/boxschema/"><D:prop><ezc00000:bigbox xmlns:ezc00000="http://www.foo.bar/boxschema/"/><D:creationdate/><D:displayname/><D:getcontentlength/><D:getcontenttype/><D:getetag/><D:getlastmodified/><D:resourcetype/><D:supportedlock/></D:prop><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse><D:href>http://foo.bar/container/R2</D:href><D:propstat><D:prop/><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse><D:href>http://foo.bar/container/resource3</D:href><D:propstat><D:prop/><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse></D:multistatus>
',
);
?>