<?php
return array (
  1 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/", response="6b57e288c8bc15a68327bcdb2f5f40ed", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/", response="f008b12c2de2de5f8c3bea868bc47bfa", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 2 (options)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'OPTIONS',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/", response="ddd1233d251de72e21fdf1a74903614d", algorithm="MD5"',
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
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/res',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '41',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res',
        'PHP_SELF' => '/secure_collection/litmus/res',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res", response="43d7fd946009737b2662167f15fd360a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '44175eb61c5d59d37803ff7826e91b7a',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/res',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'GET',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res',
        'PHP_SELF' => '/secure_collection/litmus/res',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res", response="f9f7670ea02fa9b7eafd693906340d5d", algorithm="MD5"',
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
        'ETag' => '44175eb61c5d59d37803ff7826e91b7a',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/res-€',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res-€',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '41',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res-€',
        'PHP_SELF' => '/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res-%e2%82%ac", response="5658a5d1c21c33e94ae57da90c246aa1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '06e933a87b6c93205dce44415d9735c9',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/res-€',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res-€',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'GET',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res-€',
        'PHP_SELF' => '/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res-%e2%82%ac", response="d8b2395415c53ff8140799a61a6a69b4", algorithm="MD5"',
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
        'ETag' => '06e933a87b6c93205dce44415d9735c9',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/res-€/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res-€/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 5 (mkcol_over_plain)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res-€/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res-€/',
        'PHP_SELF' => '/secure_collection/litmus/res-€/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res-%e2%82%ac/", response="2a2d2f93ebc6a052b4be07a8910052db", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 405 Method Not Allowed',
    ),
  ),
  10 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/res-€',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/res-€',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 6 (delete)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/res-€',
        'PHP_SELF' => '/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/res-%e2%82%ac", response="1085ec1f9530a05e59cfb63b8c35d8ca", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  11 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/404me',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/404me',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 7 (delete_null)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/404me',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/404me',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/404me',
        'PHP_SELF' => '/secure_collection/litmus/404me',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/404me", response="3f39aeea518a9190cfe10bd2f3392ec1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  12 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/frag/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/frag/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 8 (delete_fragment)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/frag/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/frag/',
        'PHP_SELF' => '/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/frag/", response="7285104588e051a21180a8a9f01136c3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  13 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/frag/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/frag/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 8 (delete_fragment)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/frag/#ment',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/frag/',
        'PHP_SELF' => '/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/frag/#ment", response="94df5679d69a65606ccfc97d541de4da", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  14 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/frag/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/frag/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 8 (delete_fragment)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/frag/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/frag/',
        'PHP_SELF' => '/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/frag/", response="e75d67526d39b66b518117af70f0a897", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  15 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/coll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/coll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 9 (mkcol)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/coll/',
        'PHP_SELF' => '/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/coll/", response="7e76ed667d51f524dec8d91bd10b5213", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  16 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/coll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/coll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 10 (mkcol_again)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/coll/',
        'PHP_SELF' => '/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/coll/", response="7e76ed667d51f524dec8d91bd10b5213", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 405 Method Not Allowed',
    ),
  ),
  17 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/coll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/coll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 11 (delete_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/coll/',
        'PHP_SELF' => '/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/coll/", response="51980b8540efb38b5ce8c9f08d8446db", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  18 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/409me/noparent/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/409me/noparent/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 12 (mkcol_no_parent)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/409me/noparent/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/409me/noparent/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/409me/noparent/',
        'PHP_SELF' => '/secure_collection/litmus/409me/noparent/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/409me/noparent/", response="85ca7510abeb529048a67d71d2c55ba2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 409 Conflict',
    ),
  ),
  19 => 
  array (
    'request' => 
    array (
      'body' => 'afafafaf',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/mkcolbody',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mkcolbody',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_TYPE' => 'xzy-foo/bar-512',
        'CONTENT_LENGTH' => '8',
        'HTTP_X_LITMUS' => 'basic: 13 (mkcol_with_body)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mkcolbody',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mkcolbody',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mkcolbody',
        'PHP_SELF' => '/secure_collection/litmus/mkcolbody',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="b649bcee7d702d6a0e3a0cba5bfba040", uri="/secure_collection/litmus/mkcolbody", response="8ab66c426fea3d424b4d01789c39ee6f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 415 Unsupported Media Type',
    ),
  ),
  20 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  21 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/", response="f02c3b77bd5ad020fc077efc93f7ff00", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/", response="219cd707171362b1741a5b811ff1d5bb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="b1644b9b1326ed148655b70131d169a2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '4d1325c64e5cf462a33309b65a38c868',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copycoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copycoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copycoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copycoll/',
        'PHP_SELF' => '/secure_collection/litmus/copycoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copycoll/", response="68271fcb4d8b68a281b729a4ae990845", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 3 (copy_simple)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="fb254d6ecb6f2c869d97cc66598277f3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="fb254d6ecb6f2c869d97cc66598277f3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="fb254d6ecb6f2c869d97cc66598277f3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copycoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="fb254d6ecb6f2c869d97cc66598277f3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/nonesuch/foo',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 5 (copy_nodestcoll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="fb254d6ecb6f2c869d97cc66598277f3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copysrc',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copysrc',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copysrc',
        'PHP_SELF' => '/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copysrc", response="aa10e165c00a7797c1a198ba9476f7de", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copydest',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copydest',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copydest',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copydest',
        'PHP_SELF' => '/secure_collection/litmus/copydest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copydest", response="79b927ca072c1131752a05f691971aef", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copycoll',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copycoll',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copycoll',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copycoll',
        'PHP_SELF' => '/secure_collection/litmus/copycoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copycoll", response="363b758d9a487920b71df232ef3cc512", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/copycoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/copycoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/copycoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/copycoll/',
        'PHP_SELF' => '/secure_collection/litmus/copycoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/copycoll/", response="5bf9d9d6be97d63df97cb26007abd1c1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="5a23660366b01ffc329d2f20379f3dce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.0',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.0',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.0',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.0',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.0',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.0", response="4d3c02f7d60a7039c774e4fa78b0be31", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'b13013f87db0ab9a14d28a3a5026715c',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.1',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.1',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.1',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.1',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.1", response="3b6447ccab4a1dbf33af7259964e947b", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'cf36789987f452120fcd5b9db3c2dd86',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.2',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.2", response="aef797f76e94bf7cf5b4b6e65a417b7d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '4369f5a48521d3826ec3d7436b2ac8f5',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.3',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.3',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.3',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.3',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.3',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.3", response="aebe7d499d6ecfff615643edac7231c4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '66ca212bee3d00de66d8270778ae5d95',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.4',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.4',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.4',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.4',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.4',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.4", response="5489237e7791305676edbe0be60c4c33", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '7106c952281b335a81d72b7cea237d8d',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.5',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.5',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.5',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.5',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.5',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.5", response="a21d9cbfc2d3db826841416489f4e461", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '991398d90f4221a97f60104c4e816831',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.6',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.6',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.6',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.6',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.6',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.6", response="5c40e81e9c310d01cd482d4f2146d837", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1535a94ec67bb1499c692316aa73cbba',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.7',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.7',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.7',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.7',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.7',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.7", response="173bbb5f088d9f88eb801c66b4b43cfa", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '3ed93079551387c94413a3f8ce128efb',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.8',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.8',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.8',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.8',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.8',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.8", response="e48773c9039da1899b4a2481e332522a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '9c128b9dd4522b09dd81374e8b59b3cf',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo.9',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo.9',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.9',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.9',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo.9',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo.9", response="a5f9a6a39bb83b843d33f34ba2b76c74", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '9f3c6d9f9a6351ad4908f7cfc45a113a',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/subcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/subcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/subcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/subcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/subcoll/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/subcoll/", response="63f048879e1b8d7b8d5f61b8b3959809", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/", response="460f9ffdb2e81bc8e2e4a2223ce52deb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest2/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest2/", response="1bf09e97a11ac371ac5fdd42ce9ec8d2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="e93ed6cfb1d0df2af42540528d2c19d6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="e93ed6cfb1d0df2af42540528d2c19d6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/", response="49d04899b651b2e9477f4b3d0422b058", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest2/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest2/", response="b423c2658d16af32a68ff8c8a2798dac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="544fc1bf1abb149dba247e25c9662f36", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.0',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.0',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.0',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.0',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.0',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.0", response="e502bfda38aa67d4b83ba33bec76c6f9", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.1',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.1',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.1',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.1',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.1", response="7607f2149bd87ee418bd51699d60be38", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.2',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.2", response="9294ac0c56bc09b586d908d69c06a524", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.3',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.3',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.3',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.3',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.3',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.3", response="4abcb721e35805d0525b19d154cca563", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.4',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.4',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.4',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.4',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.4',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.4", response="4010aa4b0d07fc0c817d4fb52eb56b12", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.5',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.5',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.5',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.5',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.5',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.5", response="f192a3d831f81b63373345d8696fad32", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.6',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.6',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.6',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.6',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.6',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.6", response="0a62e889aec4ed20686931ca6bc2c573", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.7',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.7',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.7',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.7',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.7',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.7", response="e9ad2ea18a17061d2fbdf61412d1b748", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.8',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.8',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.8',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.8',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.8',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.8", response="855f1069dd6c45c345ac3ac30f6f300e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/foo.9',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/foo.9',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.9',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.9',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/foo.9',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/foo.9", response="953e101bfe96e05f61c8abca2d3674f1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/subcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/subcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/subcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/subcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/subcoll/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/subcoll/", response="fd847d78338a694488d50aa891a342a4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest2/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest2/", response="1bf09e97a11ac371ac5fdd42ce9ec8d2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/", response="460f9ffdb2e81bc8e2e4a2223ce52deb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="5a23660366b01ffc329d2f20379f3dce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/foo',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/foo',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/foo',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/foo',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/foo", response="22bfbf0b67495c683b2ca8e053db752b", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ffba400ab448987e283d7f7171dc7abd',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/", response="460f9ffdb2e81bc8e2e4a2223ce52deb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="e93ed6cfb1d0df2af42540528d2c19d6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccsrc/',
        'PHP_SELF' => '/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccsrc/", response="544fc1bf1abb149dba247e25c9662f36", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/foo',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/foo',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/foo',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/foo',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/foo',
        'PHP_SELF' => '/secure_collection/litmus/foo',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/foo", response="98ca50ae587aaaaa02928afefad1b6a1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/ccdest/',
        'PHP_SELF' => '/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/ccdest/", response="460f9ffdb2e81bc8e2e4a2223ce52deb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/move',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/move',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/move',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/move',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/move',
        'PHP_SELF' => '/secure_collection/litmus/move',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/move", response="90db8d95309a22d5c7b17ff9db5bc7b5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '857cfc6ed91de32ea0efaf80e4d9ec3e',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/move2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/move2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/move2',
        'PHP_SELF' => '/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/move2", response="4e0b8de2e58e089a955cd8caa8feac0f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '537dcae574f03b5cbbffbc4410bc97c0',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/movecoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/movecoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/movecoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/movecoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/movecoll/',
        'PHP_SELF' => '/secure_collection/litmus/movecoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/movecoll/", response="84b41b74e8deb18e4d7accf77134fe1b", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/move',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/move',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/move',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/move',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/move',
        'PHP_SELF' => '/secure_collection/litmus/move',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/move", response="8fdfa3bd3c7e2830b85532220d8bbbe3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/move2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/move2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/move2',
        'PHP_SELF' => '/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/move2", response="bbc6bfbe1d8a1bdde5ae2a8da912ef5a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/move2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/move2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/move2',
        'PHP_SELF' => '/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/move2", response="bbc6bfbe1d8a1bdde5ae2a8da912ef5a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/movedest',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movecoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/movedest',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/movedest',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/movedest',
        'PHP_SELF' => '/secure_collection/litmus/movedest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/movedest", response="43790b3616b2e0146e1a0d6467bf4fd8", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/movecoll',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/movecoll',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/movecoll',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/movecoll',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/movecoll',
        'PHP_SELF' => '/secure_collection/litmus/movecoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/movecoll", response="c9adff20730457708272b7cd0f2d0086", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/", response="2bdc4c1c93f99510e689796b9efcf2d2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.0',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.0',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.0',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.0',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.0',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.0", response="82842b0d18d62cc6480b8cd1c3f3fd49", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '8fb8fe36390000586d641212924f9159',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.1',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.1',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.1',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.1',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.1", response="c1bd4e388ae0427b68fca40098311343", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a43c886c9b8b8a52fa9d9ae9d4e33f70',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.2',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.2", response="a1dfce9658c3c056cd40fa9d1bbc74dc", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a5d6796e685ce2cc313e16d3286ce9ec',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.3',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.3',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.3',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.3',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.3',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.3", response="875348dad465ba21a7343b63bb2fc117", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '32e73a199b082894e522b06d3fb678cb',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.4',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.4',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.4',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.4',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.4',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.4", response="dfe3031a23dfd1628913dd8bbd8bc711", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'dfa64616f97896969e04aa0a6015040d',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.5',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.5',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.5',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.5',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.5',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.5", response="866d48249f68d6851c08f25d657a23b5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '675dcfdcbffae9a7c3c63854530000d6',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.6',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.6',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.6',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.6',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.6',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.6", response="08aa1a0178f32ad125e49aa278391c89", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a60570ca8210953a8c3438d81d8b3bf2',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.7',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.7',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.7',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.7',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.7',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.7", response="9f4d0d4f5ac47ea5131525d8d8f380df", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'e1d4346a9f79afa2363d8a9a1168855e',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.8',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.8',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.8',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.8',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.8',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.8", response="e0a1f92a8194af30d32fc7e5ac4928a1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ee2139ed51a145edeac1eb8fb5847451',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/foo.9',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/foo.9',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.9',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.9',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/foo.9',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/foo.9", response="fc151f6851a4d877460dbce8d06706b7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '76a1b7d253e6487b4af20b10208482ad',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvnoncoll',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvnoncoll',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvnoncoll',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvnoncoll',
        'PHP_SELF' => '/secure_collection/litmus/mvnoncoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvnoncoll", response="cebe602dfb7fd88de8091143ec2a75d0", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a16dbefbbfff804fcd1975f937c67def',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/subcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/subcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/subcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/subcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/subcoll/',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/subcoll/", response="c5521d31da89f84b6cb2a8fffff2a047", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/", response="4ac1e0e841cc5cf90675d9fac55ebe52", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvsrc/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvsrc/',
        'PHP_SELF' => '/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvsrc/", response="34cadcf826fa3ba5b2c6df807b3bb2a9", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/", response="cf101e5f1b13160aa12f1dc9e8dcca8e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest2/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest2/", response="241e59f747d0435cf0714daf166ff94c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/", response="fc5a1a06efd0d00222375064cc5031b2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.0',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.0',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.0',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.0',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.0',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.0", response="dec63937e066878c3a09a702190d88d4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.1',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.1',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.1',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.1',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.1", response="97e40f8cbdee3a3dfe2de890af41f2c8", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.2',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.2", response="73373739a02c5b9899c16857805910c1", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.3',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.3',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.3',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.3',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.3',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.3", response="fd82e29c5d7ceb2f980d34650cc0aef5", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.4',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.4',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.4',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.4',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.4',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.4", response="4b238f6bf65b4007920add679621aa7d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.5',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.5',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.5',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.5',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.5',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.5", response="c0b37f72e4e21963be9e783831f727d9", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.6',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.6',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.6',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.6',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.6',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.6", response="9ebd3118ec928de8745f98fd09b92cdc", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.7',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.7',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.7',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.7',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.7',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.7", response="8da634568badbc4b08dd4d7f05c628ec", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.8',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.8',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.8',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.8',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.8',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.8", response="b987e16350e00f0f377c50e8be0bb00f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/foo.9',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/foo.9',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.9',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.9',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/foo.9',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/foo.9", response="035104dfce3aed8af31c32ff144659ca", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/subcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/subcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/subcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/subcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/subcoll/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/subcoll/", response="6f7eaaf53574e8f6d9a68fc6996e44bf", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvnoncoll',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest2/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest2/", response="241e59f747d0435cf0714daf166ff94c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest/", response="e71bdfc0251ff5dc82b33a51bb9f76ed", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvdest2/',
        'PHP_SELF' => '/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvdest2/", response="5f07a8f796feeb88d17f9370944740fb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/mvnoncoll',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/mvnoncoll',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/mvnoncoll',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/mvnoncoll',
        'PHP_SELF' => '/secure_collection/litmus/mvnoncoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="fa24be90773b643555294fb9d4593cc0", uri="/secure_collection/litmus/mvnoncoll", response="83357746d8f626ab5f728e49127bf551", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
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
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  115 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/", response="00f1c09b56cfd88355a6e010cfa26442", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  116 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/", response="774a1098fb12da54a9f9e566b6f09879", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  119 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<getcontentlength xmlns="DAV:"/>
<getlastmodified xmlns="DAV:"/>
<displayname xmlns="DAV:"/>
<resourcetype xmlns="DAV:"/>
<foo xmlns="http://webdav.org/neon/litmus/"/>
<bar xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '302',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 4 (propfind_d0)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/", response="42ce79b37827d76bab730eaa9d9243ec", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/</D:href>
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
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:foo xmlns="http://webdav.org/neon/litmus/"/>
        <default:bar xmlns="http://webdav.org/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  120 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="09fe055ac2e800241822626eee5e8b7a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  121 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="ea986839a6eddb8f5da6bcdc6d21a282", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a9122f1cbaca7df5bce4e997d84bdc74',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  122 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><prop0 xmlns="http://webdav.org/neon/litmus/">value0</prop0></D:prop></D:set>
<D:set><D:prop><prop1 xmlns="http://webdav.org/neon/litmus/">value1</prop1></D:prop></D:set>
<D:set><D:prop><prop2 xmlns="http://webdav.org/neon/litmus/">value2</prop2></D:prop></D:set>
<D:set><D:prop><prop3 xmlns="http://webdav.org/neon/litmus/">value3</prop3></D:prop></D:set>
<D:set><D:prop><prop4 xmlns="http://webdav.org/neon/litmus/">value4</prop4></D:prop></D:set>
<D:set><D:prop><prop5 xmlns="http://webdav.org/neon/litmus/">value5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://webdav.org/neon/litmus/">value6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://webdav.org/neon/litmus/">value7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://webdav.org/neon/litmus/">value8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://webdav.org/neon/litmus/">value9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '1023',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 6 (propset)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="7377dc3e71fc0ad6d78ff4f615ea8c10", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  123 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://webdav.org/neon/litmus/"/>
<prop1 xmlns="http://webdav.org/neon/litmus/"/>
<prop2 xmlns="http://webdav.org/neon/litmus/"/>
<prop3 xmlns="http://webdav.org/neon/litmus/"/>
<prop4 xmlns="http://webdav.org/neon/litmus/"/>
<prop5 xmlns="http://webdav.org/neon/litmus/"/>
<prop6 xmlns="http://webdav.org/neon/litmus/"/>
<prop7 xmlns="http://webdav.org/neon/litmus/"/>
<prop8 xmlns="http://webdav.org/neon/litmus/"/>
<prop9 xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '568',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 7 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="da0bee63c25768bb46ea3440eff7978f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://webdav.org/neon/litmus/">value0</default:prop0>
        <default:prop1 xmlns="http://webdav.org/neon/litmus/">value1</default:prop1>
        <default:prop2 xmlns="http://webdav.org/neon/litmus/">value2</default:prop2>
        <default:prop3 xmlns="http://webdav.org/neon/litmus/">value3</default:prop3>
        <default:prop4 xmlns="http://webdav.org/neon/litmus/">value4</default:prop4>
        <default:prop5 xmlns="http://webdav.org/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://webdav.org/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://webdav.org/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://webdav.org/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://webdav.org/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  124 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns="DAV:"><foobar/><allprop/></propfind>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '92',
        'HTTP_X_LITMUS' => 'props: 8 (propextended)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="da0bee63c25768bb46ea3440eff7978f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'The HTTP request body received for HTTP method \'PROPFIND\' was invalid. Reason: XML element <foobar /> is not a valid child element for <propfind />.',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '148',
      ),
      'status' => 'HTTP/1.1 400 Bad Request',
    ),
  ),
  125 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="1fb56000cff1ba68132d96921232bde3", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  126 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="79242208b8811b0aa0395a45d9958c93", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  127 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://webdav.org/neon/litmus/"/>
