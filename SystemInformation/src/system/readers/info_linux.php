<?php
/**
 * File containing the ezcSystemInfoLinuxReader class
 *
 * @package SystemInformation
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provide functionality to read system information from Linux systems.
 * 
 * Try to scan Linux system parameters on initialization and fill 
 * correspondent values.
 *
 * @package SystemInformation
 * @version //autogentag//
 */
class ezcSystemInfoLinuxReader extends ezcSystemInfoReader
{
    /**
     * Contains true if ezcSystemInfoReader object initialized 
     * and system info successfully taken.
     * @var bool
     */
    private $isValid = false;
    
    /**
     * Contains string that represents reader in messages and exceptions.
     * 
     * @var string
     */
    protected $readerName = 'Linux system info reader';
    
    /**
     * Stores properties that fetched form system once during construction
     * Read-only after initialization. If property set to true than it contains valid 
     * value. Otherwise property is not set.
     * 
     * Propertyes could be
     * 'cpu_type'
     * 'cpu_unit'
     * 'cpu_speed'
     * 'memory_size'
     * 
     * @var array(string)
     */
    private $validProperties = array();

    /**
     * Contains the type of CPU, the type is taken directly from the OS
     * and can vary a lot.
     * @var string
     */
    protected $cpuType = false;
    
    /**
     * Contains the speed of CPU, the type is taken directly from the OS
     * and can vary a lot. The speed is just a number so use cpuUnit()
     * to get the proper unit (e.g MHz).
     * @var int
     */
    protected $cpuSpeed = false;

    /**
     * Contains the proper unit in witch CPU speed is measured.
     * @var string
     */
    protected $cpuUnit = false;

    /**
     * Contains the amount of system memory the OS has, the value is
     * in bytes.
     * @var int
     */
    protected $memorySize = false;


    /**
     * Constructs ezcSystemInfoReader object and fill it with system information.
     * 
     * @throws ezcSystemInfoReaderCantScanOSException if 
     */
    public function __construct()
    {
        if ( !$this->getOsInfo() )
        {
            throw new ezcSystemInfoReaderCantScanOSException( "<{$this->readerName}>: can't scan OS for system values." );
        }

    }

    /**
     * Scans the OS and fills in the information internally.
     * 
     * @return void
     */
    private function init()
    {
        $this->getOsInfo();
    }

    /**
     * Returns true if the property $propertyName holds a valid value and false otherwise.
     * @param string $propertyName
     * @return bool
     */
    public function isValid( $propertyName )
    {
        return true;
    }


    /**
     * Scans the OS and fills in the information internally.
     * Returns true if it was able to scan the system or false if it failed.
     * 
     * @param string $cpuinfoPath path to the source of cpu information in system 
     * @param string $meminfoPath path to the source of memory information in system
     * @return bool 
     */
    private function getOsInfo( $cpuinfoPath = false, $meminfoPath = false )
    {
        if ( !$cpuinfoPath )
        {
            $cpuinfoPath = '/proc/cpuinfo';
        }
        if ( !$meminfoPath )
        {
            $meminfoPath = '/proc/meminfo';
        }

        if ( !file_exists( $cpuinfoPath ) )
        {
            return false;
        }
        if ( !file_exists( $meminfoPath ) )
        {
            return false;
        }

        $fileLines = file( $cpuinfoPath );
        foreach ( $fileLines as $line )
        {
            if ( substr( $line, 0, 7 ) == 'cpu MHz' )
            {
                $cpu = trim( substr( $line, 11, strlen( $line ) - 11 ) );
                if ( $cpu != '' ) 
                {
                    $this->cpuSpeed = $cpu;
                    $this->cpuUnit = 'MHz';
                    $this->validProperties['cpu_speed'] = $this->cpuSpeed;
                    $this->validProperties['cpu_unit'] = $this->cpuUnit;
                }
            }
            if ( substr( $line, 0, 10 ) == 'model name' )
            {
                $system = trim( substr( $line, 13, strlen( $line ) - 13 ) );
                if ( $system != '' ) 
                {
                    $this->cpuType = $system;
                    $this->validProperties['cpu_type'] = $this->cpuType;
                }
            }
            if ( $this->cpuSpeed !== false and
                 $this->cpuType !== false and
                 $this->cpuUnit !== false )
            {
                break;
            }
        }

        $fileLines = file( $meminfoPath );
        foreach ( $fileLines as $line )
        {
            if ( substr( $line, 0, 8 ) == 'MemTotal' )
            {
                $mem = trim( substr( $line, 11, strlen( $line ) - 11 ) );
                $memBytes = $mem;
                if ( preg_match( "#^([0-9]+) *([a-zA-Z]+)#", $mem, $matches ) )
                {
                    $memBytes = (int)$matches[1];
                    $unit = strtolower( $matches[2] );
                    if ( $unit == 'kb' )
                    {
                        $memBytes *= 1024;
                    }
                    else if ( $unit == 'mb' )
                    {
                        $memBytes *= 1024*1024;
                    }
                    else if ( $unit == 'gb' )
                    {
                        $memBytes *= 1024*1024*1024;
                    }
                }
                else
                {
                    $memBytes = (int)$memBytes;
                }
                $this->memorySize = $memBytes;
                $this->validProperties['memory_size'] = $this->memorySize;
            }
            if ( $this->memorySize !== false )
            {
                break;
            }
        }

        return true;
    }

    /**
     * Returns CPU speed
     * 
     * If the CPU speed could not be read false is returned.
     * @return int
     */
    public function cpuSpeed()
    {
        return $this->cpuSpeed;
    }
    
    /**
     * Returns string with unit in wich CPU speed measured.
     * 
     * If the CPU unit could not be read false is returned.
     * @return string
     */
    public function cpuUnit()
    {
        return $this->cpuUnit;
    }

    /**
     * Returns string with CPU type.
     *
     * If the CPU type could not be read false is returned.
     * @return string
     */
    public function cpuType()
    {
        return $this->cpuType;
    }

    
    /**
     * Returns memory size in bytes.
     * 
     * If the memory size could not be read false is returned.
     * @return int
     */
    public function memorySize()
    {
        return $this->memorySize;
    }
}

?>
