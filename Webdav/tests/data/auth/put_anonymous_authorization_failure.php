<?php

return array(
    array(
        'server' => array(
            'REQUEST_URI'    => '/a/a2',
            'REQUEST_METHOD' => 'PUT',
            'CONTENT_TYPE'   => 'text/plain; charset="utf-8"',
            'HTTP_CONTENT_LENGTH' => '9',
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
            'Content-Length'   => '21',
        ),
        'body' => 'Authorization failed.',
    ),
);

?>