<prop1 xmlns="http://webdav.org/neon/litmus/"/>
<prop2 xmlns="http://webdav.org/neon/litmus/"/>
<prop3 xmlns="http://webdav.org/neon/litmus/"/>
<prop4 xmlns="http://webdav.org/neon/litmus/"/>
<prop5 xmlns="http://webdav.org/neon/litmus/"/>
<prop6 xmlns="http://webdav.org/neon/litmus/"/>
<prop7 xmlns="http://webdav.org/neon/litmus/"/>
<prop8 xmlns="http://webdav.org/neon/litmus/"/>
<prop9 xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '568',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 10 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://webdav.org/neon/litmus/">value0</default:prop0>
        <default:prop1 xmlns="http://webdav.org/neon/litmus/">value1</default:prop1>
        <default:prop2 xmlns="http://webdav.org/neon/litmus/">value2</default:prop2>
        <default:prop3 xmlns="http://webdav.org/neon/litmus/">value3</default:prop3>
        <default:prop4 xmlns="http://webdav.org/neon/litmus/">value4</default:prop4>
        <default:prop5 xmlns="http://webdav.org/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://webdav.org/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://webdav.org/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://webdav.org/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://webdav.org/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  128 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:remove><D:prop><prop0 xmlns="http://webdav.org/neon/litmus/"></prop0></D:prop></D:remove>
