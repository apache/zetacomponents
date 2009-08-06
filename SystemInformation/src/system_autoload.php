<?php
/**
 * Autoloader definition for the SystemInformation component.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SystemInformation
 */

return array(
    'ezcSystemInfoReaderCantScanOSException' => 'SystemInformation/exceptions/cant_scan.php',
    'ezcSystemInfoReader'                    => 'SystemInformation/interfaces/info_reader.php',
    'ezcSystemInfo'                          => 'SystemInformation/info.php',
    'ezcSystemInfoAccelerator'               => 'SystemInformation/structs/accelerator_info.php',
    'ezcSystemInfoFreeBsdReader'             => 'SystemInformation/readers/info_freebsd.php',
    'ezcSystemInfoLinuxReader'               => 'SystemInformation/readers/info_linux.php',
    'ezcSystemInfoMacReader'                 => 'SystemInformation/readers/info_mac.php',
    'ezcSystemInfoWindowsReader'             => 'SystemInformation/readers/info_windows.php',
);
?>
