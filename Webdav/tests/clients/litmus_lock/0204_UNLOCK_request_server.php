<?php

return array (
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
);

?>