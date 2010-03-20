<?php

return array (
  2 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  3 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  4 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'OPTIONS',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 2 (options)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'DAV' => '1',
        'Allow' => 'GET, HEAD, PROPFIND, PROPPATCH, OPTIONS, DELETE, COPY, MOVE, MKCOL, PUT',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  5 => 
  array (
    'request' => 
    array (
      'body' => 'This is
a test file.
for litmus
testing.
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '41',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res',
        'REDIRECT_URI' => '/index.php/litmus/res',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '41',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'PHP_SELF' => '/index.php/litmus/res',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '80ed8181a5672d711bdd28358cb980e3',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  6 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res',
        'REDIRECT_URI' => '/index.php/litmus/res',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'PHP_SELF' => '/index.php/litmus/res',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'This is
a test file.
for litmus
testing.
',
      'headers' => 
      array (
        'ETag' => '80ed8181a5672d711bdd28358cb980e3',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  7 => 
  array (
    'request' => 
    array (
      'body' => 'This is
a test file.
for litmus
testing.
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '41',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '41',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'PHP_SELF' => '/index.php/litmus/res-€',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '416cdb2f1c4bef5c18742a35f8602cec',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  8 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'PHP_SELF' => '/index.php/litmus/res-€',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'This is
a test file.
for litmus
testing.
',
      'headers' => 
      array (
        'ETag' => '416cdb2f1c4bef5c18742a35f8602cec',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  9 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/409me/noparent.txt/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/409me/noparent.txt/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/409me/noparent.txt/',
        'REDIRECT_URI' => '/index.php/litmus/409me/noparent.txt/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 5 (put_no_parent)',
        'PHP_SELF' => '/index.php/litmus/409me/noparent.txt/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 409 Conflict',
    ),
  ),
  10 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res-€/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res-€/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res-%e2%82%ac/',
        'REDIRECT_URI' => '/index.php/litmus/res-%e2%82%ac/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 6 (mkcol_over_plain)',
        'PHP_SELF' => '/index.php/litmus/res-€/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 405 Method Not Allowed',
    ),
  ),
  11 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 7 (delete)',
        'PHP_SELF' => '/index.php/litmus/res-€',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  12 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/404me',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/404me',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/404me',
        'REDIRECT_URI' => '/index.php/litmus/404me',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 8 (delete_null)',
        'PHP_SELF' => '/index.php/litmus/404me',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  13 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/frag/',
        'REDIRECT_URI' => '/index.php/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/litmus/frag/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  14 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/frag/#ment',
        'REDIRECT_URI' => '/index.php/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/litmus/frag/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  15 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/frag/',
        'REDIRECT_URI' => '/index.php/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/litmus/frag/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  16 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/coll/',
        'REDIRECT_URI' => '/index.php/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 10 (mkcol)',
        'PHP_SELF' => '/index.php/litmus/coll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  17 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/coll/',
        'REDIRECT_URI' => '/index.php/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 11 (mkcol_again)',
        'PHP_SELF' => '/index.php/litmus/coll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 405 Method Not Allowed',
    ),
  ),
  18 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/coll/',
        'REDIRECT_URI' => '/index.php/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 12 (delete_coll)',
        'PHP_SELF' => '/index.php/litmus/coll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  19 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/409me/noparent/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/409me/noparent/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/409me/noparent/',
        'REDIRECT_URI' => '/index.php/litmus/409me/noparent/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 13 (mkcol_no_parent)',
        'PHP_SELF' => '/index.php/litmus/409me/noparent/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 409 Conflict',
    ),
  ),
  20 => 
  array (
    'request' => 
    array (
      'body' => 'afafafaf',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '8',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mkcolbody',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mkcolbody',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mkcolbody',
        'REDIRECT_URI' => '/index.php/litmus/mkcolbody',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_TYPE' => 'xzy-foo/bar-512',
        'HTTP_CONTENT_LENGTH' => '8',
        'HTTP_X_LITMUS' => 'basic: 14 (mkcol_with_body)',
        'PHP_SELF' => '/index.php/litmus/mkcolbody',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 415 Unsupported Media Type',
    ),
  ),
  21 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  22 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  23 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '037a432bb5b8fb91e21929813443a733',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  24 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copycoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copycoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copycoll/',
        'REDIRECT_URI' => '/index.php/litmus/copycoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'PHP_SELF' => '/index.php/litmus/copycoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  25 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 3 (copy_simple)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  26 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  27 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/copydest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  28 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/copycoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  29 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/litmus/nonesuch/foo',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 5 (copy_nodestcoll)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 409 Conflict',
    ),
  ),
  30 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/litmus/copysrc',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  31 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copydest',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copydest',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copydest',
        'REDIRECT_URI' => '/index.php/litmus/copydest',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/litmus/copydest',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  32 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copycoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copycoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copycoll',
        'REDIRECT_URI' => '/index.php/litmus/copycoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/litmus/copycoll',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  33 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/copycoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/copycoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/copycoll/',
        'REDIRECT_URI' => '/index.php/litmus/copycoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/litmus/copycoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  34 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  35 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.0',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.0',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '08a10fa75e8dab2f107b2c2bcb919dcf',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  36 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.1',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.1',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ce80fafe6ab452cb2e737ec3c5183e29',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  37 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.2',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'bc91b4a7857501ebc33da392ffd77a09',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  38 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.3',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.3',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '6d86ff17cb8f834ab3525c78b756dbb0',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  39 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.4',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.4',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1cc67bb74e48682f22a1ddd22f48891e',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  40 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.5',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.5',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '0297c9404997634eb5b05ae279de099b',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  41 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.6',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.6',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '7e27badf8ac95d4b35d36a43cc0778d8',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  42 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.7',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.7',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'c0732fa42468d0f9935542fed5ac3f70',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  43 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.8',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.8',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'f948a9b28902743f49450a76134ebc0b',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  44 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo.9',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo.9',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ad762453ab3ee5dcd85624b183245125',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  45 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/subcoll/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/subcoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  46 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  47 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  48 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  49 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  50 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  51 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  52 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  53 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.0',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.0',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  54 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.1',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.1',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  55 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.2',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  56 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.3',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.3',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  57 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.4',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.4',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  58 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.5',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.5',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  59 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.6',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.6',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  60 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.7',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.7',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  61 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.8',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.8',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  62 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/foo.9',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/foo.9',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  63 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/subcoll/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/subcoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  64 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  65 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/litmus/ccdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  66 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  67 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/foo',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/foo',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/foo',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/foo',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/foo',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1352d4d3aee6f5c39a9197917c7b3651',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  68 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  69 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  70 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  71 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/foo',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/foo',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/foo',
        'REDIRECT_URI' => '/index.php/litmus/foo',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/foo',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  72 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/litmus/ccdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  73 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/move',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/move',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/move',
        'REDIRECT_URI' => '/index.php/litmus/move',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/move',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '89105e1698849e013e2a691fbb02564d',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  74 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/move2',
        'REDIRECT_URI' => '/index.php/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/move2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '9f478623a74f0928159e18aa408310f2',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  75 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/movecoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/movecoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/movecoll/',
        'REDIRECT_URI' => '/index.php/litmus/movecoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/movecoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  76 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/move',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/move',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/move',
        'REDIRECT_URI' => '/index.php/litmus/move',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/move',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  77 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/move2',
        'REDIRECT_URI' => '/index.php/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/move2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  78 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/move2',
        'REDIRECT_URI' => '/index.php/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/movedest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/move2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  79 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/movedest',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/movedest',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/movedest',
        'REDIRECT_URI' => '/index.php/litmus/movedest',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/movecoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/movedest',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  80 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/movecoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/movecoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/movecoll',
        'REDIRECT_URI' => '/index.php/litmus/movecoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/litmus/movecoll',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  81 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  82 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.0',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.0',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1d6938cd24b9e2ab0665beed28cf2f9c',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  83 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.1',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.1',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '18475e87a04f02f14649db91e0b1dc60',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  84 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.2',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a5877488bc31e821ce934874bcb14bf4',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  85 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.3',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.3',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1ecd23f7cc5d804a97821f49149515a4',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  86 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.4',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.4',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'e9bb55dc02964ad0a66eda05f8ed67be',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  87 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.5',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.5',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '012f58648e1815ba8b8c2a092f9d36e5',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  88 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.6',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.6',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'b2eb0ba6c9cc8132d04d069b48a2a778',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  89 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.7',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.7',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'd99008d5276d46594c2ae9622cc81998',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  90 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.8',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.8',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '5ea28b2189b023db877a63c81dc91d6e',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  91 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/foo.9',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/foo.9',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'f489e86dc4b37c25f0c5ae1f78953f10',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  92 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvnoncoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvnoncoll',
        'REDIRECT_URI' => '/index.php/litmus/mvnoncoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvnoncoll',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '5a61ff339af95a5d6fe63f893395dfab',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  93 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/subcoll/',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/subcoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  94 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  95 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvsrc/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  96 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  97 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  98 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  99 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.0',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.0',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  100 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.1',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.1',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  101 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.2',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  102 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.3',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.3',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  103 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.4',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.4',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  104 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.5',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.5',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  105 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.6',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.6',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  106 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.7',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.7',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  107 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.8',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.8',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  108 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/foo.9',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/foo.9',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  109 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/subcoll/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest/subcoll/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  110 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/mvnoncoll',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/litmus/mvdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  111 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/litmus/mvdest/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  112 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/litmus/mvdest2/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  113 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/mvnoncoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/mvnoncoll',
        'REDIRECT_URI' => '/index.php/litmus/mvnoncoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/litmus/mvnoncoll',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  114 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  115 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  116 => 
  array (
    'request' => 
    array (
      'body' => '<foo>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '5',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '5',
        'HTTP_DEPTH' => '0',
        'HTTP_X_LITMUS' => 'props: 2 (propfind_invalid)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'The HTTP request body received for HTTP method \'PROPFIND\' was invalid. Reason: Invalid XML. Libxml error.\'',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '106',
      ),
      'status' => 'HTTP/1.1 400 Bad Request',
    ),
  ),
  117 => 
  array (
    'request' => 
    array (
      'body' => '<D:propfind xmlns:D="DAV:"><D:prop><bar:foo xmlns:bar=""/></D:prop></D:propfind>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '80',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '80',
        'HTTP_DEPTH' => '0',
        'HTTP_X_LITMUS' => 'props: 3 (propfind_invalid2)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/litmus/</D:href>
    <D:propstat>
      <D:prop>
        <foo/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  118 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<displayname xmlns="DAV:"/>
<resourcetype xmlns="DAV:"/>
<foo xmlns="http://example.com/neon/litmus/"/>
<bar xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '304',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/',
        'REDIRECT_URI' => '/index.php/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '304',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 4 (propfind_d0)',
        'PHP_SELF' => '/index.php/litmus/',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/</D:href>
    <D:propstat>
      <D:prop>
        <D:displayname>litmus</D:displayname>
        <D:getlastmodified>Mon, 15 Aug 2005 15:13:00 +0000</D:getlastmodified>
        <D:getcontentlength>4096</D:getcontentlength>
        <D:resourcetype>
          <D:collection/>
        </D:resourcetype>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:foo xmlns="http://example.com/neon/litmus/"/>
        <default:bar xmlns="http://example.com/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  119 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  120 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'd00d4f2e7dee4ffc53b941104e5f9980',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  121 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><prop0 xmlns="http://example.com/neon/litmus/">value0</prop0></D:prop></D:set>
<D:set><D:prop><prop1 xmlns="http://example.com/neon/litmus/">value1</prop1></D:prop></D:set>
<D:set><D:prop><prop2 xmlns="http://example.com/neon/litmus/">value2</prop2></D:prop></D:set>
<D:set><D:prop><prop3 xmlns="http://example.com/neon/litmus/">value3</prop3></D:prop></D:set>
<D:set><D:prop><prop4 xmlns="http://example.com/neon/litmus/">value4</prop4></D:prop></D:set>
<D:set><D:prop><prop5 xmlns="http://example.com/neon/litmus/">value5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://example.com/neon/litmus/">value6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://example.com/neon/litmus/">value7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://example.com/neon/litmus/">value8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://example.com/neon/litmus/">value9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '1033',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '1033',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 6 (propset)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:prop0 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop1 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop2 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop3 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop4 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop5 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop6 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop7 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop8 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop9 xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  122 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://example.com/neon/litmus/"/>
<prop1 xmlns="http://example.com/neon/litmus/"/>
<prop2 xmlns="http://example.com/neon/litmus/"/>
<prop3 xmlns="http://example.com/neon/litmus/"/>
<prop4 xmlns="http://example.com/neon/litmus/"/>
<prop5 xmlns="http://example.com/neon/litmus/"/>
<prop6 xmlns="http://example.com/neon/litmus/"/>
<prop7 xmlns="http://example.com/neon/litmus/"/>
<prop8 xmlns="http://example.com/neon/litmus/"/>
<prop9 xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '578',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '578',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 7 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://example.com/neon/litmus/">value0</default:prop0>
        <default:prop1 xmlns="http://example.com/neon/litmus/">value1</default:prop1>
        <default:prop2 xmlns="http://example.com/neon/litmus/">value2</default:prop2>
        <default:prop3 xmlns="http://example.com/neon/litmus/">value3</default:prop3>
        <default:prop4 xmlns="http://example.com/neon/litmus/">value4</default:prop4>
        <default:prop5 xmlns="http://example.com/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://example.com/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://example.com/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://example.com/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://example.com/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  123 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns="DAV:"><foobar/><allprop/></propfind>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '92',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '92',
        'HTTP_X_LITMUS' => 'props: 8 (propextended)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'The HTTP request body received for HTTP method \'PROPFIND\' was invalid. Reason: XML element <foobar /> is not a valid child element for <propfind />.',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '148',
      ),
      'status' => 'HTTP/1.1 400 Bad Request',
    ),
  ),
  124 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  125 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/litmus/prop2',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  126 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://example.com/neon/litmus/"/>
