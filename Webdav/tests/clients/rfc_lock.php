<?php
return array (
  1 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:lockinfo xmlns:D=\'DAV:\'>
  <D:lockscope><D:exclusive/></D:lockscope>
  <D:locktype><D:write/></D:locktype>
  <D:owner>
       <D:href>http://example.com/~ejw/contact.html</D:href>
  </D:owner>
</D:lockinfo>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'LOCK',
        'REQUEST_URI' => '/workspace/webdav/proposal.doc',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'example.com',
        'HTTP_TIMEOUT' => 'Infinite, Second-4100000000',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
        'HTTP_AUTH' => 'Digest username="ejw", realm="ejw@example.com", nonce="...", uri="/workspace/webdav/proposal.doc", response="...", opaque="..."',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:prop xmlns:D="DAV:">
  <D:lockdiscovery>
    <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:locktype>
        <D:write/>
      </D:locktype>
      <D:lockscope>
        <D:exclusive/>
      </D:lockscope>
      <D:depth>Infinity</D:depth>
      <D:owner>
        <D:href>http://example.com/~ejw/contact.html</D:href>
      </D:owner>
      <D:timeout>Second-604800</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-10T00:16:47+00:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4',
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  2 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'LOCK',
        'REQUEST_URI' => '/workspace/webdav/proposal.doc',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'example.com',
        'HTTP_TIMEOUT' => 'Infinite, Second-40',
        'HTTP_IF' => '(<opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4>)',
        'HTTP_AUTH' => 'Digest username="ejw", realm="ejw@example.com", nonce="...", uri="/workspace/webdav/proposal.doc", response="...", opaque="..."',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:prop xmlns:D="DAV:">
  <D:lockdiscovery>
    <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:locktype>
        <D:write/>
      </D:locktype>
      <D:lockscope>
        <D:exclusive/>
      </D:lockscope>
      <D:depth>Infinity</D:depth>
      <D:owner>
        <D:href>http://example.com/~ejw/contact.html</D:href>
      </D:owner>
      <D:timeout>Second-40</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:e71d4fae-5dec-22d6-fea5-00a0c91e6be4</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T22:14:18+00:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  3 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:lockinfo xmlns:D="DAV:">
  <D:locktype><D:write/></D:locktype>
  <D:lockscope><D:exclusive/></D:lockscope>
  <D:owner>
       <D:href>http://example.com/~ejw/contact.html</D:href>
  </D:owner>
</D:lockinfo>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'LOCK',
        'REQUEST_URI' => '/webdav/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'example.com',
        'HTTP_TIMEOUT' => 'Infinite, Second-4100000000',
        'HTTP_DEPTH' => 'infinity',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
        'HTTP_AUTH' => 'Digest username="ejw", realm="ejw@example.com", nonce="...", uri="/workspace/webdav/proposal.doc", response="...", opaque="..."',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://example.com/webdav/secret</D:href>
    <D:status>HTTP/1.1 403 Forbidden</D:status>
  </D:response>
  <D:response>
    <D:href>http://example.com/webdav/</D:href>
    <D:status>HTTP/1.1 424 Failed Dependency</D:status>
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
  4 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D=\'DAV:\'>
  <D:prop><D:lockdiscovery/></D:prop>
</D:propfind>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPFIND',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'HTTP_CONTENT_LENGTH' => '1234',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://example.com/container/</D:href>
    <D:propstat>
      <D:prop>
        <D:lockdiscovery>
          <D:activelock>
            <D:locktype>
              <D:write/>
            </D:locktype>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:depth>0</D:depth>
            <D:owner>Jane Smith</D:owner>
            <D:timeout>Second-40</D:timeout>
            <D:locktoken>
              <D:href>opaquelocktoken:f81de2ad-7f3d-a1b2-4f3c-00a0c91a9d76</D:href>
            </D:locktoken>
          </D:activelock>
        </D:lockdiscovery>
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
  5 => 
  array (
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
        'HTTP_DESTINATION' => 'http://example.com/othercontainer/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_IF' => '(<opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4>)  (<opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77>)',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
        'HTTP_CONTENT_LENGTH' => '1234',
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  6 => 
  array (
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
  <D:response xmlns:R="http://ns.example.com/boxschema/">
    <D:href>http://example.com/container/</D:href>
    <D:propstat xmlns:R="http://ns.example.com/boxschema/">
      <D:prop>
        <D:creationdate>1997-12-01T17:42:21-0800</D:creationdate>
        <D:displayname>Example collection</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>httpd/unix-directory</D:getcontenttype>
        <D:getetag>e81e84d5197f72cd038aa2a768d15247</D:getetag>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype/>
        <R:bigbox xmlns:R="http://ns.example.com/boxschema/">
          <R:BoxType>Box type A</R:BoxType>
        </R:bigbox>
        <R:author xmlns:R="http://ns.example.com/boxschema/">
          <R:Name>Hadrian</R:Name>
        </R:author>
        <D:lockdiscovery/>
        <D:supportedlock>
          <D:lockentry>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
          <D:lockentry>
            <D:lockscope>
              <D:shared/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
        </D:supportedlock>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:R="http://ns.example.com/boxschema/">
    <D:href>http://example.com/container/front.html</D:href>
    <D:propstat xmlns:R="http://ns.example.com/boxschema/">
      <D:prop>
        <D:creationdate>1997-12-01T18:27:21-0800</D:creationdate>
        <D:displayname>Example HTML resource</D:displayname>
        <D:getcontentlanguage>en</D:getcontentlanguage>
        <D:getcontenttype>text/html</D:getcontenttype>
        <D:getetag>zzyzx</D:getetag>
        <D:getlastmodified>Mon, 12 Jan 1998 09:25:56 +0000</D:getlastmodified>
        <D:getcontentlength>4525</D:getcontentlength>
        <D:resourcetype/>
        <R:bigbox xmlns:R="http://ns.example.com/boxschema/">
          <R:BoxType>Box type B</R:BoxType>
        </R:bigbox>
        <D:lockdiscovery/>
        <D:supportedlock>
          <D:lockentry>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
          <D:lockentry>
            <D:lockscope>
              <D:shared/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
        </D:supportedlock>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://example.com/container/R2</D:href>
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
        <D:lockdiscovery/>
        <D:supportedlock>
          <D:lockentry>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
          <D:lockentry>
            <D:lockscope>
              <D:shared/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
        </D:supportedlock>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://example.com/container/resource3</D:href>
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
        <D:lockdiscovery/>
        <D:supportedlock>
          <D:lockentry>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
          <D:lockentry>
            <D:lockscope>
              <D:shared/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
        </D:supportedlock>
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
  7 => 
  array (
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
  <D:response xmlns:ezc00000="http://ns.example.com/boxschema/">
    <D:href>http://example.com/container/</D:href>
    <D:propstat xmlns:ezc00000="http://ns.example.com/boxschema/">
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
        <ezc00000:bigbox xmlns:ezc00000="http://ns.example.com/boxschema/"/>
        <ezc00000:author xmlns:ezc00000="http://ns.example.com/boxschema/"/>
        <D:lockdiscovery/>
        <D:supportedlock/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:ezc00000="http://ns.example.com/boxschema/">
    <D:href>http://example.com/container/front.html</D:href>
    <D:propstat xmlns:ezc00000="http://ns.example.com/boxschema/">
      <D:prop>
        <D:creationdate/>
        <D:displayname/>
        <D:getcontentlanguage/>
        <D:getcontenttype/>
        <D:getetag/>
        <D:getlastmodified/>
        <D:getcontentlength/>
        <D:resourcetype/>
        <ezc00000:bigbox xmlns:ezc00000="http://ns.example.com/boxschema/"/>
        <D:lockdiscovery/>
        <D:supportedlock/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://example.com/container/R2</D:href>
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
        <D:lockdiscovery/>
        <D:supportedlock/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
  <D:response>
    <D:href>http://example.com/container/resource3</D:href>
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
        <D:lockdiscovery/>
        <D:supportedlock/>
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
  8 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:prop><D:supportedlock/></D:prop>
</D:propfind>
',
      'server' => 
      array (
        'REQUEST_METHOD' => 'PROPFIND',
        'REQUEST_URI' => '/container/',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'www.foo.bar',
        'HTTP_CONTENT_LENGTH' => '1234',
        'CONTENT_TYPE' => 'text/xml; charset="utf-8"',
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://example.com/container/</D:href>
    <D:propstat>
      <D:prop>
        <D:supportedlock>
          <D:lockentry>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
          <D:lockentry>
            <D:lockscope>
              <D:shared/>
            </D:lockscope>
            <D:locktype>
              <D:write/>
            </D:locktype>
          </D:lockentry>
        </D:supportedlock>
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
  9 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'REQUEST_METHOD' => 'UNLOCK',
        'REQUEST_URI' => '/workspace/webdav/info.doc',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'example.com',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7>',
        'HTTP_AUTH' => 'Digest username="ejw", realm="ejw@example.com", nonce="...", uri="/workspace/webdav/proposal.doc", response="...", opaque="..."',
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
);
?>