<D:remove><D:prop><prop1 xmlns="http://webdav.org/neon/litmus/"></prop1></D:prop></D:remove>
<D:remove><D:prop><prop2 xmlns="http://webdav.org/neon/litmus/"></prop2></D:prop></D:remove>
<D:remove><D:prop><prop3 xmlns="http://webdav.org/neon/litmus/"></prop3></D:prop></D:remove>
<D:remove><D:prop><prop4 xmlns="http://webdav.org/neon/litmus/"></prop4></D:prop></D:remove>
<D:set><D:prop><prop5 xmlns="http://webdav.org/neon/litmus/">value5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://webdav.org/neon/litmus/">value6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://webdav.org/neon/litmus/">value7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://webdav.org/neon/litmus/">value8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://webdav.org/neon/litmus/">value9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '1023',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 11 (propdeletes)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  129 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://webdav.org/neon/litmus/"/>
<prop1 xmlns="http://webdav.org/neon/litmus/"/>
<prop2 xmlns="http://webdav.org/neon/litmus/"/>
<prop3 xmlns="http://webdav.org/neon/litmus/"/>
<prop4 xmlns="http://webdav.org/neon/litmus/"/>
<prop5 xmlns="http://webdav.org/neon/litmus/"/>
<prop6 xmlns="http://webdav.org/neon/litmus/"/>
<prop7 xmlns="http://webdav.org/neon/litmus/"/>
<prop8 xmlns="http://webdav.org/neon/litmus/"/>
<prop9 xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '568',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 12 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop5 xmlns="http://webdav.org/neon/litmus/">value5</default:prop5>
        <default:prop6 xmlns="http://webdav.org/neon/litmus/">value6</default:prop6>
        <default:prop7 xmlns="http://webdav.org/neon/litmus/">value7</default:prop7>
        <default:prop8 xmlns="http://webdav.org/neon/litmus/">value8</default:prop8>
        <default:prop9 xmlns="http://webdav.org/neon/litmus/">value9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop1 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop2 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop3 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop4 xmlns="http://webdav.org/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  130 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:remove><D:prop><prop0 xmlns="http://webdav.org/neon/litmus/"></prop0></D:prop></D:remove>
