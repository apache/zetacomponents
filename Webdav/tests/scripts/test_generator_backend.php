<?php

$backend = new ezcWebdavMemoryBackend();
$backend->options->fakeLiveProperties = true;
$backend->addContents(
    array(
        'test_collection' => array(
            'foo.txt'  => 'Test foo content',
            'bar'      => 'Test bar content',
            'baz_coll' => array(
                'baz_1.html' => '<html></html>',
                'baz_2.html' => '<html><body><h1>Test</h1></body></html>',
            ),
        ),
    )
);

$backend->setProperty(
    '/test_collection/foo.txt',
    new ezcWebdavGetContentTypeProperty(
        'text/plain', 'utf-8'
    )
);
$backend->setProperty(
    '/test_collection/bar',
    new ezcWebdavGetContentTypeProperty(
        'text/plain', 'utf-8'
    )
);
$backend->setProperty(
    '/test_collection/baz_coll/baz_1.html',
    new ezcWebdavGetContentTypeProperty(
        'text/html', 'utf-8'
    )
);
$backend->setProperty(
    '/test_collection/baz_coll/baz_2.html',
    new ezcWebdavGetContentTypeProperty(
        'text/xhtml', 'utf-8'
    )
);

return $backend;

?>
