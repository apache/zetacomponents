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
  ),
  'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:"><D:repsonse xmlns:R="http://www.foo.bar/boxschema/"><D:href>http://foo.bar/container</D:href><D:propstat xmlns:R="http://www.foo.bar/boxschema/"><D:prop><R:bigbox xmlns:R="http://www.foo.bar/boxschema/"><R:BoxType>Box type A</R:BoxType></R:bigbox><R:author xmlns:R="http://www.foo.bar/boxschema/"><R:Name>Hadrian</R:Name></R:author><D:creationdate>1997-12-01T17:42:21-0800</D:creationdate><D:displayname>Example collection</D:displayname><D:resourcetype/><D:supportedlock><D:lockentry><D:lockscope><D:exclusive/></D:lockscope><D:locktype><D:write/></D:locktype></D:lockentry><D:lockentry><D:lockscope><D:shared/></D:lockscope><D:locktype><D:read/></D:locktype></D:lockentry></D:supportedlock></D:prop><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse xmlns:R="http://www.foo.bar/boxschema/"><D:href>http://foo.bar/container/front.html</D:href><D:propstat xmlns:R="http://www.foo.bar/boxschema/"><D:prop><R:bigbox xmlns:R="http://www.foo.bar/boxschema/"><R:BoxType>Box type B</R:BoxType></R:bigbox><D:creationdate>1997-12-01T18:27:21-0800</D:creationdate><D:displayname>Example HTML resource</D:displayname><D:getcontentlength>4525</D:getcontentlength><D:getcontenttype>text/html</D:getcontenttype><D:getetag>zzyzx</D:getetag><D:getlastmodified>1998-01-12T09:25:56+0000</D:getlastmodified><D:resourcetype/><D:supportedlock><D:lockentry><D:lockscope><D:exclusive/></D:lockscope><D:locktype><D:write/></D:locktype></D:lockentry><D:lockentry><D:lockscope><D:shared/></D:lockscope><D:locktype><D:read/></D:locktype></D:lockentry></D:supportedlock></D:prop><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse><D:href>http://foo.bar/container/R2</D:href><D:propstat><D:prop/><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse><D:repsonse><D:href>http://foo.bar/container/resource3</D:href><D:propstat><D:prop/><D:status>HTTP/1.1 200 OK</D:status></D:propstat></D:repsonse></D:multistatus>
',
);
?>