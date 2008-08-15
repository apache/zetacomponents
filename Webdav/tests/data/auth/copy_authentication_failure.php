<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'      => '/b/b2',
            'REQUEST_METHOD'   => 'COPY',
            'HTTP_DESTINATION' => '/b/b1/bnew',
            'HTTP_AUTHORIZATION' => 'Basic c29tZTppbmNvcnJlY3Q=',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 401 Unauthorized',
        'headers' => array(
            'WWW-Authenticate' => 'Basic realm="eZ Components WebDAV"',
            'Server'           => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'     => 'text/plain; charset="utf-8"',
        ),
        'body' => 'Authentication failed.',
    ),
);

?>