<D:remove><D:prop><prop1 xmlns="http://webdav.org/neon/litmus/"></prop1></D:prop></D:remove>
<D:remove><D:prop><prop2 xmlns="http://webdav.org/neon/litmus/"></prop2></D:prop></D:remove>
<D:remove><D:prop><prop3 xmlns="http://webdav.org/neon/litmus/"></prop3></D:prop></D:remove>
<D:remove><D:prop><prop4 xmlns="http://webdav.org/neon/litmus/"></prop4></D:prop></D:remove>
<D:set><D:prop><prop5 xmlns="http://webdav.org/neon/litmus/">newvalue5</prop5></D:prop></D:set>
<D:set><D:prop><prop6 xmlns="http://webdav.org/neon/litmus/">newvalue6</prop6></D:prop></D:set>
<D:set><D:prop><prop7 xmlns="http://webdav.org/neon/litmus/">newvalue7</prop7></D:prop></D:set>
<D:set><D:prop><prop8 xmlns="http://webdav.org/neon/litmus/">newvalue8</prop8></D:prop></D:set>
<D:set><D:prop><prop9 xmlns="http://webdav.org/neon/litmus/">newvalue9</prop9></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '1038',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 13 (propreplace)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  131 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<prop0 xmlns="http://webdav.org/neon/litmus/"/>
<prop1 xmlns="http://webdav.org/neon/litmus/"/>
<prop2 xmlns="http://webdav.org/neon/litmus/"/>
<prop3 xmlns="http://webdav.org/neon/litmus/"/>
<prop4 xmlns="http://webdav.org/neon/litmus/"/>
<prop5 xmlns="http://webdav.org/neon/litmus/"/>
<prop6 xmlns="http://webdav.org/neon/litmus/"/>
<prop7 xmlns="http://webdav.org/neon/litmus/"/>
<prop8 xmlns="http://webdav.org/neon/litmus/"/>
<prop9 xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '568',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 14 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop5 xmlns="http://webdav.org/neon/litmus/">newvalue5</default:prop5>
        <default:prop6 xmlns="http://webdav.org/neon/litmus/">newvalue6</default:prop6>
        <default:prop7 xmlns="http://webdav.org/neon/litmus/">newvalue7</default:prop7>
        <default:prop8 xmlns="http://webdav.org/neon/litmus/">newvalue8</default:prop8>
        <default:prop9 xmlns="http://webdav.org/neon/litmus/">newvalue9</default:prop9>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:prop0 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop1 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop2 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop3 xmlns="http://webdav.org/neon/litmus/"/>
        <default:prop4 xmlns="http://webdav.org/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  132 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns="DAV:"><set><prop><nonamespace xmlns="">randomvalue</nonamespace></prop></set></propertyupdate>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '156',
        'HTTP_X_LITMUS' => 'props: 15 (propnullns)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  133 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<nonamespace xmlns=""/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '112',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 16 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat>
      <D:prop>
        <nonamespace xmlns="">randomvalue</nonamespace>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  134 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><high-unicode xmlns=\'http://webdav.org/neon/litmus/\'>&#65536;</high-unicode></prop></set></propertyupdate>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '185',
        'HTTP_X_LITMUS' => 'props: 17 (prophighunicode)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  135 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<high-unicode xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '143',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 18 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:high-unicode xmlns="http://webdav.org/neon/litmus/">𐀀</default:high-unicode>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  136 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><remove><prop><removeset xmlns=\'http://webdav.org/neon/litmus/\'/></prop></remove><set><prop><removeset xmlns=\'http://webdav.org/neon/litmus/\'>x</removeset></prop></set><set><prop><removeset xmlns=\'http://webdav.org/neon/litmus/\'>y</removeset></prop></set></propertyupdate>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '340',
        'HTTP_X_LITMUS' => 'props: 19 (propremoveset)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  137 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<removeset xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '140',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 20 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:removeset xmlns="http://webdav.org/neon/litmus/">y</default:removeset>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  138 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><removeset xmlns=\'http://webdav.org/neon/litmus/\'>x</removeset></prop></set><remove><prop><removeset xmlns=\'http://webdav.org/neon/litmus/\'/></prop></remove></propertyupdate>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '253',
        'HTTP_X_LITMUS' => 'props: 21 (propsetremove)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  139 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<removeset xmlns="http://webdav.org/neon/litmus/"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '140',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 22 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://webdav.org/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:default="http://webdav.org/neon/litmus/">
      <D:prop>
        <default:removeset xmlns="http://webdav.org/neon/litmus/"/>
      </D:prop>
      <D:status>HTTP/1.1 404 Not Found</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  140 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propertyupdate xmlns=\'DAV:\'><set><prop><t:valnspace xmlns:t=\'http://webdav.org/neon/litmus/\'><foo xmlns=\'bar\'/></t:valnspace></prop></set></propertyupdate>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '195',
        'HTTP_X_LITMUS' => 'props: 23 (propvalnspace)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="efe1e8e55055c82c9601a792434f6452", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  141 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?><propfind xmlns=\'DAV:\'><prop><valnspace xmlns=\'http://webdav.org/neon/litmus/\'/></prop></propfind>',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop2',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '137',
        'HTTP_X_LITMUS' => 'props: 24 (propwformed)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop2',
        'PHP_SELF' => '/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop2", response="71d240d89176ac9d04ab4a66fc689191", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:t="http://webdav.org/neon/litmus/" xmlns:default="bar">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
    <D:propstat xmlns:t="http://webdav.org/neon/litmus/" xmlns:default="bar">
      <D:prop>
        <t:valnspace xmlns:t="http://webdav.org/neon/litmus/" xmlns:default="bar">
          <default:foo xmlns="bar"/>
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
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  142 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="09fe055ac2e800241822626eee5e8b7a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  143 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="ea986839a6eddb8f5da6bcdc6d21a282", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a9122f1cbaca7df5bce4e997d84bdc74',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  144 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><somename xmlns="alpha">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="beta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="gamma">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="delta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="epsilon">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="zeta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="eta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="theta">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="iota">manynsvalue</somename></D:prop></D:set>
<D:set><D:prop><somename xmlns="kappa">manynsvalue</somename></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '880',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 26 (propmanyns)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="7377dc3e71fc0ad6d78ff4f615ea8c10", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  145 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<propfind xmlns="DAV:"><prop>
<somename xmlns="alpha"/>
<somename xmlns="beta"/>
<somename xmlns="gamma"/>
<somename xmlns="delta"/>
<somename xmlns="epsilon"/>
<somename xmlns="zeta"/>
<somename xmlns="eta"/>
<somename xmlns="theta"/>
<somename xmlns="iota"/>
<somename xmlns="kappa"/>
</prop></propfind>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '345',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'props: 27 (propget)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="da0bee63c25768bb46ea3440eff7978f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="alpha" xmlns:default1="beta" xmlns:default2="gamma" xmlns:default3="delta" xmlns:default4="epsilon" xmlns:default5="zeta" xmlns:default6="eta" xmlns:default7="theta" xmlns:default8="iota" xmlns:default9="kappa">
    <D:href>http://webdav/secure_collection/litmus/prop</D:href>
    <D:propstat xmlns:default="alpha" xmlns:default1="beta" xmlns:default2="gamma" xmlns:default3="delta" xmlns:default4="epsilon" xmlns:default5="zeta" xmlns:default6="eta" xmlns:default7="theta" xmlns:default8="iota" xmlns:default9="kappa">
      <D:prop>
        <default:somename xmlns="alpha">manynsvalue</default:somename>
        <default1:somename xmlns="beta">manynsvalue</default1:somename>
        <default2:somename xmlns="gamma">manynsvalue</default2:somename>
        <default3:somename xmlns="delta">manynsvalue</default3:somename>
        <default4:somename xmlns="epsilon">manynsvalue</default4:somename>
        <default5:somename xmlns="zeta">manynsvalue</default5:somename>
        <default6:somename xmlns="eta">manynsvalue</default6:somename>
        <default7:somename xmlns="theta">manynsvalue</default7:somename>
        <default8:somename xmlns="iota">manynsvalue</default8:somename>
        <default9:somename xmlns="kappa">manynsvalue</default9:somename>
      </D:prop>
      <D:status>HTTP/1.1 200 OK</D:status>
    </D:propstat>
  </D:response>
