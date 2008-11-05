<?php

$backendBefore = new ezcWebdavMemoryBackend();

$backendBefore->addContents(
    array(
        'collection' => array(
            'resource.html' => '',
        ),
        'other_collection' => array(
        ),
    )
);

return $backendBefore;

?>
