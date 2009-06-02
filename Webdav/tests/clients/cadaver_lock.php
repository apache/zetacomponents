<?php
return array (
  1 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'OPTIONS',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'PHP_SELF' => '/index.php/secure_collection/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'Authorization failed.',
      'headers' => 
      array (
        'WWW-Authenticate' => 
        array (
          'basic' => 'Basic realm="eZ Components WebDAV"',
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", algorithm="MD5"',
        ),
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  2 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'OPTIONS',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="21d238b52ade4c0f687e9162a223dd20", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="21d238b52ade4c0f687e9162a223dd20", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'DAV' => '1, 2',
        'Allow' => 'GET, HEAD, PROPFIND, PROPPATCH, OPTIONS, DELETE, COPY, MOVE, MKCOL, PUT, LOCK, UNLOCK',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  3 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  4 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/file.txt</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  5 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="9865ed101fc8e6e5b10920185b25ff2f", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="9865ed101fc8e6e5b10920185b25ff2f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  6 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/file.txt</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  7 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir", response="df27b2983a490f3bb16c8b4e38fec28a", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir", response="df27b2983a490f3bb16c8b4e38fec28a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  8 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype></lockinfo>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'LOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="f1e169520cd24e842054ca6a0d99cd93", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="f1e169520cd24e842054ca6a0d99cd93", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
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
      <D:owner></D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:189f919f-abe6-c74f-3582-542e9ee21b1c</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:22:17+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:189f919f-abe6-c74f-3582-542e9ee21b1c',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  9 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  10 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/file.txt',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/file.txt',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/file.txt',
        'REDIRECT_URI' => '/index.php/secure_collection/file.txt',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/lockdir/file.txt',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_IF' => '<http://webdav/secure_collection/lockdir/> (<opaquelocktoken:189f919f-abe6-c74f-3582-542e9ee21b1c>)',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/file.txt", response="d9115741287e82625654abc2ebe1882f", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/file.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/file.txt", response="d9115741287e82625654abc2ebe1882f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  11 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  12 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  13 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  14 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir/", response="c700495c4a59a6a2e6d7334461c04fb6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/lockdir/file.txt</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  15 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  16 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  17 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/lockdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/lockdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/lockdir',
        'REDIRECT_URI' => '/index.php/secure_collection/lockdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/subdir/nonlockdir',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_IF' => '<http://webdav/secure_collection/lockdir/> (<opaquelocktoken:189f919f-abe6-c74f-3582-542e9ee21b1c>)',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir", response="d9eb53ef66c3dedcd7a0742d10f5d646", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/lockdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/lockdir", response="d9eb53ef66c3dedcd7a0742d10f5d646", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  18 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  19 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.html</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>39</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  20 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.html</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>39</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  21 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/file.html',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/file.html',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/file.html',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/file.html',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="6bdcd607682c46c934aef3887ce10a9e", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/file.html',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="6bdcd607682c46c934aef3887ce10a9e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.html</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>39</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  22 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype></lockinfo>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/file.html',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/file.html',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/file.html',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/file.html',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'LOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="21e9d371300ecb52853d858d68547918", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/file.html',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="21e9d371300ecb52853d858d68547918", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
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
      <D:depth>0</D:depth>
      <D:owner></D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:3a1a5c1f-223b-5361-1140-050f56a45fa3</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:23:04+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:3a1a5c1f-223b-5361-1140-050f56a45fa3',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  23 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/lockfile.html/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/lockfile.html/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/lockfile.html/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/lockfile.html/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/lockfile.html/", response="8b7de1f7472c2a9fa35027ae43e6a89f", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/lockfile.html/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/lockfile.html/", response="8b7de1f7472c2a9fa35027ae43e6a89f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  24 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/file.html',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/file.html',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/file.html',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/file.html',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/subdir/nonlockdir/lockfile.html',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_IF' => '<http://webdav/secure_collection/subdir/file.html> (<opaquelocktoken:3a1a5c1f-223b-5361-1140-050f56a45fa3>)',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="548414bdc2fbc4b1585013c51d0192fa", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/file.html',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.html", response="548414bdc2fbc4b1585013c51d0192fa", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  25 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  26 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  27 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  28 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/", response="e8a2adccd819379e9619e53868511d6d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/file.txt</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/lockfile.html</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>39</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  29 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  30 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  31 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  32 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  33 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype></lockinfo>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'LOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_IF' => '<http://webdav/secure_collection/subdir/file.html> (<opaquelocktoken:3a1a5c1f-223b-5361-1140-050f56a45fa3>)',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="b3ca0a8d914a85fce3378613bc5ec238", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="b3ca0a8d914a85fce3378613bc5ec238", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
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
      <D:owner></D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:23:55+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  34 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<lockdiscovery xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '118',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:prop>
        <D:lockdiscovery xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
          <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
            <D:locktype>
              <D:write/>
            </D:locktype>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:depth>Infinity</D:depth>
            <D:owner></D:owner>
            <D:timeout>Second-900</D:timeout>
            <D:locktoken>
              <D:href>opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222</D:href>
            </D:locktoken>
            <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:23:55+01:00</ezclock:lastaccess>
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
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  35 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<lockdiscovery xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '118',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir", response="71b4fbfcadf092a7de648e81bdc7b2e5", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir", response="71b4fbfcadf092a7de648e81bdc7b2e5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:prop>
        <D:lockdiscovery xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
          <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
            <D:locktype>
              <D:write/>
            </D:locktype>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:depth>Infinity</D:depth>
            <D:owner></D:owner>
            <D:timeout>Second-900</D:timeout>
            <D:locktoken>
              <D:href>opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222</D:href>
            </D:locktoken>
            <ezclock:baseuri xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">/secure_collection/subdir</ezclock:baseuri>
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
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  36 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<lockdiscovery xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '118',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/file.html',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/file.html',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/file.html',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/file.html',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.html", response="747d32fcc8c0d92330e7d38a3f54f05a", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/file.html',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.html", response="747d32fcc8c0d92330e7d38a3f54f05a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  37 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<lockdiscovery xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '118',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/file.txt',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/file.txt',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/file.txt',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/file.txt',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.txt", response="d63f9be12d7716e335de5c57927d92b5", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/file.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.txt", response="d63f9be12d7716e335de5c57927d92b5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/file.txt</D:href>
    <D:propstat xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:prop>
        <D:lockdiscovery xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
          <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
            <D:locktype>
              <D:write/>
            </D:locktype>
            <D:lockscope>
              <D:exclusive/>
            </D:lockscope>
            <D:depth>Infinity</D:depth>
            <D:owner></D:owner>
            <D:timeout>Second-900</D:timeout>
            <D:locktoken>
              <D:href>opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222</D:href>
            </D:locktoken>
            <ezclock:baseuri xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">/secure_collection/subdir</ezclock:baseuri>
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
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  38 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir", response="19bcb90103a05ec942586f24145a4a93", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  39 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'UNLOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:bbb7303f-3503-04ee-12e8-9d37f42d1222>',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="491dfab7852da5102886063906ee0c67", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="491dfab7852da5102886063906ee0c67", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  40 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<lockdiscovery xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '118',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/nonlockdir/file.txt',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/nonlockdir/file.txt',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/nonlockdir/file.txt',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/nonlockdir/file.txt',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.txt", response="d63f9be12d7716e335de5c57927d92b5", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/nonlockdir/file.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/nonlockdir/file.txt", response="d63f9be12d7716e335de5c57927d92b5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/secure_collection/subdir/nonlockdir/file.txt</D:href>
    <D:propstat>
      <D:prop>
        <D:lockdiscovery/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  41 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  42 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/',
        'REDIRECT_URI' => '/index.php/secure_collection/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/", response="82367a0ef876258635f0163683072f58", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  43 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  44 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  45 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/file.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/file.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/file.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/file.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.xml", response="1918747f632052b27aef3ababe448527", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/file.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/file.xml", response="1918747f632052b27aef3ababe448527", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml?>
<content/>',
      'headers' => 
      array (
        'ETag' => 'b23a873ef8c0f8e3b33339bed653b763',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  46 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="fa85fd293cb9d9d4265701764c042da1", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="fa85fd293cb9d9d4265701764c042da1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  47 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype></lockinfo>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'LOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="f342a3b885d11be2150c0167b9063729", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="f342a3b885d11be2150c0167b9063729", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
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
      <D:owner></D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:6ffd3bab-0fcb-12db-6981-62970b9728b6</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:26:20+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:6ffd3bab-0fcb-12db-6981-62970b9728b6',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  48 => 
  array (
    'request' => 
    array (
      'body' => '<?xml?>
<content/>',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '18',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '18',
        'HTTP_IF' => '<http://webdav/secure_collection/subdir/lockfile.xml> (<opaquelocktoken:6ffd3bab-0fcb-12db-6981-62970b9728b6>)',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="aa2e9a77b25c6c29ac7794b7b7598d9c", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="aa2e9a77b25c6c29ac7794b7b7598d9c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'c46632f6cbdffcd08e43dd7b0b272eb6',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  49 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '1',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/", response="6e8bc6f77af5df02d4e34521e5e0b3cd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/file.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>18</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/nonlockdir</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/lockfile.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>0</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  50 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="18b0930b4494da6227a2460d7b104da4", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="18b0930b4494da6227a2460d7b104da4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml?>
<content/>',
      'headers' => 
      array (
        'ETag' => 'c46632f6cbdffcd08e43dd7b0b272eb6',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  51 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<executable xmlns="http://apache.org/dav/props/"/>
<resourcetype xmlns="DAV:"/>
<checked-in xmlns="DAV:"/>
<checked-out xmlns="DAV:"/>
</prop></propfind>
',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'CONTENT_LENGTH' => '288',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '288',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="fa85fd293cb9d9d4265701764c042da1", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="fa85fd293cb9d9d4265701764c042da1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://apache.org/dav/props/">
    <D:href>http://webdav/secure_collection/subdir/lockfile.xml</D:href>
    <D:propstat>
      <D:prop>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>0</D:getcontentlength>
        <D:resourcetype/>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://apache.org/dav/props/">
      <D:prop>
        <D:checked-in/>
        <D:checked-out/>
        <default:executable xmlns="http://apache.org/dav/props/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  52 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'LANG' => 'en_US.UTF-8',
        'SERVER_SOFTWARE' => 'lighttpd/1.4.20',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '127.0.0.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '127.0.0.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/secure_collection/subdir/lockfile.xml',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/subdir/lockfile.xml',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/subdir/lockfile.xml',
        'REDIRECT_URI' => '/index.php/secure_collection/subdir/lockfile.xml',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'UNLOCK',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'cadaver/0.23.2 neon/0.28.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:6ffd3bab-0fcb-12db-6981-62970b9728b6>',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="b654fb3c59fc108bedaa00e4f49c81cf", algorithm="MD5"',
        'PHP_SELF' => '/index.php/secure_collection/subdir/lockfile.xml',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="434992dda224c544527d8c816b9f3036", uri="/secure_collection/subdir/lockfile.xml", response="b654fb3c59fc108bedaa00e4f49c81cf", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.20/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
);
?>