</D:multistatus>
',
      'headers' => 
      array (
        'Content-Type' => 'text/xml; charset="utf-8"',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  146 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/prop',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/prop',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 28 (propcleanup)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/prop',
        'PHP_SELF' => '/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f4033bd8003fd549031694541ece1025", uri="/secure_collection/litmus/prop", response="09fe055ac2e800241822626eee5e8b7a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  147 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  148 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/", response="03c60e5d0cfa2fe41a60d670645ea840", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  149 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/", response="9a9cd4445a42bf40579ff6d94ac29acd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  150 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 2 (options)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'OPTIONS',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/", response="ba8d587f2f3c89d9fea8be60e6c9c42e", algorithm="MD5"',
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
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  151 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 5 (put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  152 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 5 (put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/notlocked", response="4b75b0e1159cc802fe1324777f368b32", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '6bf84aac44485ddfc27ee8acae94637b',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  153 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>litmus test suite</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '174',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-3600',
        'HTTP_X_LITMUS' => 'locks: 6 (lock_excl)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="cf8e1844386b49a1c447327314f6f01f", algorithm="MD5"',
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
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:13+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  154 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS' => 'locks: 7 (discover)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="05ea8167fa97e140df073d976f2fe92a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
    <D:href>http://webdav/secure_collection/litmus/lockme</D:href>
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
            <D:depth>0</D:depth>
            <D:owner>litmus test suite</D:owner>
            <D:timeout>Second-900</D:timeout>
            <D:locktoken>
              <D:href>opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc</D:href>
            </D:locktoken>
            <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:13+01:00</ezclock:lastaccess>
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
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  155 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc>)',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS' => 'locks: 8 (refresh)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="cf8e1844386b49a1c447327314f6f01f", algorithm="MD5"',
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
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:13+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  156 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  157 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="8826a789beebcad7e3abbb4d2be8152d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  158 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/whocares',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="55a800e291506adee560aef72fa922eb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  159 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/notlocked", response="f73f43a785e1020819e182fd7984bed7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  160 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><random xmlns="http://webdav.org/neon/litmus/">foobar</random></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '188',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="d361dfba7027684fc73e46da8f0cf60f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  161 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS_SECOND' => 'locks: 9 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="ef8c39f5dbfbab5964fbf57e37c48cce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  162 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:foobar>',
        'HTTP_X_LITMUS_SECOND' => 'locks: 10 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="24700c9329fd2585fa59b2eb1139ab4a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'Authorization failed.',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 403 Forbidden',
    ),
  ),
  163 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>notowner lock</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '170',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS_SECOND' => 'locks: 10 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="17bc4284a14a4fef151cc54d0254539c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  164 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 11 (owner_modify)',
        'HTTP_IF' => '<http://webdav/secure_collection/litmus/lockme> (<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc>)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  165 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 12 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="8826a789beebcad7e3abbb4d2be8152d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  166 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/whocares',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS_SECOND' => 'locks: 12 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="55a800e291506adee560aef72fa922eb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  167 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 12 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/notlocked", response="f73f43a785e1020819e182fd7984bed7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  168 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><random xmlns="http://webdav.org/neon/litmus/">foobar</random></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '188',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 12 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="d361dfba7027684fc73e46da8f0cf60f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  169 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS_SECOND' => 'locks: 12 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="ef8c39f5dbfbab5964fbf57e37c48cce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  170 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:foobar>',
        'HTTP_X_LITMUS_SECOND' => 'locks: 13 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="24700c9329fd2585fa59b2eb1139ab4a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'Authorization failed.',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 403 Forbidden',
    ),
  ),
  171 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>notowner lock</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '170',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS_SECOND' => 'locks: 13 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="17bc4284a14a4fef151cc54d0254539c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  172 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme-copydest',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 14 (copy)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme-copydest',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme-copydest',
        'PHP_SELF' => '/secure_collection/litmus/lockme-copydest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme-copydest", response="5abe7b96db31bda2ef404cda510a9ad4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 404 Not Found',
    ),
  ),
  173 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockme-copydest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 14 (copy)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="6cb5128932ce78568d8049c61b6beb22", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  174 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme-copydest',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'CONTENT_LENGTH' => '118',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 14 (copy)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPFIND',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme-copydest',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme-copydest',
        'PHP_SELF' => '/secure_collection/litmus/lockme-copydest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme-copydest", response="ba48160f66cf0f888f6bfffead57f69d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/secure_collection/litmus/lockme-copydest</D:href>
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
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
      ),
      'status' => 'HTTP/1.1 207 Multi-Status',
    ),
  ),
  175 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme-copydest',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 14 (copy)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme-copydest',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme-copydest',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme-copydest',
        'PHP_SELF' => '/secure_collection/litmus/lockme-copydest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme-copydest", response="5abe7b96db31bda2ef404cda510a9ad4", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  176 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 15 (cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'HEAD',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="75c56b7e7bed21bea5e23c2b9fe4bb39", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  177 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc> [97d24b068864526eda737927f9910618])',
        'HTTP_X_LITMUS' => 'locks: 15 (cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  178 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 16 (fail_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'HEAD',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="75c56b7e7bed21bea5e23c2b9fe4bb39", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  179 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<DAV:no-lock> [97d24b068864526eda737927f9910618])',
        'HTTP_X_LITMUS' => 'locks: 16 (fail_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  180 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc>) (Not <DAV:no-lock>)',
        'HTTP_X_LITMUS' => 'locks: 17 (cond_put_with_not)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  181 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0ccx>) (Not <DAV:no-lock>)',
        'HTTP_X_LITMUS' => 'locks: 18 (cond_put_corrupt_token)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  182 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 19 (complex_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'HEAD',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="75c56b7e7bed21bea5e23c2b9fe4bb39", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  183 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc> [97d24b068864526eda737927f9910618]) (Not <DAV:no-lock> [97d24b068864526eda737927f9910618])',
        'HTTP_X_LITMUS' => 'locks: 19 (complex_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  184 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 20 (fail_complex_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'HEAD',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="75c56b7e7bed21bea5e23c2b9fe4bb39", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  185 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc> [97d24b068864526eda737927f9910718]) (Not <DAV:no-lock> [97d24b068864526eda737927f9910718])',
        'HTTP_X_LITMUS' => 'locks: 20 (fail_complex_cond_put)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  186 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:4ff9c6f1-8d62-f50d-a393-187844c0f0cc>',
        'HTTP_X_LITMUS' => 'locks: 21 (unlock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="a83f49210477f27f9414ddd91b1026d6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  187 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_IF' => '(<DAV:no-lock>)',
        'HTTP_X_LITMUS' => 'locks: 22 (fail_cond_put_unlocked)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 412 Precondition Failed',
    ),
  ),
  188 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><shared/></lockscope>
