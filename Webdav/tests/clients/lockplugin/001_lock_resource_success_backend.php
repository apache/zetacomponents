<?php

$backendBefore = new ezcWebdavMemoryBackend();

$backendBefore->addContents(
    array(
        'collection' => array(
            'resource.html' => '',
        ),
    )
);

return $backendBefore;

?>
