<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'        => '/a/anew',
            'REQUEST_METHOD'     => 'MKCOL',
            // foo:bar
            'HTTP_AUTHORIZATION' => 'Basic Zm9vOmJhcg==',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 403 Forbidden',
        'headers' => array(
            'Server'           => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'     => 'text/plain; charset="utf-8"',
            'Content-Length'   => '21',
        ),
        'body' => 'Authorization failed.',
    ),
);

?>
