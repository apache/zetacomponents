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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/", response="8db7407c49e9a79450c2f673f4ce7e62", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/", response="9d09311cf186722ddb3fec8b57fcc2cd", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/", response="1d675e8436bececa1a89178764f45fa6", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res", response="17c5253451c9d4f8e01dc04cff69f5e7", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res", response="c18237d8810c3ec1014ee5a6db95a509", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res-%e2%82%ac", response="3bd72a7e9d0c7ee0853b04e669be867b", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res-%e2%82%ac", response="a7eaed80bfec217fa56e7f01896bdfb1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res-%e2%82%ac/", response="31d6d65cf09b097262e3376a9cf335f1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/res-%e2%82%ac", response="66fadd81c2fb968864f4f086a826e2c7", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/404me", response="c26220a784a46e3686549a2b0b1940cf", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/frag/", response="a3c7dec2faca38812a732242fa88a0a1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/frag/#ment", response="2d7833b7d0fdea6701f6ec6d59b2e78a", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/frag/", response="f49fee969f47ad4fd831f39feeca4294", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/coll/", response="f523c0ebe124ea2aebb004e97be18fa1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/coll/", response="f523c0ebe124ea2aebb004e97be18fa1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/coll/", response="15c009fcfa89e7071d51b718c66b9ecb", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/409me/noparent/", response="d9d13d2760f081229ad8f92c87fb1373", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f637200cdde6116139c413d4f9aaf79d", uri="/secure_collection/litmus/mkcolbody", response="ead08686a134c854f26b729d7ba213c4", algorithm="MD5"',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/", response="71ef80265606774b4ea534a6ef50dc41", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/", response="64ee4c5e407392bd0c16e60ef5ec9220", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="3788b1c3e0f46c9297cfa30e6b365ec8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copycoll/", response="d348f0820d6056ab83f09c1e95044557", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="e405e1486e6be71445fbb50bf0ce9cc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="e405e1486e6be71445fbb50bf0ce9cc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="e405e1486e6be71445fbb50bf0ce9cc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="e405e1486e6be71445fbb50bf0ce9cc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="e405e1486e6be71445fbb50bf0ce9cc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copysrc", response="d6aed850c93cac5e198bb58f6c59f66a", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copydest", response="73906b81cb56854dcaca36dec3f740f5", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copycoll", response="089dbaa9b78689b00e486093f9426092", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/copycoll/", response="28615f65bfc3071714cb9b655c5b8bda", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="f092fcc7fda9ed08557ae96f0f4bc3d8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.0", response="eb70b230e6c581e7331f00ef9e9e08b7", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.1", response="b1a4ddff1ded5dfbea2cf41e1b5951f7", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.2", response="b0769973d372305f814f7f294c53ada3", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.3", response="4b53afc849649d77c7eeb632d2243db5", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.4", response="25081a80f82be4c953e801c3cd063200", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.5", response="b110cabdc5b2ce7b57af76eaa7628595", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.6", response="b3b624849450df4a420f74f83c60c674", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.7", response="42ad1b9bd1ecc93a4ec456d4ad57cbd4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.8", response="75a44d376244f244cfa8c018b763bd2d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo.9", response="a64bac30c4c94af3e4aa019396efe804", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/subcoll/", response="2c1fd48889af5f4337ff01c0d618938b", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/", response="68fa6fca7a6fdf9e478ef0c5e006b795", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest2/", response="8b7f21a8b940f08acfee2bc3b5e16c24", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="b4b36158b83be3e91e126e9dbb23a61d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="b4b36158b83be3e91e126e9dbb23a61d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/", response="f6d9ac3c6fbc997dc127f71fef3a55c1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest2/", response="05e156ba17fcf39ac8bf3379c4825483", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="a835d68a9ff9ab3f5e0ed44e1ddfcfe0", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.0", response="7897647846ac36d4612bb681f1b5a7f8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.1", response="0a523c1b8893123467025a696e6bbb7d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.2", response="84fb857b96bec712b031c5fd5ad3ef11", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.3", response="ddfe984eb5f7efd253b95065b92cca5e", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.4", response="0e5dcbf0e435783cb3f5038902186a51", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.5", response="df5a08a636d3358e08b7898eb2cfb9e9", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.6", response="576a5349c214a9baa293cbb7f6ab42cf", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.7", response="161e0f7dedb965b60120b28dc366a538", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.8", response="701fe0d86ff0c6516d7948218f245bbf", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/foo.9", response="b8491102d2c8fd11cffc2905cd365275", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/subcoll/", response="cb465448a1bcc76ad0cdfadec90dc3b8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest2/", response="8b7f21a8b940f08acfee2bc3b5e16c24", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/", response="68fa6fca7a6fdf9e478ef0c5e006b795", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="f092fcc7fda9ed08557ae96f0f4bc3d8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/foo", response="6ffd26329b0d553bec41f561c122e401", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/", response="68fa6fca7a6fdf9e478ef0c5e006b795", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="b4b36158b83be3e91e126e9dbb23a61d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccsrc/", response="a835d68a9ff9ab3f5e0ed44e1ddfcfe0", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/foo", response="781e138dbddcbf9ce60ee1400a70509c", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/ccdest/", response="68fa6fca7a6fdf9e478ef0c5e006b795", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/move", response="3f21856b35443172b505fe5c891ed46f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/move2", response="bbbe44b5a1bebba87afade55de500baf", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/movecoll/", response="b86edc52b63d048c5d0a33dc12045432", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/move", response="92137ffc459bad1424b13422b319fdf0", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/move2", response="05fcaa9e6f18c757a7897ad6d2b5f146", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/move2", response="05fcaa9e6f18c757a7897ad6d2b5f146", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/movedest", response="132961c4c05797d4027febca9ad51c56", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/movecoll", response="d6c6e1c027ad59261978fec5ca166f3e", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/", response="b70272a6ad6d9cc09c74d1900d9c420e", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.0", response="242e348b16a9cf1436ef06a69c76fdff", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.1", response="e097ff8942d7dcd4b333fa89f1b77fc5", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.2", response="223d58cd8fb20514df046537a5c50fe3", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.3", response="2b04ff939427678478f53ea70e4ca71b", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.4", response="a6ec154e812bc7a115c2f10f5051f8fe", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.5", response="a402a90083e46b81a41d56e8f2be5a8e", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.6", response="5bfbca1cb28f1d15a468eb2b531bd5bb", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.7", response="0b1d00b3e08571304eaf5e668cc6ecf1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.8", response="68fa21e1d4f3351b14a32cb40ba1c1b8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/foo.9", response="1607095ab73fe24f1143f0e08d1352ce", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvnoncoll", response="a21328a731cd1a5f6fa54845dae69460", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/subcoll/", response="4ba63edcaf27be45e784c2a6e224bd02", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/", response="fccdc2b4d4700b0c50f8f89aca8109b3", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvsrc/", response="5c716a79dbf98ac1eb5eb535bb6ca406", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/", response="74d69c25105ba0e111579cc4ff1966ad", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest2/", response="6af360be7aefd8d291e23368a2a2632c", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/", response="a135576af28d4bd685670a5b66169873", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.0", response="671dbd5391abb0f4e14ce7f58322d17d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.1", response="a15561be9d86a0eab3703265034a006f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.2", response="9c41f95eb460c0f11c74920d80695e18", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.3", response="47cbabe7c451ef58b6848f8f0913c226", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.4", response="258a9ebf2da1318d79c0affa15bf7b7a", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.5", response="7490c6515aec568a510d8fa45b56c207", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.6", response="a07cfa0697ded08c545746b8cc98cdd1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.7", response="00c885dc88a41372df35a2537d3ae12b", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.8", response="d4f03393415f272f854b6c21ab39bdc4", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/foo.9", response="852d45d6e345924fe6c330eea8158d91", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/subcoll/", response="fb8a2ab537d8f68520e55ace7ee75828", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest2/", response="6af360be7aefd8d291e23368a2a2632c", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest/", response="85e1efa4566e258290d865337307cff1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvdest2/", response="1f826f2cfa5ef191715b6e8dd8d4cfc1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="aca258a5b466258d817fef58969b8068", uri="/secure_collection/litmus/mvnoncoll", response="e1c8f950c06c539f54b10020ae8c691a", algorithm="MD5"',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/", response="27a70ebccd6651fd7816da4459e7c131", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/", response="0210a080624db3349e454f573060fea1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/", response="2d329b9f3c77d3c1777c639ec47b787d", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="6b963e910b023d154ea58e4d4335c7a8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="a0e66379013630b7995081cb8829b886", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="222aa16f03832785ed519e7a8f65defb", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="38688cffaaa9a66157dc575cef132ff8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="38688cffaaa9a66157dc575cef132ff8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="61726a3219fd5545aa6ad307ee061aa3", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="5d8db8c3d7970bd866c92b3a7dc8485a", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="027015e12fba610e095ae5d82b50a78f", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop2", response="dcc9f98ea3243d1e35cb85af3eec6864", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="6b963e910b023d154ea58e4d4335c7a8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="a0e66379013630b7995081cb8829b886", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="222aa16f03832785ed519e7a8f65defb", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="38688cffaaa9a66157dc575cef132ff8", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="239e21a09f7f51a22788cb78a9d99c2b", uri="/secure_collection/litmus/prop", response="6b963e910b023d154ea58e4d4335c7a8", algorithm="MD5"',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="d74eb93779f202a5af2e026959f3f9f1", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="d74eb93779f202a5af2e026959f3f9f1", uri="/secure_collection/litmus/", response="6040306ef8d839b71276981fb9e27e0c", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="d74eb93779f202a5af2e026959f3f9f1", uri="/secure_collection/litmus/", response="ee8546e0e3ecb6766e85c717f820a7e3", algorithm="MD5"',
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="d74eb93779f202a5af2e026959f3f9f1", uri="/secure_collection/litmus/", response="fe94beb94736c3e0fb94d24942e81f46", algorithm="MD5"',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="f2eb48215aa446a96fe00768e442bb02", algorithm="MD5"',
        ),
        'Server' => 'Apache/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  152 => 
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f2eb48215aa446a96fe00768e442bb02", uri="/secure_collection/litmus/", response="428e6b59e6da1cb8620e5edd4c872cbb", algorithm="MD5"',
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
  153 => 
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
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="f2eb48215aa446a96fe00768e442bb02", uri="/secure_collection/litmus/", response="8bad1fa3454d63747cead2084f2400be", algorithm="MD5"',
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