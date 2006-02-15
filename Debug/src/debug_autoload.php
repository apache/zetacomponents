<?php
/**
 * File containing the autoload structure.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

return array(
    'ezcDebug'             => 'Debug/debug.php',
    'ezcDebugMemoryWriter' => 'Debug/writers/memory_writer.php',
    'ezcDebugStructure'    => 'Debug/structs/debug_structure.php',
    'ezcDebugTimer'        => 'Debug/debug_timer.php',

    'ezcDebugOutputFormatter'     => 'Debug/interfaces/formatter.php',
    'ezcDebugHtmlFormatter' => 'Debug/formatters/html_formatter.php',

    'ezcDebugTimerStruct'      => 'Debug/structs/timer.php',
    'ezcDebugSwitchTimerStruct'      => 'Debug/structs/switch_timer.php',

    'ezcDebugMessage'      => 'Debug/debug_message.php'
);

?>
