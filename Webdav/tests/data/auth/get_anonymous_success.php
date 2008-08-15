<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'    => '/c/c2',
            'REQUEST_METHOD' => 'GET',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 200 OK',
        'headers' => array(
            'ETag'         => '1f553d7c19eea5d2b0ed986c9eb63f3e',
            'Server'       => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type' => 'application/octet-stream; charset="utf-8"',
        ),
        'body' => 'c2',
    ),
);

?>
