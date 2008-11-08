<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'         => '/a/a2',
            'REQUEST_METHOD'      => 'HEAD',
            'HTTP_AUTHORIZATION'  => 'Basic Zm9vOmJhcg==',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 200 OK',
        'headers' => array(
            'ETag'           => '1b83dcfcbfa0cfe05fa0831197dc0cf8',
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'   => 'application/octet-stream; charset="utf-8"',
            'Content-Length' => '0',
        ),
        'body' => '',
    ),
);

?>
