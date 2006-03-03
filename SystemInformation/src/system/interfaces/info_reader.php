<?php
/**
 * File containing the ezcSystemInfoReader class
 *
 * @package SystemInformation
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcSystemInfoReader represents common interface of OS info reader.
 *
 * ezcSystemInfoReader
 *
 * 
 * @package SystemInformation
 * @version //autogentag//
 */
interface ezcSystemInfoReader
{
    /**
     * Returns true if the property $propertyName holds a valid value and false otherwise.
     * @param string $propertyName
     * @return bool
     */
    public function isValid( $propertyName )
    {
    }

    /**
     * Returns string with CPU type.
     *
     * If the CPU type could not be read false is returned.
     * @return string
     */
    public function cpuType()
    {
    }

    /**
     * Returns CPU speed
     * 
     * If the CPU speed could not be read false is returned.
     * @return int
     */
    public function cpuSpeed()
    {
    }
    
    /**
     * Returns string with unit in wich CPU speed measured.
     * 
     * If the CPU unit could not be read false is returned.
     * @return string
     */
    public function cpuUnit()
    {
    }
    
    /**
     * Returns memory size in bytes.
     * 
     * If the memory size could not be read false is returned.
     * @return int
     */
    public function memorySize()
    {
    }

    /**
     * Detects if this system is running a PHP accelerator and what type it is if one
     * found.
     * 
     * @return string
     */
    public function phpAccellerator()
    {
    }
}

?>
