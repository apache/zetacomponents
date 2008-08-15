<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'      => '/a/a1',
            'REQUEST_METHOD'   => 'COPY',
            'HTTP_DESTINATION' => '/c/a1',
            // some:thing
            'HTTP_AUTHORIZATION' => 'Basic c29tZTp0aGluZw==',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 401 Unauthorized',
        'headers' => array(
            'WWW-Authenticate' => 'Basic realm="eZ Components WebDAV"',
            'Server'           => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'     => 'text/plain; charset="utf-8"',
            'Content-Length'   => '21',
        ),
        'body' => 'Authorization failed.',
    ),
);

?>
