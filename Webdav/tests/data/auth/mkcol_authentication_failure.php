<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'        => '/b/bnew',
            'REQUEST_METHOD'     => 'MKCOL',
            'HTTP_AUTHORIZATION' => 'Basic c29tZTppbmNvcnJlY3Q=',
        ),
        'body' => '',
    ),
    array(
        'status' => 'HTTP/1.1 401 Unauthorized',
        'headers' => array(
            'WWW-Authenticate' => array(
                'basic'  => 'Basic realm="eZ Components WebDAV"',
                'digest' => 'Digest realm="eZ Components WebDAV", nonce="testnonce", algorithm="MD5"',
            ),
            'Server'           => 'eZComponents/dev/ezcWebdavTransportTestMock',
            'Content-Type'     => 'text/plain; charset="utf-8"',
            'Content-Length'   => '22',
        ),
        'body' => 'Authentication failed.',
    ),
);

?>
