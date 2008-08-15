<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'      => '/a/a2',
            'REQUEST_METHOD'   => 'COPY',
            'HTTP_DESTINATION' => '/a/a1/bnew',
            // some:thing
            'HTTP_AUTHORIZATION' => 'Basic c29tZTp0aGluZw==',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 201 Created',
        'headers' => array(
            'Server'       => 'eZComponents/dev/ezcWebdavTransportTestMock',
        ),
        'body' => '',
    ),
);

?>