<prop1 xmlns="http://example.com/neon/litmus/"/>
<prop2 xmlns="http://example.com/neon/litmus/"/>
<prop3 xmlns="http://example.com/neon/litmus/"/>
<prop4 xmlns="http://example.com/neon/litmus/"/>
<prop5 xmlns="http://example.com/neon/litmus/"/>
<prop6 xmlns="http://example.com/neon/litmus/"/>
<prop7 xmlns="http://example.com/neon/litmus/"/>
<prop8 xmlns="http://example.com/neon/litmus/"/>
<prop9 xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '578',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '578',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 10 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://example.com/neon/litmus/">value0</default:prop0>
        <default:prop1 xmlns="http://example.com/neon/litmus/">value1</default:prop1>
        <default:prop2 xmlns="http://example.com/neon/litmus/">value2</default:prop2>
        <default:prop3 xmlns="http://example.com/neon/litmus/">value3</default:prop3>
        <default:prop4 xmlns="http://example.com/neon/litmus/">value4</default:prop4>
        <default:prop5 xmlns="http://example.com/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://example.com/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://example.com/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://example.com/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://example.com/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  127 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:remove><D:prop><prop0 xmlns="http://example.com/neon/litmus/"></prop0></D:prop></D:remove>
<D:remove><D:prop><prop1 xmlns="http://example.com/neon/litmus/"></prop1></D:prop></D:remove>
<D:remove><D:prop><prop2 xmlns="http://example.com/neon/litmus/"></prop2></D:prop></D:remove>
<D:remove><D:prop><prop3 xmlns="http://example.com/neon/litmus/"></prop3></D:prop></D:remove>
<D:remove><D:prop><prop4 xmlns="http://example.com/neon/litmus/"></prop4></D:prop></D:remove>
<D:set><D:prop><prop5 xmlns="http://example.com/neon/litmus/">value5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://example.com/neon/litmus/">value6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://example.com/neon/litmus/">value7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://example.com/neon/litmus/">value8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://example.com/neon/litmus/">value9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '1033',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '1033',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 11 (propdeletes)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:prop0 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop1 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop2 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop3 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop4 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop5 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop6 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop7 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop8 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop9 xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  128 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://example.com/neon/litmus/"/>
<prop1 xmlns="http://example.com/neon/litmus/"/>
<prop2 xmlns="http://example.com/neon/litmus/"/>
<prop3 xmlns="http://example.com/neon/litmus/"/>
<prop4 xmlns="http://example.com/neon/litmus/"/>
<prop5 xmlns="http://example.com/neon/litmus/"/>
<prop6 xmlns="http://example.com/neon/litmus/"/>
<prop7 xmlns="http://example.com/neon/litmus/"/>
<prop8 xmlns="http://example.com/neon/litmus/"/>
<prop9 xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '578',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '578',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 12 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop5 xmlns="http://example.com/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://example.com/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://example.com/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://example.com/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://example.com/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://example.com/neon/litmus/"/>
        <default:prop1 xmlns="http://example.com/neon/litmus/"/>
        <default:prop2 xmlns="http://example.com/neon/litmus/"/>
        <default:prop3 xmlns="http://example.com/neon/litmus/"/>
        <default:prop4 xmlns="http://example.com/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  129 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:remove><D:prop><prop0 xmlns="http://example.com/neon/litmus/"></prop0></D:prop></D:remove>
