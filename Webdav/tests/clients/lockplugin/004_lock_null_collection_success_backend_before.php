<?php

$backend = new ezcWebdavMemoryBackend();

$backend->addContents(
    array(
        'collection' => array(
            'resource.html' => '',
        ),
    )
);

return $backend;

?>
