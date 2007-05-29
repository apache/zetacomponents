<?php
/**
 * Autoloader definition for the SignalSlot component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 */

return array(
    'ezcSignalCollection'            => 'SignalSlot/signal_collection.php',
    'ezcSignalStaticConnections'     => 'SignalSlot/static_connections.php',
    'ezcSignalCallbackComparer'      => 'SignalSlot/internal/callback_comparer.php',
    'ezcSignalStaticConnectionsBase' => 'SignalSlot/interfaces/static_connections_base.php',
    'ezcSignalCollectionOptions'     => 'SignalSlot/options.php',
    'ezcSignalSlotException'         => 'SignalSlot/exceptions/signalslot_exception.php'
);
?>
