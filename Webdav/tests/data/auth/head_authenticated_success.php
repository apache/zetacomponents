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
            'ETag'           => 'bb1b562b998c7ac02f579de380d5f22a',
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'   => 'application/octet-stream; charset="utf-8"',
            'Content-Length' => '0',
        ),
        'body' => '',
    ),
);

?>
