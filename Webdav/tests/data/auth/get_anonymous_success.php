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
            'ETag'         => '68ac210a7de0bf83cc80b339c67dbf4c',
            'Server'       => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type' => 'application/octet-stream; charset="utf-8"',
        ),
        'body' => 'c2',
    ),
);

?>
