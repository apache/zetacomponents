<?php
/**
 * File containing the ezcSystemInfoWindowsReader class
 *
 * @package SystemInformation
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provide functionality to read system information from Windows systems.
 * 
 * This reader try to scan Windows system parameters on initialization and fill in
 * correspondent values. CPU parameters are taken from Windows registry.
 * Memory size received using functions in php_win32ps.dll PHP extension.
 *
 * @package SystemInformation
 * @version //autogentag//
 */
class ezcSystemInfoWindowsReader extends ezcSystemInfoReader
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
    protected $readerName = 'Windows system info reader';
    
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
     * @var string
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
     * @param string $dmesgPath path to the source of system information in OS 
     * @return bool 
     */
    private function getOsInfo( )
    {
        $output =shell_exec ("reg query HKLM\\HARDWARE\\DESCRIPTION\\SYSTEM\\CentralProcessor\\0 /v ProcessorNameString" );
        preg_match( "/ProcessorNameString\s*\S*\s*(.*)/", $output, $matches );
        if ( isset($matches[1]) )
        {
            $this->cpuType = $matches[1];
            $this->validProperties['cpuType'] = $this->cpuType;
        }
        unset ($matches);

        $output =shell_exec ("reg query HKLM\\HARDWARE\\DESCRIPTION\\SYSTEM\\CentralProcessor\\0 /v ~MHz" );
        preg_match( "/~MHz\s*\S*\s*(\S*)/", $output, $matches );
        if ( isset($matches[1]) )
        {
            $this->cpuSpeed = hexdec( $matches[1] ).'.0'; //force to be a string with speed float value
            $this->cpuUnit = 'MHz';
            $this->validProperties['cpu_speed'] = $this->cpuSpeed;
            $this->validProperties['cpu_unit'] = $this->cpuUnit;
        }

        // if no php_win32ps.dll extension installed than scanning of 
        // Total Physical memory is not supported.
        // It's could be implemented on WinXP and Win2003 using call to 
        // Windows Management Instrumentation (WMI) service like "wmic memphysical" 
        // (should be researched in details) or with help of some free third party 
        // utility like psinfo.exe from SysInternals ( www.sysinternals.com ).

        if ( extension_loaded("win32ps") )
        {
            $memInfo = win32_ps_stat_mem();
            $this->memorySize= $memInfo['total_phys']*$memInfo['unit'];
            $this->validProperties['memory_size'] = $this->memorySize;
        }
        return true;
    }

    /**
     * Returns string with CPU speed
     * 
     * If the CPU speed could not be read false is returned.
     * @return string
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
