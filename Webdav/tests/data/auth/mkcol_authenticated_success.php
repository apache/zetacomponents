<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'         => '/b/bnew',
            'REQUEST_METHOD'      => 'MKCOL',
            // foo:bar
            'HTTP_AUTHORIZATION'  => 'Basic Zm9vOmJhcg==',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 201 Created',
        'headers' => array(
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Length' => '0',
        ),
        'body' => '',
    ),
);

?>
