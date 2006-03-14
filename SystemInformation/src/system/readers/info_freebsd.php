<?php
/**
 * File containing the ezcSystemInfoFreeBsdReader class
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
class ezcSystemInfoFreeBsdReader extends ezcSystemInfoReader
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
    protected $readerName = 'FreeBSD system info reader';
    
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
     * @throws ezcSystemInfoReaderCantScanOSException 
     */
    public function __construct()
    {
        if ( !$this->getOsInfo() )
        {
            throw new ezcSystemInfoReaderCantScanOSException( "Exception: < $this->readerName > can't scan OS for system values." );
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
     * @param string $dmesgPath path to the source of system information in OS 
     * @return bool 
     */
    private function getOsInfo( $dmesgPath = false )
    {
        if ( !$dmesgPath )
            $dmesgPath = '/var/run/dmesg.boot';
        if ( !file_exists( $dmesgPath ) )
            return false;
        $fileLines = file( $dmesgPath );
        foreach ( $fileLines as $line )
        {
            if ( substr( $line, 0, 3 ) == 'CPU' )
            {
                $system = trim( substr( $line, 4, strlen( $line ) - 4 ) );
                $cpu = false;
                $cpuunit = false;
                //we should have line like "CPU: AMD Duron(tm)  (1800.07-MHz 686-class CPU)" parse it.
                if ( preg_match( "#^(.+)\\((.+)-(MHz) +([^)]+)\\)#", $system, $matches ) )
                {
                    $system = trim( $matches[1] ) . ' (' . trim( $matches[4] ) . ')';
                    $cpu = $matches[2];
                    $cpuunit = $matches[3];
                }
                $this->cpuSpeed = $cpu;
                $this->cpuType = $system;
                $this->cpuUnit = $cpuunit;
            }
            if ( substr( $line, 0, 11 ) == 'real memory' )
            {
                $mem = trim( substr( $line, 12, strlen( $line ) - 12 ) );
                $memBytes = $mem;
                if ( preg_match( "#^= *([0-9]+)#", $mem, $matches ) )
                {
                    $memBytes = $matches[1];
                }
                $memBytes = (int)$memBytes;
                $this->memorySize = $memBytes;
            }
            if ( $this->cpuSpeed !== false and
                 $this->cpuType !== false and
                 $this->cpuUnit !== false and
                 $this->memorySize !== false )
                break;

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
