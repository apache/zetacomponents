<?php
/**
 * All supplied dispatchers would implement the following interface.
 */
interface ezcMvcDispatcher
{
    /**
     * Instanciates the dispatcher with the passed configuration.
     */
    public function __construct( ezcMvcDispatcherConfiguration $configuration );

    /**
     * Runs the dispatcher.
     */
    public function run();
}
?>
