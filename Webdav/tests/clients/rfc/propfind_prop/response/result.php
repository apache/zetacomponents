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
  ),
  'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:"><D:repsonse xmlns:R="http://www.foo.bar/boxschema/"><D:href>http://foo.bar/file</D:href><D:propstat xmlns:R="http://www.foo.bar/boxschema/"><D:prop><R:bigbox xmlns:R="http://www.foo.bar/boxschema/"/><R:author xmlns:R="http://www.foo.bar/boxschema/"/></D:prop><D:status>HTTP/1.1 200 OK</D:status></D:propstat><D:propstat xmlns:R="http://www.foo.bar/boxschema/"><D:prop><R:DingALing xmlns:R="http://www.foo.bar/boxschema/"/><R:Random xmlns:R="http://www.foo.bar/boxschema/"/></D:prop><D:status>HTTP/1.1 404 Not Found</D:status></D:propstat></D:repsonse></D:multistatus>
',
);
?>