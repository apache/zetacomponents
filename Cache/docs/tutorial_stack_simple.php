<?php

require_once 'tutorial_autoload.php';

$stack = new ezcCacheStack( 'stack' );

$stack->pushStorage(
    new ezcCacheStackStorageConfiguration(
        'file',
        $fileStorage,
        1000000,
        .5
    )
);
$stack->pushStorage(
    new ezcCacheStackStorageConfiguration(
        'apc',
        $apcStorage,
        1000,
        .3
    )
);

$stack->options->replacementStrategy = 'ezcCacheStackLfuReplacementStrategy';

// ... somewhere else...

$stack->store(
    'id_1', 'id_1_data'
);
$stack->store(
    'id_2', 'id_2_data', array( 'attribute' => 'value' )
);
$id1data = $stack->restore( 'id_1' );

?>
