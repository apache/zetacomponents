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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", algorithm="MD5"',
        ),
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="7b61b920ca0334912a0c81061e9b77e0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="7b61b920ca0334912a0c81061e9b77e0", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="3568b454c6909faa8a9ca9aa73d47f05", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="3568b454c6909faa8a9ca9aa73d47f05", algorithm="MD5"',
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
  5 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'OPTIONS',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="4b4ede5afb44e5895bb5154baa403e0d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 2 (options)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/", response="4b4ede5afb44e5895bb5154baa403e0d", algorithm="MD5"',
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
  6 => 
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
        'PATH_INFO' => '/secure_collection/litmus/res',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '41',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res", response="b08cc58355b887f4e85b70a14045dbac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res", response="b08cc58355b887f4e85b70a14045dbac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '44175eb61c5d59d37803ff7826e91b7a',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  7 => 
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
        'PATH_INFO' => '/secure_collection/litmus/res',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res", response="00f7ceb9da82ec19966066b79d8fc466", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 3 (put_get)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res", response="00f7ceb9da82ec19966066b79d8fc466", algorithm="MD5"',
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
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
    ),
  ),
  8 => 
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
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '41',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="35840bbfa8a98c56b5b76d6532975b8d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="35840bbfa8a98c56b5b76d6532975b8d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '06e933a87b6c93205dce44415d9735c9',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
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
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'GET',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="5749ab286132f3b554c737e3e87d8452", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 4 (put_get_utf8_segment)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="5749ab286132f3b554c737e3e87d8452", algorithm="MD5"',
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
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'application/octet-stream; charset="utf-8"',
      ),
      'status' => 'HTTP/1.1 200 OK',
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
        'PATH_INFO' => '/secure_collection/litmus/409me/noparent.txt/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/409me/noparent.txt/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/409me/noparent.txt/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/409me/noparent.txt/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/409me/noparent.txt/", response="3a083da1d809741402a3f43113de58cd", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 5 (put_no_parent)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/409me/noparent.txt/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/409me/noparent.txt/", response="3a083da1d809741402a3f43113de58cd", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/res-€/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res-€/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res-%e2%82%ac/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac/", response="7346e62d900e163d0148b20fda40982c", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 6 (mkcol_over_plain)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res-€/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac/", response="7346e62d900e163d0148b20fda40982c", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/res-€',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/res-€',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/res-%e2%82%ac',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/res-%e2%82%ac',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="e579805f9ffd7c8d80eebbb635988fde", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 7 (delete)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/res-€',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/res-%e2%82%ac", response="e579805f9ffd7c8d80eebbb635988fde", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/404me',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/404me',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/404me',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/404me',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/404me", response="76a04ddcd8b6e71f50f77f95d5c07da1", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 8 (delete_null)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/404me',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/404me", response="76a04ddcd8b6e71f50f77f95d5c07da1", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/frag/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/", response="609ddaf13d56a1bf4e884abf19cbc763", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/", response="609ddaf13d56a1bf4e884abf19cbc763", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/frag/#ment',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/#ment", response="2ab96002d45bc200d0636e9d868f76e2", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/#ment", response="2ab96002d45bc200d0636e9d868f76e2", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/frag/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/frag/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/frag/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/frag/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/", response="ca357788ffbfeede96cdfac437e6bbbb", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 9 (delete_fragment)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/frag/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/frag/", response="ca357788ffbfeede96cdfac437e6bbbb", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="b7a1a5dcd4f1545ad2912aeef4f8831e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 10 (mkcol)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="b7a1a5dcd4f1545ad2912aeef4f8831e", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="b7a1a5dcd4f1545ad2912aeef4f8831e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 11 (mkcol_again)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="b7a1a5dcd4f1545ad2912aeef4f8831e", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/coll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/coll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/coll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/coll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="0b5ff553f553dbae884a0f0084bd29a5", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 12 (delete_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/coll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/coll/", response="0b5ff553f553dbae884a0f0084bd29a5", algorithm="MD5"',
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
  20 => 
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
        'PATH_INFO' => '/secure_collection/litmus/409me/noparent/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/409me/noparent/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/409me/noparent/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/409me/noparent/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/409me/noparent/", response="d44557db667bf7494c959ec5ec69abb8", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 13 (mkcol_no_parent)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/409me/noparent/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/409me/noparent/", response="d44557db667bf7494c959ec5ec69abb8", algorithm="MD5"',
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
  21 => 
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
        'PATH_INFO' => '/secure_collection/litmus/mkcolbody',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mkcolbody',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mkcolbody',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mkcolbody',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/mkcolbody", response="134217fca1be31506736c5de23cad497", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'basic: 14 (mkcol_with_body)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mkcolbody',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1e75584433ad434d46068d639c52091c", uri="/secure_collection/litmus/mkcolbody", response="134217fca1be31506736c5de23cad497", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", algorithm="MD5"',
        ),
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  23 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/", response="369a66771265e65c5bb4ad6c5ffba49b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/", response="369a66771265e65c5bb4ad6c5ffba49b", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/", response="7d355141c16906dbf64427bbec7cbde8", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/", response="7d355141c16906dbf64427bbec7cbde8", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="2564c124f907ee3194403b994a7a77d2", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="2564c124f907ee3194403b994a7a77d2", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '4d1325c64e5cf462a33309b65a38c868',
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
        'PATH_INFO' => '/secure_collection/litmus/copycoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copycoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copycoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll/", response="762ebb698a1d4507a938647c06b4b7be", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 2 (copy_init)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copycoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll/", response="762ebb698a1d4507a938647c06b4b7be", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 3 (copy_simple)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copydest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/copycoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 4 (copy_overwrite)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/nonesuch/foo',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 5 (copy_nodestcoll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="370bcfc73cd09f6e32ed1b0656a0e2d9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copysrc',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copysrc',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copysrc',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copysrc',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="88a0bd11fc86a23ede50644afb9956e1", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copysrc',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copysrc", response="88a0bd11fc86a23ede50644afb9956e1", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copydest',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copydest',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copydest',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copydest',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copydest", response="89c33f533444648bb072d24168d6e63e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copydest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copydest", response="89c33f533444648bb072d24168d6e63e", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/copycoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copycoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copycoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll", response="49f6f0abe238e5909167e94dd440461b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copycoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll", response="49f6f0abe238e5909167e94dd440461b", algorithm="MD5"',
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
  35 => 
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
        'PATH_INFO' => '/secure_collection/litmus/copycoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/copycoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/copycoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/copycoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll/", response="a51f28bf1c8936c198afbdb30c5a4bc0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 6 (copy_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/copycoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/copycoll/", response="a51f28bf1c8936c198afbdb30c5a4bc0", algorithm="MD5"',
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
  36 => 
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="c193ae66f27cb5c3264a4aea07f52765", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="c193ae66f27cb5c3264a4aea07f52765", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.0',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.0", response="bb8a9d64308f16e956cfb407d35e1407", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.0", response="bb8a9d64308f16e956cfb407d35e1407", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'b13013f87db0ab9a14d28a3a5026715c',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.1',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.1", response="5d16b2138966ba27f36efa1261b20cfa", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.1", response="5d16b2138966ba27f36efa1261b20cfa", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'cf36789987f452120fcd5b9db3c2dd86',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.2", response="0fd6f5134eacce359ca385d4b52fdd5f", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.2", response="0fd6f5134eacce359ca385d4b52fdd5f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '4369f5a48521d3826ec3d7436b2ac8f5',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.3',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.3", response="7224267b02f7b711c76c3a17849ab335", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.3", response="7224267b02f7b711c76c3a17849ab335", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '66ca212bee3d00de66d8270778ae5d95',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.4',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.4", response="4b03fc2d3337dd4b94239e1ea5cae491", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.4", response="4b03fc2d3337dd4b94239e1ea5cae491", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '7106c952281b335a81d72b7cea237d8d',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.5',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.5", response="9739fb9f02431ef4e7beced55b220cad", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.5", response="9739fb9f02431ef4e7beced55b220cad", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '991398d90f4221a97f60104c4e816831',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.6',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.6", response="b05dfe392a38b052c0e788c2714525ce", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.6", response="b05dfe392a38b052c0e788c2714525ce", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '1535a94ec67bb1499c692316aa73cbba',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.7',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.7", response="01703725e33c23b75e244c0fc3bd5c8a", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.7", response="01703725e33c23b75e244c0fc3bd5c8a", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '3ed93079551387c94413a3f8ce128efb',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.8',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.8", response="2bc8327531f37287330ce02b34e743f7", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.8", response="2bc8327531f37287330ce02b34e743f7", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '9c128b9dd4522b09dd81374e8b59b3cf',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo.9',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.9", response="c34558a8bbe10dfa6aeca914c0ff8a5c", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo.9", response="c34558a8bbe10dfa6aeca914c0ff8a5c", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '9f3c6d9f9a6351ad4908f7cfc45a113a',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/subcoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/subcoll/", response="13c67ab63a7269c8545c348a3fc9f2f8", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/subcoll/", response="13c67ab63a7269c8545c348a3fc9f2f8", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="27e6c812b869118c3b69ddc4ef6531be", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="27e6c812b869118c3b69ddc4ef6531be", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="ec1f22418c26b383da56fda32f58c3a8", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="ec1f22418c26b383da56fda32f58c3a8", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="3fe0b78261df7d9fae4451f0e0efa6cb", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="3fe0b78261df7d9fae4451f0e0efa6cb", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="e16379002cd80cf7401f2ad7f5de8946", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="e16379002cd80cf7401f2ad7f5de8946", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.0',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.0", response="2387478e4af310d8966fce128e162a1e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.0", response="2387478e4af310d8966fce128e162a1e", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.1',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.1", response="887834c3a9157eef6a9dd47f630ecb6c", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.1", response="887834c3a9157eef6a9dd47f630ecb6c", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.2", response="aa94d4875b5ecdef225fdfdd1700b0c9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.2", response="aa94d4875b5ecdef225fdfdd1700b0c9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.3',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.3", response="909f7ce7431a22585180b41805f47c33", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.3", response="909f7ce7431a22585180b41805f47c33", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.4',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.4", response="751ed0263777063cc6a65bd9c4d289b5", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.4", response="751ed0263777063cc6a65bd9c4d289b5", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.5',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.5", response="e0fd2ca1edf9b422e415ea7ffdcdc088", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.5", response="e0fd2ca1edf9b422e415ea7ffdcdc088", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.6',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.6", response="c2ef1c74bb82a903bba9c13b635b7e5f", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.6", response="c2ef1c74bb82a903bba9c13b635b7e5f", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.7',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.7", response="24064a8ac68ad7e23e572bf2d347c9f3", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.7", response="24064a8ac68ad7e23e572bf2d347c9f3", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.8',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.8", response="2806d8189e34db72d61600a347955333", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.8", response="2806d8189e34db72d61600a347955333", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/foo.9',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.9", response="3b756012e3b52e866b4890541eefd184", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/foo.9", response="3b756012e3b52e866b4890541eefd184", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/subcoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/subcoll/", response="25d3e537361bf177b447100cff61e336", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/subcoll/", response="25d3e537361bf177b447100cff61e336", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="27e6c812b869118c3b69ddc4ef6531be", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest2/", response="27e6c812b869118c3b69ddc4ef6531be", algorithm="MD5"',
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
  67 => 
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 7 (copy_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="c193ae66f27cb5c3264a4aea07f52765", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="c193ae66f27cb5c3264a4aea07f52765", algorithm="MD5"',
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
  69 => 
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/foo',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/foo',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/foo',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/foo',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo", response="7268727eec8f3fa7c8d6ca17a3f53e73", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/foo',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/foo", response="7268727eec8f3fa7c8d6ca17a3f53e73", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ffba400ab448987e283d7f7171dc7abd',
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => '0',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/ccdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="779e57a1190cb4ab030a52c7b37ede58", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/ccsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="e16379002cd80cf7401f2ad7f5de8946", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccsrc/", response="e16379002cd80cf7401f2ad7f5de8946", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/foo',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/foo',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/foo',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/foo',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/foo", response="f985ceb367a321ec4bc01183ef32f78e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/foo',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/foo", response="f985ceb367a321ec4bc01183ef32f78e", algorithm="MD5"',
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
  74 => 
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
        'PATH_INFO' => '/secure_collection/litmus/ccdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/ccdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/ccdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/ccdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 8 (copy_shallow)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/ccdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/ccdest/", response="d8844e278f606d076e9e2c7e6552938b", algorithm="MD5"',
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
  75 => 
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
        'PATH_INFO' => '/secure_collection/litmus/move',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/move',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/move',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/move',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move", response="ba1a8c959209911598d3e99d9c0b6dd0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/move',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move", response="ba1a8c959209911598d3e99d9c0b6dd0", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '857cfc6ed91de32ea0efaf80e4d9ec3e',
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
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="480755381a4823da9c3f0742f642be59", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="480755381a4823da9c3f0742f642be59", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '537dcae574f03b5cbbffbc4410bc97c0',
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
        'PATH_INFO' => '/secure_collection/litmus/movecoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/movecoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/movecoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/movecoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movecoll/", response="2c415509048a92d366e82f9f00804320", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/movecoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movecoll/", response="2c415509048a92d366e82f9f00804320", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/move',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/move',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/move',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/move',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move", response="f420a3cfa570867ee38a1ee96878624d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/move',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move", response="f420a3cfa570867ee38a1ee96878624d", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="4c0a392487db9ee7ec42aa96d03477a1", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="4c0a392487db9ee7ec42aa96d03477a1", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/move2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/move2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/move2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/move2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movedest',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="4c0a392487db9ee7ec42aa96d03477a1", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/move2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/move2", response="4c0a392487db9ee7ec42aa96d03477a1", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/movedest',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/movedest',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/movedest',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/movedest',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/movecoll/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movedest", response="d74a2f6f38965671635053044f459326", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/movedest',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movedest", response="d74a2f6f38965671635053044f459326", algorithm="MD5"',
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
  82 => 
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
        'PATH_INFO' => '/secure_collection/litmus/movecoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/movecoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/movecoll',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/movecoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movecoll", response="13d83dc0678ea0d59d6e6f87e24d04e3", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 9 (move)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/movecoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/movecoll", response="13d83dc0678ea0d59d6e6f87e24d04e3", algorithm="MD5"',
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
  83 => 
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="39933be15d54295cd87378bbf0709fe7", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="39933be15d54295cd87378bbf0709fe7", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.0',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.0", response="6b0e376369879d4e3b736f1390eb041e", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.0", response="6b0e376369879d4e3b736f1390eb041e", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '8fb8fe36390000586d641212924f9159',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.1',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.1", response="e5d50142aea46ad7abb4e650202994dd", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.1", response="e5d50142aea46ad7abb4e650202994dd", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a43c886c9b8b8a52fa9d9ae9d4e33f70',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.2", response="4359a6bb79015c00953f11ca44152f2d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.2", response="4359a6bb79015c00953f11ca44152f2d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a5d6796e685ce2cc313e16d3286ce9ec',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.3',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.3", response="503a373994469e1ffc06cb4d9c82768b", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.3", response="503a373994469e1ffc06cb4d9c82768b", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '32e73a199b082894e522b06d3fb678cb',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.4',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.4", response="f9988ee5518694ef7c93086f55f23983", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.4", response="f9988ee5518694ef7c93086f55f23983", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'dfa64616f97896969e04aa0a6015040d',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.5',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.5", response="93d556fe3aa43c7815697deae83cb17f", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.5", response="93d556fe3aa43c7815697deae83cb17f", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '675dcfdcbffae9a7c3c63854530000d6',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.6',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.6", response="39f3e9316080e27b24269d611faab4e8", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.6", response="39f3e9316080e27b24269d611faab4e8", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a60570ca8210953a8c3438d81d8b3bf2',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.7',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.7", response="74345a9f87e5f720d3c2134bdfeb840d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.7", response="74345a9f87e5f720d3c2134bdfeb840d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'e1d4346a9f79afa2363d8a9a1168855e',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.8',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.8", response="0777bdcc7ef59d8803f9ef8784000f67", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.8", response="0777bdcc7ef59d8803f9ef8784000f67", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'ee2139ed51a145edeac1eb8fb5847451',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/foo.9',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.9", response="0679debffde7dc2e3a93449ea61cdef0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/foo.9", response="0679debffde7dc2e3a93449ea61cdef0", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => '76a1b7d253e6487b4af20b10208482ad',
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
        'PATH_INFO' => '/secure_collection/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvnoncoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvnoncoll',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvnoncoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvnoncoll", response="62e54cb9c9f655dd892e6c588abdc3cc", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvnoncoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvnoncoll", response="62e54cb9c9f655dd892e6c588abdc3cc", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a16dbefbbfff804fcd1975f937c67def',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/subcoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/subcoll/", response="88c71fcf1bfe13d600a663b297253104", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/subcoll/", response="88c71fcf1bfe13d600a663b297253104", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="42cb1a9f76ba797d14db3bd50ee6959d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="42cb1a9f76ba797d14db3bd50ee6959d", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvsrc/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvsrc/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvsrc/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvsrc/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="3617f485c14b011c2bc8fa234300fdb0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvsrc/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvsrc/", response="3617f485c14b011c2bc8fa234300fdb0", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="8780d3496ed32b31bda79eba683dbeb2", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="8780d3496ed32b31bda79eba683dbeb2", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest/',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="a9a94f3d773cb8bc13c906da25a59457", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="a9a94f3d773cb8bc13c906da25a59457", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'COPY',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DEPTH' => 'infinity',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvdest2/',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="9ecee7b1b72b80e7948728d56790d4b3", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="9ecee7b1b72b80e7948728d56790d4b3", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.0',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.0',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.0',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.0',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.0", response="f8783b6ade728f64d8c2aef7e87c6ae4", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.0',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.0", response="f8783b6ade728f64d8c2aef7e87c6ae4", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.1',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.1',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.1',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.1',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.1", response="21ebdfb13a494bc677a7c7d8c4d1bd55", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.1',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.1", response="21ebdfb13a494bc677a7c7d8c4d1bd55", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.2", response="1248f9bc9a9ebaf652e994d7dc2ecde9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.2", response="1248f9bc9a9ebaf652e994d7dc2ecde9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.3',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.3',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.3',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.3',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.3", response="3d61cb1af72b2d22fb918bc5c74cc7bc", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.3',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.3", response="3d61cb1af72b2d22fb918bc5c74cc7bc", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.4',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.4',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.4',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.4',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.4", response="91c7f8d43cccee1165d7952aef0e5fb0", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.4',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.4", response="91c7f8d43cccee1165d7952aef0e5fb0", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.5',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.5',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.5',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.5',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.5", response="419c4153aacf9493a8e94de1385104e5", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.5',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.5", response="419c4153aacf9493a8e94de1385104e5", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.6',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.6',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.6',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.6',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.6", response="50c1cd839d407caae4245eec05990a3c", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.6',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.6", response="50c1cd839d407caae4245eec05990a3c", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.7',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.7',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.7',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.7',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.7", response="152710cdd927defd425ab12564279fa4", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.7',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.7", response="152710cdd927defd425ab12564279fa4", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.8',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.8',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.8',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.8',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.8", response="188bf2e20f840aaeb6473183b1a9f149", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.8',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.8", response="188bf2e20f840aaeb6473183b1a9f149", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/foo.9',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/foo.9',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/foo.9',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/foo.9',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.9", response="fe49c90362109b0ad61f5e1bf9f5eb29", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/foo.9',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/foo.9", response="fe49c90362109b0ad61f5e1bf9f5eb29", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/subcoll/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/subcoll/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/subcoll/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/subcoll/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/subcoll/", response="bdc74ee995027852a1fb249e56b963b9", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/subcoll/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/subcoll/", response="bdc74ee995027852a1fb249e56b963b9", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/mvnoncoll',
        'HTTP_OVERWRITE' => 'T',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="a9a94f3d773cb8bc13c906da25a59457", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 10 (move_coll)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="a9a94f3d773cb8bc13c906da25a59457", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="29ebbb71586bc9702aa9a0a7b2090eb3", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest/", response="29ebbb71586bc9702aa9a0a7b2090eb3", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvdest2/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvdest2/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvdest2/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvdest2/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="fc22611e47f85eb849518b812dbf9c94", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvdest2/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvdest2/", response="fc22611e47f85eb849518b812dbf9c94", algorithm="MD5"',
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
        'PATH_INFO' => '/secure_collection/litmus/mvnoncoll',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/mvnoncoll',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/mvnoncoll',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/mvnoncoll',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvnoncoll", response="65ffa980a9762dc966ae0e10314ce97a", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'copymove: 11 (move_cleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/mvnoncoll',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="386aed4d06b48dd6a7df272362343210", uri="/secure_collection/litmus/mvnoncoll", response="65ffa980a9762dc966ae0e10314ce97a", algorithm="MD5"',
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
  116 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
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
          'digest' => 'Digest realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", algorithm="MD5"',
        ),
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Type' => 'text/plain; charset="utf-8"',
        'Content-Length' => '21',
      ),
      'status' => 'HTTP/1.1 401 Unauthorized',
    ),
  ),
  117 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE, Keep-Alive',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="c0c8d16a8fb2e222bafa7ee7f03ac7a5", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="c0c8d16a8fb2e222bafa7ee7f03ac7a5", algorithm="MD5"',
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
  118 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MKCOL',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="b9e045e87ace20aef44c8549a6257b57", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 1 (begin)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="b9e045e87ace20aef44c8549a6257b57", algorithm="MD5"',
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
  119 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 2 (propfind_invalid)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
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
  120 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 3 (propfind_invalid2)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response>
    <D:href>http://webdav/secure_collection/litmus/</D:href>
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
  121 => 
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
        'PATH_INFO' => '/secure_collection/litmus/',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 4 (propfind_d0)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/", response="4c30fbc1f16b30277e2db117edcd3761", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
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
  122 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
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
  123 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="1bc879a9c8a392c6dfe1e0fab7be3570", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 5 (propinit)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="1bc879a9c8a392c6dfe1e0fab7be3570", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a9122f1cbaca7df5bce4e997d84bdc74',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  124 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="6ec26d899bad321923dbb29f8dcf3e1d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 6 (propset)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="6ec26d899bad321923dbb29f8dcf3e1d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop</D:href>
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
  125 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 7 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop</D:href>
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
  126 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '92',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 8 (propextended)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
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
  127 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="ca8d125119b984bd4647a022736f6ab6", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="ca8d125119b984bd4647a022736f6ab6", algorithm="MD5"',
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
  128 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'MOVE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_DESTINATION' => 'http://webdav/secure_collection/litmus/prop2',
        'HTTP_OVERWRITE' => 'F',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="ea4c5e1fe31cce6d1806ee985b5e9511", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 9 (propmove)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="ea4c5e1fe31cce6d1806ee985b5e9511", algorithm="MD5"',
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
  129 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 10 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  130 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 11 (propdeletes)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  131 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 12 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  132 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 13 (propreplace)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  133 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 14 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  136 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '186',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 17 (prophighunicode)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  137 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 18 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  138 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '343',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 19 (propremoveset)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  139 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 20 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  140 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '255',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 21 (propsetremove)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  141 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 22 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/neon/litmus/">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  142 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPPATCH',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '203',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 23 (propvalnspace)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="402db9c43d9496af4104867defa81d88", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  143 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop2',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop2',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop2',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop2',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PROPFIND',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '138',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 24 (propwformed)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop2',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop2", response="8fc521b7d007f97a9d27fd5aba0bc8ac", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:t="http://example.com/neon/litmus/" xmlns:default="http://bar">
    <D:href>http://webdav/secure_collection/litmus/prop2</D:href>
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
  144 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
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
  145 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'PUT',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_CONTENT_LENGTH' => '32',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="1bc879a9c8a392c6dfe1e0fab7be3570", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 25 (propinit)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="1bc879a9c8a392c6dfe1e0fab7be3570", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '',
      'headers' => 
      array (
        'ETag' => 'a9122f1cbaca7df5bce4e997d84bdc74',
        'Server' => 'lighttpd/1.4.22/eZComponents/dev/ezcWebdavTransportMock',
        'Content-Length' => 0,
      ),
      'status' => 'HTTP/1.1 201 Created',
    ),
  ),
  146 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="6ec26d899bad321923dbb29f8dcf3e1d", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 26 (propmanyns)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="6ec26d899bad321923dbb29f8dcf3e1d", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:">
  <D:href>http://webdav/secure_collection/litmus/prop</D:href>
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
  147 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
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
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 27 (propget)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="b90243fe6b8bc59cae0678e94a763c56", algorithm="MD5"',
        'REQUEST_TIME' => 1220431173,
      ),
    ),
    'response' => 
    array (
      'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:">
  <D:response xmlns:default="http://example.com/alpha" xmlns:default1="http://example.com/beta" xmlns:default2="http://example.com/gamma" xmlns:default3="http://example.com/delta" xmlns:default4="http://example.com/epsilon" xmlns:default5="http://example.com/zeta" xmlns:default6="http://example.com/eta" xmlns:default7="http://example.com/theta" xmlns:default8="http://example.com/iota" xmlns:default9="http://example.com/kappa">
    <D:href>http://webdav/secure_collection/litmus/prop</D:href>
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
  148 => 
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
        'PATH_INFO' => '/secure_collection/litmus/prop',
        'PATH_TRANSLATED' => '/home/dotxp/web/webdav/htdocs/secure_collection/litmus/prop',
        'SCRIPT_FILENAME' => '/home/dotxp/web/webdav/htdocs/index.php',
        'DOCUMENT_ROOT' => '/home/dotxp/web/webdav/htdocs/',
        'REQUEST_URI' => '/secure_collection/litmus/prop',
        'REDIRECT_URI' => '/index.php/secure_collection/litmus/prop',
        'QUERY_STRING' => '',
        'REQUEST_METHOD' => 'DELETE',
        'REDIRECT_STATUS' => '200',
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'HTTP_HOST' => 'webdav',
        'HTTP_USER_AGENT' => 'litmus/0.12.1 neon/0.28.4',
        'HTTP_CONNECTION' => 'TE',
        'HTTP_TE' => 'trailers',
        'HTTP_AUTHORIZATION' => 'Digest username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
        'HTTP_X_LITMUS' => 'props: 28 (propcleanup)',
        'PHP_SELF' => '/index.php/secure_collection/litmus/prop',
        'PHP_AUTH_DIGEST' => 'username="some", realm="eZ Components WebDAV", nonce="1430b72daca073a51c9867b8d2a252d6", uri="/secure_collection/litmus/prop", response="e42ae6b5e93f0dd287064f0c556e1c35", algorithm="MD5"',
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