<locktype><write/></locktype><owner>litmus test suite</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '171',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-3600',
        'HTTP_X_LITMUS' => 'locks: 23 (lock_shared)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="cf8e1844386b49a1c447327314f6f01f", algorithm="MD5"',
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
        <D:shared/>
      </D:lockscope>
      <D:depth>0</D:depth>
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:73a6c1b0-c53b-94d1-8d41-bb095ecba3f8</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:14+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:73a6c1b0-c53b-94d1-8d41-bb095ecba3f8',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  189 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 24 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="8826a789beebcad7e3abbb4d2be8152d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  190 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/whocares',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS_SECOND' => 'locks: 24 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="55a800e291506adee560aef72fa922eb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  191 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 24 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/notlocked", response="f73f43a785e1020819e182fd7984bed7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  192 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><random xmlns="http://webdav.org/neon/litmus/">foobar</random></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '188',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 24 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="d361dfba7027684fc73e46da8f0cf60f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  193 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS_SECOND' => 'locks: 24 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="ef8c39f5dbfbab5964fbf57e37c48cce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  194 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:foobar>',
        'HTTP_X_LITMUS_SECOND' => 'locks: 25 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="24700c9329fd2585fa59b2eb1139ab4a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'Authorization failed.',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 403 Forbidden',
    ),
  ),
  195 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>notowner lock</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '170',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS_SECOND' => 'locks: 25 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="17bc4284a14a4fef151cc54d0254539c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  196 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 26 (owner_modify)',
        'HTTP_IF' => '<http://webdav/secure_collection/litmus/lockme> (<opaquelocktoken:73a6c1b0-c53b-94d1-8d41-bb095ecba3f8>)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="97c64f87d0cfb56b24ead35d17e41169", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '97d24b068864526eda737927f9910618',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  197 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><shared/></lockscope>
