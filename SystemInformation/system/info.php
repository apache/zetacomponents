<?php

/**
 *  Provides access to common system variables.
 *
 * The following information can be queried:
 * - CPU Type (e.g Pentium) - cpuType()
 * - CPU Speed (e.g 1000) - cpuSpeed()
 * - CPU Unit (e.g. MHz) - cpuUnit()
 * - Memory Size in bytes (e.g. 528424960) - memorySize()
 *
 *  <code>
 *  $info = new eZSysInfo();
 *  print( $info->cpuType . "\n" );
 *  </code>
 * @package SystemInformation
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//

 */

class ezcSystemInfo
{
    private $isValid = false;
    private $validProcInfo = false;
    /**
     * Contains the speed of CPU, the type is taken directly from the OS
     * and can vary a lot. The speed is just a number so use cpuUnit()
     * to get the proper unit (e.g MHz).
     */
    private $cpuSpeed = false; // property

    /**
     * Contains the type of CPU, the type is taken directly from the OS
     * and can vary a lot.
     */
    private $cpuType = false;  // property

    private $cpuUnit = false;  // property

    /**
     * Contains the amount of system memory the OS has, the value is
     * in bytes.
     */
    private $memorySize = false; // property
    private $phpAccelerator; // property
    private $webServer; // property


    /**
     * Constructs an empty sysinfo object.
     */
    public function eZSysInfo()
    {
    }


    /**
     * Returns true if the property $propertyName holds a valid value and false otherwise.
     * @param string $propertyName
     * @return boolean
     */
    public function isValid( $propertyName )
    {
    }


    /**
     * Scans the system depending on the OS and fills in the information internally.
     * @return boolean true if it was able to scan the system or false if it failed.
     */
    private function scanOs()
    {
    }

    /**
     * Scans the /proc/cpuinfo and /proc/meminfo files for CPU and memory information.
     *
     * If the files are unavailable or could not be read false is returned.
     * @param boolean $cpuinfoPath The path to the cpuinfo file, if \c false it uses '/proc/cpuinfo'
     * which should be sufficient.
     * @param boolean $meminfoPath The path to the meminfo file, if \c false it uses '/proc/meminfo'
     * which should be sufficient.
     * @return boolean
     */
    private function scanProc( $cpuinfoPath = false, $meminfoPath = false )
    {
    }

    /**
     * Scans the dmesg.boot file which is created by the kernel.
     * If the files are unavailable or could not be read false is returned.
     * @param string $dmesgPath The path to the dmesg file, the default is
     * to use '/var/run/dmesg.boot' which should be sufficient.
     * @return boolean
     */
    private function scanDMesg( $dmesgPath = false )
    {
    }

    /**
     * Detects if this system is running a PHP accelerator and what type it is if one
     * found.
     * @return void
     */
    private function scanPhpAccellerator()
    {
    }
}

?>
