<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'         => '/b/b2',
            'REQUEST_METHOD'      => 'PUT',
            'CONTENT_TYPE'        => 'text/plain; charset="utf-8"',
            'HTTP_CONTENT_LENGTH' => '9',
            'HTTP_AUTHORIZATION'  => 'Basic c29tZTppbmNvcnJlY3Q=',
        ),
        'body' => 'Some text',
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