<D:remove><D:prop><prop1 xmlns="http://example.com/neon/litmus/"></prop1></D:prop></D:remove>
<D:remove><D:prop><prop2 xmlns="http://example.com/neon/litmus/"></prop2></D:prop></D:remove>
<D:remove><D:prop><prop3 xmlns="http://example.com/neon/litmus/"></prop3></D:prop></D:remove>
<D:remove><D:prop><prop4 xmlns="http://example.com/neon/litmus/"></prop4></D:prop></D:remove>
<D:set><D:prop><prop5 xmlns="http://example.com/neon/litmus/">newvalue5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://example.com/neon/litmus/">newvalue6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://example.com/neon/litmus/">newvalue7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://example.com/neon/litmus/">newvalue8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://example.com/neon/litmus/">newvalue9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '1048',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '1048',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 13 (propreplace)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:prop0 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop1 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop2 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop3 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop4 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop5 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop6 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop7 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop8 xmlns:ezc00000="http://example.com/neon/litmus/"/>
      <ezc00000:prop9 xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  130 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://example.com/neon/litmus/"/>
<prop1 xmlns="http://example.com/neon/litmus/"/>
<prop2 xmlns="http://example.com/neon/litmus/"/>
<prop3 xmlns="http://example.com/neon/litmus/"/>
<prop4 xmlns="http://example.com/neon/litmus/"/>
<prop5 xmlns="http://example.com/neon/litmus/"/>
<prop6 xmlns="http://example.com/neon/litmus/"/>
<prop7 xmlns="http://example.com/neon/litmus/"/>
<prop8 xmlns="http://example.com/neon/litmus/"/>
<prop9 xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '578',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '578',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 14 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop5 xmlns="http://example.com/neon/litmus/">newvalue5</default:prop5>
        <default:prop6 xmlns="http://example.com/neon/litmus/">newvalue6</default:prop6>
        <default:prop7 xmlns="http://example.com/neon/litmus/">newvalue7</default:prop7>
        <default:prop8 xmlns="http://example.com/neon/litmus/">newvalue8</default:prop8>
        <default:prop9 xmlns="http://example.com/neon/litmus/">newvalue9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://example.com/neon/litmus/"/>
        <default:prop1 xmlns="http://example.com/neon/litmus/"/>
        <default:prop2 xmlns="http://example.com/neon/litmus/"/>
        <default:prop3 xmlns="http://example.com/neon/litmus/"/>
        <default:prop4 xmlns="http://example.com/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  133 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><high-unicode xmlns=\'http://example.com/neon/litmus/\'>&#65536;</high-unicode></prop></set></propertyupdate>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '186',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '186',
        'HTTP_X_LITMUS' => 'props: 17 (prophighunicode)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:high-unicode xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  134 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<high-unicode xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '144',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '144',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 18 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:high-unicode xmlns="http://example.com/neon/litmus/">𐀀</default:high-unicode>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  135 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><remove><prop><removeset xmlns=\'http://example.com/neon/litmus/\'/></prop></remove><set><prop><removeset xmlns=\'http://example.com/neon/litmus/\'>x</removeset></prop></set><set><prop><removeset xmlns=\'http://example.com/neon/litmus/\'>y</removeset></prop></set></propertyupdate>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '343',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '343',
        'HTTP_X_LITMUS' => 'props: 19 (propremoveset)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:removeset xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  136 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<removeset xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 20 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:removeset xmlns="http://example.com/neon/litmus/">y</default:removeset>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  137 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><removeset xmlns=\'http://example.com/neon/litmus/\'>x</removeset></prop></set><remove><prop><removeset xmlns=\'http://example.com/neon/litmus/\'/></prop></remove></propertyupdate>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '255',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '255',
        'HTTP_X_LITMUS' => 'props: 21 (propsetremove)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:removeset xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  138 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<removeset xmlns="http://example.com/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '141',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '141',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 22 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://example.com/neon/litmus/">
      <D:prop>
        <default:removeset xmlns="http://example.com/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  139 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><t:valnspace xmlns:t=\'http://example.com/neon/litmus/\'><foo xmlns=\'http://bar\'/></t:valnspace></prop></set></propertyupdate>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '203',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '203',
        'HTTP_X_LITMUS' => 'props: 23 (propvalnspace)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop2</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/neon/litmus/">
    <D:prop>
      <ezc00000:valnspace xmlns:ezc00000="http://example.com/neon/litmus/"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  140 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns=\'DAV:\'><prop><valnspace xmlns=\'http://example.com/neon/litmus/\'/></prop></propfind>',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '138',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop2',
        'REDIRECT_URI' => '/index.php/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '138',
        'HTTP_X_LITMUS' => 'props: 24 (propwformed)',
        'PHP_SELF' => '/index.php/litmus/prop2',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:t="http://example.com/neon/litmus/" xmlns:default="http://bar">
    <D:href>http://webdav/litmus/prop2</D:href>
    <D:propstat xmlns:t="http://example.com/neon/litmus/" xmlns:default="http://bar">
      <D:prop>
        <t:valnspace xmlns:t="http://example.com/neon/litmus/" xmlns:default="http://bar">
          <default:foo xmlns="http://bar"/>
        </t:valnspace>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  141 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  142 => 
  array (
    'request' => 
    array (
      'body' => 'This
is
a
test
file
called
foo

',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '32',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'd00d4f2e7dee4ffc53b941104e5f9980',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  143 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><somename xmlns="http://example.com/alpha">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/beta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/gamma">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/delta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/epsilon">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/zeta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/eta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/theta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/iota">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="http://example.com/kappa">manynsvalue</somename></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '1070',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '1070',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 26 (propmanyns)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/litmus/prop</D:href>
  <D:propstat xmlns:ezc00000="http://example.com/alpha" xmlns:ezc00001="http://example.com/beta" xmlns:ezc00002="http://example.com/gamma" xmlns:ezc00003="http://example.com/delta" xmlns:ezc00004="http://example.com/epsilon" xmlns:ezc00005="http://example.com/zeta" xmlns:ezc00006="http://example.com/eta" xmlns:ezc00007="http://example.com/theta" xmlns:ezc00008="http://example.com/iota" xmlns:ezc00009="http://example.com/kappa">
    <D:prop>
      <ezc00000:somename xmlns:ezc00000="http://example.com/alpha"/>
      <ezc00001:somename xmlns:ezc00001="http://example.com/beta"/>
      <ezc00002:somename xmlns:ezc00002="http://example.com/gamma"/>
      <ezc00003:somename xmlns:ezc00003="http://example.com/delta"/>
      <ezc00004:somename xmlns:ezc00004="http://example.com/epsilon"/>
      <ezc00005:somename xmlns:ezc00005="http://example.com/zeta"/>
      <ezc00006:somename xmlns:ezc00006="http://example.com/eta"/>
      <ezc00007:somename xmlns:ezc00007="http://example.com/theta"/>
      <ezc00008:somename xmlns:ezc00008="http://example.com/iota"/>
      <ezc00009:somename xmlns:ezc00009="http://example.com/kappa"/>
    </D:prop>
    <D:status>HTTP/1.1 200 OK</D:status>
  </D:propstat>
</D:response>
',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  144 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<somename xmlns="http://example.com/alpha"/>
<somename xmlns="http://example.com/beta"/>
<somename xmlns="http://example.com/gamma"/>
<somename xmlns="http://example.com/delta"/>
<somename xmlns="http://example.com/epsilon"/>
<somename xmlns="http://example.com/zeta"/>
<somename xmlns="http://example.com/eta"/>
<somename xmlns="http://example.com/theta"/>
<somename xmlns="http://example.com/iota"/>
<somename xmlns="http://example.com/kappa"/>
</prop></propfind>
',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'CONTENT_LENGTH' => '535',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_CONTENT_LENGTH' => '535',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 27 (propget)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/alpha" xmlns:default1="http://example.com/beta" xmlns:default2="http://example.com/gamma" xmlns:default3="http://example.com/delta" xmlns:default4="http://example.com/epsilon" xmlns:default5="http://example.com/zeta" xmlns:default6="http://example.com/eta" xmlns:default7="http://example.com/theta" xmlns:default8="http://example.com/iota" xmlns:default9="http://example.com/kappa">
    <D:href>http://webdav/litmus/prop</D:href>
    <D:propstat xmlns:default="http://example.com/alpha" xmlns:default1="http://example.com/beta" xmlns:default2="http://example.com/gamma" xmlns:default3="http://example.com/delta" xmlns:default4="http://example.com/epsilon" xmlns:default5="http://example.com/zeta" xmlns:default6="http://example.com/eta" xmlns:default7="http://example.com/theta" xmlns:default8="http://example.com/iota" xmlns:default9="http://example.com/kappa">
      <D:prop>
        <default:somename xmlns="http://example.com/alpha">manynsvalue</default:somename>
        <default1:somename xmlns="http://example.com/beta">manynsvalue</default1:somename>
        <default2:somename xmlns="http://example.com/gamma">manynsvalue</default2:somename>
        <default3:somename xmlns="http://example.com/delta">manynsvalue</default3:somename>
        <default4:somename xmlns="http://example.com/epsilon">manynsvalue</default4:somename>
        <default5:somename xmlns="http://example.com/zeta">manynsvalue</default5:somename>
        <default6:somename xmlns="http://example.com/eta">manynsvalue</default6:somename>
        <default7:somename xmlns="http://example.com/theta">manynsvalue</default7:somename>
        <default8:somename xmlns="http://example.com/iota">manynsvalue</default8:somename>
        <default9:somename xmlns="http://example.com/kappa">manynsvalue</default9:somename>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  145 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SERVER_SOFTWARE' => 'lighttpd/1.4.22',
        'SERVER_NAME' => 'webdav',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PORT' => '80',
        'SERVER_ADDR' => '::ffff:127.0.1.1',
        'REMOTE_PORT' => '33458',
        'REMOTE_ADDR' => '::ffff:127.0.1.1',
        'SCRIPT_NAME' => '/index.php',
        'PATH_INFO' => '/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/litmus/prop',
        'REDIRECT_URI' => '/index.php/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 28 (propcleanup)',
        'PHP_SELF' => '/index.php/litmus/prop',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
);

?>
