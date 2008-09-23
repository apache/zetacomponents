<?php
$configuration = new yourMvcDispatcherConfiguration();
$dispatcher = new ezcMvcProductionDispatcher( $configuration );
$dispatcher->run();
?>
