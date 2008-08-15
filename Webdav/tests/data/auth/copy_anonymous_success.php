<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'      => '/b/b2',
            'REQUEST_METHOD'   => 'COPY',
            'HTTP_DESTINATION' => '/b/b1/bnew',
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
