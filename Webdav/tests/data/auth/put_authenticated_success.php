<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'         => '/b/b2',
            'REQUEST_METHOD' => 'PUT',
            // foo:bar
            'HTTP_AUTHORIZATION'  => 'Basic Zm9vOmJhcg==',
            'CONTENT_TYPE'   => 'text/plain; charset="utf-8"',
            'HTTP_CONTENT_LENGTH' => '9',
        ),
        'body' => 'Some text',
    ),
    array(
        'status' => 'HTTP/1.1 201 Created',
        'headers' => array(
            'ETag'           => '6ff6aeaff8b5373cc3fb9799c409f350',
            'Server'         => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Length' => '0',
        ),
        'body' => '',
    ),
);

?>