<locktype><write/></locktype><owner>litmus: notowner_sharedlock</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '181',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS_SECOND' => 'locks: 27 (double_sharedlock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="17bc4284a14a4fef151cc54d0254539c", algorithm="MD5"',
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
        <D:shared/>
      </D:lockscope>
      <D:depth>0</D:depth>
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:73a6c1b0-c53b-94d1-8d41-bb095ecba3f8</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:15+01:00</ezclock:lastaccess>
    </D:activelock>
    <D:activelock xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">
      <D:locktype>
        <D:write/>
      </D:locktype>
      <D:lockscope>
        <D:shared/>
      </D:lockscope>
      <D:depth>0</D:depth>
      <D:owner>litmus: notowner_sharedlock</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:cb52782d-404f-724e-306d-3dc5165e6a39</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:15+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:cb52782d-404f-724e-306d-3dc5165e6a39',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  198 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:cb52782d-404f-724e-306d-3dc5165e6a39>',
        'HTTP_X_LITMUS_SECOND' => 'locks: 27 (double_sharedlock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="24700c9329fd2585fa59b2eb1139ab4a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  199 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 28 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="8826a789beebcad7e3abbb4d2be8152d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  200 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/whocares',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS_SECOND' => 'locks: 28 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="55a800e291506adee560aef72fa922eb", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  201 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 28 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/notlocked", response="f73f43a785e1020819e182fd7984bed7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  202 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><random xmlns="http://webdav.org/neon/litmus/">foobar</random></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '188',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 28 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="d361dfba7027684fc73e46da8f0cf60f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  203 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS_SECOND' => 'locks: 28 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="ef8c39f5dbfbab5964fbf57e37c48cce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  204 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:foobar>',
        'HTTP_X_LITMUS_SECOND' => 'locks: 29 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="24700c9329fd2585fa59b2eb1139ab4a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => 'Authorization failed.',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 403 Forbidden',
    ),
  ),
  205 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>notowner lock</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '170',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => '0',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS_SECOND' => 'locks: 29 (notowner_lock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockme", response="17bc4284a14a4fef151cc54d0254539c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  206 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockme',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockme',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:73a6c1b0-c53b-94d1-8d41-bb095ecba3f8>',
        'HTTP_X_LITMUS' => 'locks: 30 (unlock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockme',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockme',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockme',
        'PHP_SELF' => '/secure_collection/litmus/lockme',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockme", response="a83f49210477f27f9414ddd91b1026d6", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  207 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'locks: 31 (prep_collection)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/", response="38a302ca601b09afffb9a94f99a8f142", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  208 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8"?>
<lockinfo xmlns=\'DAV:\'>
 <lockscope><exclusive/></lockscope>
<locktype><write/></locktype><owner>litmus test suite</owner>
</lockinfo>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '174',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_TIMEOUT' => 'Second-3600',
        'HTTP_X_LITMUS' => 'locks: 32 (lock_collection)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/", response="80f0abcdb41ebbbd961c15868e06fc73", algorithm="MD5"',
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
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:16+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Lock-Token' => 'opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  209 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 32 (lock_collection)',
        'HTTP_IF' => '<http://webdav/secure_collection/litmus/lockcoll/> (<opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe>)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="9618ba0388f93a0086d577ed44882895", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'c09a883cd9e3f31bb1ddc9a0e2ffa3f6',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  210 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS' => 'locks: 33 (owner_modify)',
        'HTTP_IF' => '<http://webdav/secure_collection/litmus/lockcoll/> (<opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe>)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="9618ba0388f93a0086d577ed44882895", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'c09a883cd9e3f31bb1ddc9a0e2ffa3f6',
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  211 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS_SECOND' => 'locks: 34 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="3edc65766959c14dd9fc319b9d15136e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  212 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/whocares',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_X_LITMUS_SECOND' => 'locks: 34 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MOVE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="408cd3e424c09efcf3d0a9ac8fc7c281", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  213 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/notlocked',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/notlocked',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_X_LITMUS_SECOND' => 'locks: 34 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'COPY',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/notlocked',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/notlocked',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/notlocked',
        'PHP_SELF' => '/secure_collection/litmus/notlocked',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/notlocked", response="f73f43a785e1020819e182fd7984bed7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  214 => 
  array (
    'request' => 
    array (
      'body' => '<?xml version="1.0" encoding="utf-8" ?>
<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop><random xmlns="http://webdav.org/neon/litmus/">foobar</random></D:prop></D:set>
</D:propertyupdate>
',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '188',
        'CONTENT_TYPE' => 'application/xml',
        'HTTP_X_LITMUS_SECOND' => 'locks: 34 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PROPPATCH',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="3d639170b4dd371b16411ed11a6f2a5a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  215 => 
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
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'CONTENT_LENGTH' => '32',
        'HTTP_X_LITMUS_SECOND' => 'locks: 34 (notowner_modify)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'PUT',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="ec388cfe792da3aeadce245296a5a235", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="4b1457de9221b4c0124e98925ad29f0d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 423 Locked',
    ),
  ),
  216 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_IF' => '(<opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe>)',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS' => 'locks: 35 (refresh)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/", response="80f0abcdb41ebbbd961c15868e06fc73", algorithm="MD5"',
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
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe</D:href>
      </D:locktoken>
      <ezclock:lastaccess xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">2008-11-09T23:08:16+01:00</ezclock:lastaccess>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  217 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/lockme.txt',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_IF' => '(<opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe>)',
        'HTTP_TIMEOUT' => 'Second-900',
        'HTTP_X_LITMUS' => 'locks: 36 (indirect_refresh)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'LOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/lockme.txt',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/lockme.txt", response="259537af3dddb5e48560db71b3770a6f", algorithm="MD5"',
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
      <D:owner>litmus test suite</D:owner>
      <D:timeout>Second-900</D:timeout>
      <D:locktoken>
        <D:href>opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe</D:href>
      </D:locktoken>
      <ezclock:baseuri xmlns:ezclock="http://ezcomponents.org/s/Webdav#lock">/secure_collection/litmus/lockcoll</ezclock:baseuri>
    </D:activelock>
  </D:lockdiscovery>
</D:prop>
',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/xml; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  218 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/lockcoll/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_LOCK_TOKEN' => '<opaquelocktoken:543d5818-e56e-8ef6-30e7-e9b48de465fe>',
        'HTTP_X_LITMUS' => 'locks: 37 (unlock)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'UNLOCK',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/lockcoll/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/lockcoll/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/lockcoll/',
        'PHP_SELF' => '/secure_collection/litmus/lockcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="2f1174ab4bd94693f3e746e24cec54d8", uri="/secure_collection/litmus/lockcoll/", response="8a1dfe5f64f6edcdfa4607dadf047f90", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  219 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'http: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="27945306954ce26ffd1a6821c3cf3c9d", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  220 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_KEEP_ALIVE' => '',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'http: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'DELETE',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="27945306954ce26ffd1a6821c3cf3c9d", uri="/secure_collection/litmus/", response="9b0ce56bb20ef7fad0b1a8d775550e60", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 204 No Content',
    ),
  ),
  221 => 
  array (
    'request' => 
    array (
      'body' => '',
      'server' => 
      array (
        'SCRIPT_URL' => '/secure_collection/litmus/',
        'SCRIPT_URI' => 'http://webdav/secure_collection/litmus/',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.11 neon/0.26.3',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'http: 1 (begin)',
        'SERVER_SIGNATURE' => '<address>Apache Server at webdav Port 80</address>
',
        'SERVER_SOFTWARE' => 'Apache',
        'SERVER_NAME' => 'webdav',
        'SERVER_ADDR' => '127.0.0.1',
        'SERVER_PORT' => '80',
        'REMOTE_ADDR' => '127.0.0.1',
        'DOCUMENT_ROOT' => '/var/www/webdav/htdocs',
        'SERVER_ADMIN' => '[no address given]',
        'SCRIPT_FILENAME' => '/var/www/webdav/htdocs/index.php',
        'REMOTE_PORT' => '33458',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REQUEST_METHOD' => 'MKCOL',
        'QUERY_STRING' => '',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'SCRIPT_NAME' => '',
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/var/www/webdav/htdocs/index.php/secure_collection/litmus/',
        'PHP_SELF' => '/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="27945306954ce26ffd1a6821c3cf3c9d", uri="/secure_collection/litmus/", response="b228f943545da9c4ad9e12fe75c6fd4e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
);
?>