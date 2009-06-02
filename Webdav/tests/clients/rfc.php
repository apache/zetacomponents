<?php
return array (
  1 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'COPY',
        'REQUEST_URI' => '/~fielding/index.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
        'HTTP_DESTINATION' => 'http://www.ics.uci.edu/users/f/fielding/index.html',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  2 => 
  array (
    'collection' => 
    array (
      'description' => '>>Request

COPY /container/ HTTP/1.1
Host: www.foo.bar
Destination: http://www.foo.bar/othercontainer/
Depth: infinity
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:keepalive>*</d:keepalive>
</d:propertybehavior>

>>Response

HTTP/1.1 207 Multi-Status
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<d:multistatus xmlns:d="DAV:">
  <d:response>
       <d:href>http://www.foo.bar/othercontainer/R2/</d:href>
       <d:status>HTTP/1.1 412 Precondition Failed</d:status>
  </d:response>
</d:multistatus>

',
    ),
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d="DAV:">
  <d:keepalive>*</d:keepalive>
</d:propertybehavior>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'COPY',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'HTTP_DESTINATION' => 'http://www.foo.bar/othercontainer/',
        'HTTP_DEPTH' => 'infinity',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://www.foo.bar/othercontainer/R2/</D:href>
    <D:status>HTTP/1.1 412 Precondition Failed</D:status>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  3 => 
  array (
    'overwrite' => 
    array (
      'description' => '>>Request

COPY /~fielding/index.html HTTP/1.1
Host: www.ics.uci.edu
Destination: http://www.ics.uci.edu/users/f/fielding/index.html
Overwrite: F

>>Response

HTTP/1.1 412 Precondition Failed

',
    ),
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'COPY',
        'REQUEST_URI' => '/~fielding/index.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
        'HTTP_DESTINATION' => 'http://www.ics.uci.edu/users/f/fielding/index.html',
        'HTTP_OVERWRITE' => 'F',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  4 => 
  array (
    'success' => 
    array (
      'description' => '>>Request

COPY /~fielding/index.html HTTP/1.1
Host: www.ics.uci.edu
Destination: http://www.ics.uci.edu/users/f/fielding/index.html

>>Response

HTTP/1.1 204 No Content

',
    ),
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'COPY',
        'REQUEST_URI' => '/~fielding/index.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
        'HTTP_DESTINATION' => 'http://www.ics.uci.edu/users/f/fielding/index.html',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  5 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'DELETE',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://www.foo.bar/container/resource3</D:href>
    <D:status>HTTP/1.1 423 Locked</D:status>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  6 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/~fielding',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Content-Length' => '4096',
        'ETag' => '89637f586f72a744fc0692a7eb9076e2',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  7 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'GET',
        'REQUEST_URI' => '/~fielding/index.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
      ),
    ),
    'response' => 
    array (
      'body' => '<html><head><title>Foo Bar</title></head></html>
',
      'headers' => 
      array (
        'ETag' => '5ed4bd36ad87f04d473460f7ea1a9223',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/html; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  8 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'MKCOL',
        'REQUEST_URI' => '/webdisc/xfiles/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.server.org',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  9 => 
  array (
    'collection' => 
    array (
      'description' => '>>Request

MOVE /container/ HTTP/1.1
Host: www.foo.bar
Destination: http://www.foo.bar/othercontainer/
Overwrite: F
If: (<opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4>)
    (<opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77>)
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d=\'DAV:\'>
  <d:keepalive>*</d:keepalive>
</d:propertybehavior>

>>Response

HTTP/1.1 207 Multi-Status
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<d:multistatus xmlns:d=\'DAV:\'>
  <d:response>
       <d:href>http://www.foo.bar/othercontainer/C2/</d:href>
       <d:status>HTTP/1.1 423 Locked</d:status>
  </d:response>
</d:multistatus>

',
    ),
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<d:propertybehavior xmlns:d=\'DAV:\'>
  <d:keepalive>*</d:keepalive>
</d:propertybehavior>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'MOVE',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'HTTP_DESTINATION' => 'http://www.foo.bar/othercontainer/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_IF' => '(<opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4>)  (<opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77>)',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://www.foo.bar/othercontainer/C2/</D:href>
    <D:status>HTTP/1.1 412 Precondition Failed</D:status>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  10 => 
  array (
    'resource' => 
    array (
      'description' => '>>Request

MOVE /~fielding/index.html HTTP/1.1
Host: www.ics.uci.edu
Destination: http://www.ics.uci.edu/users/f/fielding/index.html

>>Response

HTTP/1.1 201 Created
Location: http://www.ics.uci.edu/users/f/fielding/index.html

',
    ),
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'MOVE',
        'REQUEST_URI' => '/~fielding/index.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
        'HTTP_DESTINATION' => 'http://www.ics.uci.edu/users/f/fielding/index.html',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  11 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'OPTIONS',
        'REQUEST_URI' => '/~fielding',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'DAV' => '1',
        'Allow' => 'GET, HEAD, PROPFIND, PROPPATCH, OPTIONS, DELETE, COPY, MOVE, MKCOL, PUT',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  12 => 
  array (
    'allprop' => 
    array (
      'description' => '>>Request

PROPFIND  /container/ HTTP/1.1
Host: www.foo.bar
Depth: 1
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:allprop/>
</D:propfind>

>>Response

HTTP/1.1 207 Multi-Status
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
       <D:href>http://www.foo.bar/container/</D:href>
       <D:propstat>
            <D:prop xmlns:R="http://www.foo.bar/boxschema/">
                 <R:bigbox>
                      <R:BoxType>Box type A</R:BoxType>
                 </R:bigbox>
                 <R:author>
                      <R:Name>Hadrian</R:Name>
                 </R:author>
                 <D:creationdate>
                      1997-12-01T17:42:21-08:00
                 </D:creationdate>
                 <D:displayname>
                      Example collection
                 </D:displayname>
                 <D:resourcetype><D:collection/></D:resourcetype>
                 <D:supportedlock>
                      <D:lockentry>
                           <D:lockscope><D:exclusive/></D:lockscope>
                           <D:locktype><D:write/></D:locktype>
                      </D:lockentry>
                      <D:lockentry>
                           <D:lockscope><D:shared/></D:lockscope>
                           <D:locktype><D:write/></D:locktype>
                      </D:lockentry>
                 </D:supportedlock>
            </D:prop>
            <D:status>HTTP/1.1 200 OK</D:status>
       </D:propstat>
  </D:response>
  <D:response>
       <D:href>http://www.foo.bar/container/front.html</D:href>
       <D:propstat>
            <D:prop xmlns:R="http://www.foo.bar/boxschema/">
                 <R:bigbox>
                      <R:BoxType>Box type B</R:BoxType>
                 </R:bigbox>
                 <D:creationdate>
                      1997-12-01T18:27:21-08:00
                 </D:creationdate>
                 <D:displayname>
                      Example HTML resource
                 </D:displayname>
                 <D:getcontentlength>
                      4525
                 </D:getcontentlength>
                 <D:getcontenttype>
                      text/html
                 </D:getcontenttype>
                 <D:getetag>
                      zzyzx
                 </D:getetag>
                 <D:getlastmodified>
                      Monday, 12-Jan-98 09:25:56 GMT
                 </D:getlastmodified>
                 <D:resourcetype/>
                 <D:supportedlock>
                      <D:lockentry>
                           <D:lockscope><D:exclusive/></D:lockscope>
                           <D:locktype><D:write/></D:locktype>
                      </D:lockentry>
                      <D:lockentry>
                           <D:lockscope><D:shared/></D:lockscope>
                           <D:locktype><D:write/></D:locktype>
                      </D:lockentry>
                 </D:supportedlock>
            </D:prop>
            <D:status>HTTP/1.1 200 OK</D:status>
       </D:propstat>
  </D:response>
</D:multistatus>

',
    ),
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:allprop/>
</D:propfind>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPFIND',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'HTTP_DEPTH' => '1',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:R="http://www.foo.bar/boxschema/">
    <D:href>http://www.foo.bar/container/</D:href>
    <D:propstat xmlns:R="http://www.foo.bar/boxschema/">
      <D:prop>
        <D:creationdate>1997-12-01T17:42:21-0800</D:creationdate>
        <D:displayname>Example collection</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>httpd/unix-directory</D:getcontenttype>
        <D:getetag>e81e84d5197f72cd038aa2a768d15247</D:getetag>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype/>
        <R:bigbox xmlns:R="http://www.foo.bar/boxschema/">
          <R:BoxType>Box type A</R:BoxType>
        </R:bigbox>
        <R:author xmlns:R="http://www.foo.bar/boxschema/">
          <R:Name>Hadrian</R:Name>
        </R:author>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:R="http://www.foo.bar/boxschema/">
    <D:href>http://www.foo.bar/container/front.html</D:href>
    <D:propstat xmlns:R="http://www.foo.bar/boxschema/">
      <D:prop>
        <D:creationdate>1997-12-01T18:27:21-0800</D:creationdate>
        <D:displayname>Example HTML resource</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>text/html</D:getcontenttype>
        <D:getetag>zzyzx</D:getetag>
        <D:getlastmodified>Mon, 12 Jan 1998 09:25:56 +0000</D:getlastmodified>
        <D:getcontentlength>4525</D:getcontentlength>
        <D:resourcetype/>
        <R:bigbox xmlns:R="http://www.foo.bar/boxschema/">
          <R:BoxType>Box type B</R:BoxType>
        </R:bigbox>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://www.foo.bar/container/R2</D:href>
    <D:propstat>
      <D:prop>
        <D:creationdate>2003-05-27T11:27:00+0000</D:creationdate>
        <D:displayname>R2</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>httpd/unix-directory</D:getcontenttype>
        <D:getetag>08f842b302fbfbfde8049178085e6972</D:getetag>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://www.foo.bar/container/resource3</D:href>
    <D:propstat>
      <D:prop>
        <D:creationdate>2003-05-27T11:27:00+0000</D:creationdate>
        <D:displayname>resource3</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>application/octet-stream</D:getcontenttype>
        <D:getetag>a952a3dcd83383fc7dbacee5f21106cb</D:getetag>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>0</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  13 => 
  array (
    'prop' => 
    array (
      'description' => '>>Request

PROPFIND  /file HTTP/1.1
Host: www.foo.bar
Content-type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:prop xmlns:R="http://www.foo.bar/boxschema/">
       <R:bigbox/>
       <R:author/>
       <R:DingALing/>
       <R:Random/>
  </D:prop>
</D:propfind>

>>Response

HTTP/1.1 207 Multi-Status
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
       <D:href>http://www.foo.bar/file</D:href>
       <D:propstat>
            <D:prop xmlns:R="http://www.foo.bar/boxschema/">
                 <R:bigbox>
                      <R:BoxType>Box type A</R:BoxType>
                 </R:bigbox>
                 <R:author>
                      <R:Name>J.J. Johnson</R:Name>
                 </R:author>
            </D:prop>
            <D:status>HTTP/1.1 200 OK</D:status>
       </D:propstat>
       <D:propstat>
            <D:prop><R:DingALing/><R:Random/></D:prop>
            <D:status>HTTP/1.1 403 Forbidden</D:status>
            <D:responsedescription> The user does not have access to
the DingALing property.
            </D:responsedescription>
       </D:propstat>
  </D:response>
  <D:responsedescription> There has been an access violation error.
  </D:responsedescription>
</D:multistatus>
',
    ),
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:prop xmlns:R="http://www.foo.bar/boxschema/">
       <R:bigbox/>
       <R:author/>
       <R:DingALing/>
       <R:Random/>
  </D:prop>
</D:propfind>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPFIND',
        'REQUEST_URI' => '/file',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:R="http://www.foo.bar/boxschema/">
    <D:href>http://www.foo.bar/file</D:href>
    <D:propstat xmlns:R="http://www.foo.bar/boxschema/">
      <D:prop>
        <R:bigbox xmlns:R="http://www.foo.bar/boxschema/">
          <R:BoxType>Box type A</R:BoxType>
        </R:bigbox>
        <R:author xmlns:R="http://www.foo.bar/boxschema/">
          <R:Name>J.J. Johnson</R:Name>
        </R:author>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:R="http://www.foo.bar/boxschema/">
      <D:prop>
        <R:DingALing xmlns:R="http://www.foo.bar/boxschema/"/>
        <R:Random xmlns:R="http://www.foo.bar/boxschema/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  14 => 
  array (
    'propname' => 
    array (
      'description' => '>>Request

PROPFIND  /container/ HTTP/1.1
Host: www.foo.bar
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<propfind xmlns="DAV:">
  <propname/>
</propfind>

>>Response

HTTP/1.1 207 Multi-Status
Content-Type: text/xml; charset="utf-8"
Content-Length: xxxx

<?xml version="1.0" encoding="utf-8" ?>
<multistatus xmlns="DAV:">
  <response>
       <href>http://www.foo.bar/container/</href>
       <propstat>
            <prop xmlns:R="http://www.foo.bar/boxschema/">
                 <R:bigbox/>
                 <R:author/>
                 <creationdate/>
                 <displayname/>
                 <resourcetype/>
                 <supportedlock/>
            </prop>
            <status>HTTP/1.1 200 OK</status>
       </propstat>
  </response>
  <response>
       <href>http://www.foo.bar/container/front.html</href>
       <propstat>
            <prop xmlns:R="http://www.foo.bar/boxschema/">
                 <R:bigbox/>
                 <creationdate/>
                 <displayname/>
                 <getcontentlength/>
                 <getcontenttype/>
                 <getetag/>
                 <getlastmodified/>
                 <resourcetype/>
                 <supportedlock/>
            </prop>
            <status>HTTP/1.1 200 OK</status>
       </propstat>
  </response>
</multistatus>
',
    ),
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<propfind xmlns="DAV:">
  <propname/>
</propfind>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPFIND',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:ezc00000="http://www.foo.bar/boxschema/">
    <D:href>http://www.foo.bar/container/</D:href>
    <D:propstat xmlns:ezc00000="http://www.foo.bar/boxschema/">
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
        <ezc00000:bigbox xmlns:ezc00000="http://www.foo.bar/boxschema/"/>
        <ezc00000:author xmlns:ezc00000="http://www.foo.bar/boxschema/"/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:ezc00000="http://www.foo.bar/boxschema/">
    <D:href>http://www.foo.bar/container/front.html</D:href>
    <D:propstat xmlns:ezc00000="http://www.foo.bar/boxschema/">
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
        <ezc00000:bigbox xmlns:ezc00000="http://www.foo.bar/boxschema/"/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://www.foo.bar/container/R2</D:href>
    <D:propstat>
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://www.foo.bar/container/resource3</D:href>
    <D:propstat>
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  15 => 
  array (
    'request' => 
    array (
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
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPPATCH',
        'REQUEST_URI' => '/bar.html',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.com',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:Z="http://www.w3.com/standards/z39.50/">
    <D:href>http://www.foo.bar/bar.html</D:href>
    <D:propstat xmlns:Z="http://www.w3.com/standards/z39.50/">
      <D:prop>
        <Z:authors xmlns:Z="http://www.w3.com/standards/z39.50/">
          <Z:Author>Jim Whitehead</Z:Author>
          <Z:Author>Roy Fielding</Z:Author>
        </Z:authors>
      </D:prop>
      <D:status>HTTP/1.1 403 Forbidden</D:status>
    </D:propstat>
    <D:propstat xmlns:Z="http://www.w3.com/standards/z39.50/">
      <D:prop>
        <Z:Copyright-Owner xmlns:Z="http://www.w3.com/standards/z39.50/"/>
      </D:prop>
      <D:status>HTTP/1.1 424 Failed Dependency</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  16 => 
  array (
    'request' => 
    array (
      'body' => 'Test text to put
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PUT',
        'REQUEST_URI' => '/~fielding/upload.txt',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.ics.uci.edu',
        'CONTENT_TYPE' => 'text/plain; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '17',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '0546b17485ca927ea9a56c5cb6b8d8ac',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => '0',
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
);
?>