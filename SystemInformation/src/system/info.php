<?php
/**
 * File containing the ezcSystemInfo class
 *
 * @package SystemInformation
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provides access to common system variables.
 * 
 * Variables that not available from PHP directly are fetched using readers
 * specific for each supported system.
 * 
 * Available readers are:
 * - {@link ezcSystemInfoLinuxReader} reader
 * - {@link ezcSystemInfoMacReader} reader
 * - {@link ezcSystemInfoFreeBsdReader} reader
 * - {@link ezcSystemInfoWindowsReader} reader
 *
 * Extra readers can be added by implementing the {@link ezcSystemInfoReader} interface.* 
 *
 * The following information can be queried:
 * - CPU Type (e.g Pentium) - cpuType()
 * - CPU Speed (e.g 1000) - cpuSpeed()
 * - CPU Unit (e.g. MHz) - cpuUnit()
 * - Memory Size in bytes (e.g. 528424960) - memorySize()
 *
 *  <code>
 *  $info = ezcSystemInfo::getInstance();
 *  print( $info->cpuType() . "\n" );
 *  </code>
 *
 * @package SystemInformation
 * @version //autogentag//
 */
class ezcSystemInfo
{

    /**
     * Instance of the singleton ezcSystemInfo object.
     *
     * Use the getInstance() method to retrieve the instance.
     *
     * @var ezcSystemInfo
     */
    private static $instance = null;

    /**
     * Contains object that provide info about underlaying OS
     *
     * @var ezcSystemInfoReader
     */
    private $systemInfoReader = null;

    /**
     * Contains string with type of OS underlaying OS
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $OSType = '';

    /**
     * Contains string with name of OS underlaying OS
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $OSName = '';


    /**
     * Returns the single instance of the ezcSystemInfo class
     * @return ezcSystemInfo
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructs ezcSystemInfo object and init it with correspondent underlaying OS object.
     * 
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Detect underlaying system and setup system properties.
     * @return void
     */
    private function init()
    {
        $this->setSystemInfoReader();
    }


    /**
     * Sets the the systemInfoReader depending of the OS and fills in the system 
     * information internally.
     * Returns true if it was able to set appropriate systemInfoReader
     * or false if failed.
     * 
     * @return bool
     */
    private function setSystemInfoReader()
    {
        // Determine OS
        $uname = strtolower( php_uname( 's' ) );

        if ( substr( $uname, 0, 7 ) == "Windows" )
        {
            $this->systemInfoReader = new ezcSystemInfoWindowsReader( $uname );
            $this->OSType = "win32";
            $this->OSName = "Windows";
        }
        else if ( substr( $uname, 0, 3 ) == "Mac" )
        {
            $this->systemInfoReader = new ezcSystemInfoMacReader();
            $this->OSType = "mac";
            $this->OSName = "Mac";
        }
        else
        {
            $this->OSType = "unix";

            if ( strtolower( $uname ) == 'linux' )
            {
                $this->systemInfoReader = new ezcSystemInfoLinuxReader();
                $this->OSName = "Linux";
            }
            else if ( strtolower( substr( $uname, 0, 0 ) ) == 'freebsd' )
            {
                $this->systemInfoReader = new ezcSystemInfoFreeBsdReader();
                $this->OSName = "FreeBSD";
            }
            else
            {
                $this->systemInfoReader = null; 
//                throw new exceptionOsUndetected()
            }
        }
    }

    /**
     * Returns the name of the underlaying OS or empty string
     * if name could not be determined.
     * 
     * @return string
     */
    public function osName()
    {
        return $this->OSName;
    }

    /**
     * Returns the OS type, either "win", "unix" or "mac"
     * Empty string returned if OS type can't be detected.
     * @return string
     */
    public function osType()
    {
        return $this->OSType;
    }
    
    /**
     * Returns the filesystem type, either "win" or "unix"
     * @return string
     */
    public function filesystemType()
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
        if ( $this->systemInfoReader !== null )
        {
            return $this->systemInfoReader->cpuType();
        }
        return false;
    }

    /**
     * Returns CPU speed
     * 
     * If the CPU speed could not be read false is returned.
     * @return int
     */
    public function cpuSpeed()
    {
        if ( $this->systemInfoReader !== null )
        {
            return $this->systemInfoReader->cpuSpeed();
        }
        return false;
    }
    
    /**
     * Returns string with unit in wich CPU speed measured.
     * 
     * If the CPU unit could not be read false is returned.
     * @return string
     */
    public function cpuUnit()
    {
        if ( $this->systemInfoReader !== null )
        {
            return $this->systemInfoReader->cpuUnit();
        }
        return false;
    }
    
    /**
     * Returns memory size in bytes.
     * 
     * If the memory size could not be read false is returned.
     * @return int
     */
    public function memorySize()
    {
        if ( $this->systemInfoReader !== null )
        {
            return $this->systemInfoReader->memorySize();
        }
        return false;
    }

    /**
     * Detects if this system is running a PHP accelerator and what type it is if one
     * found.
     * 
     * @return string
     */
    public static function phpAccellerator()
    {
    }


    /**
     * Returns the PHP version as an array with the version elements.
     * 
     * @return array
     */
    public function phpVersion()
    {
    }

    /**
     * Returns true if the PHP version is equal or higher than $requiredVersion.
     * $requiredVersion must be an array with version number.
     * 
     * $param array $requiredVersion 
     * @return bool
     */
    public function isPHPVersionSufficient( $requiredVersion )
    {
    }

    /**
     * Determins if the script got executed over the web or the shell/command line.
     *
     * @return bool
     */
    public function isShellExecution()
    {
    }

    /**
     * Returns the backup filename for this platform, returns .bak for win32 and ~ for unix and mac.
     * 
     * @return string
     */
    public function backupFilename()
    {
    }

    /**
     * Returns the string which is used for line separators on the current OS (server).
     * 
     * @return string
     */
    public function lineSeparator()
    {
    }

    /**
     * Returns the string which is used for enviroment separators on the current OS (server).
     * 
     * @return string
     */
    public function envSeparator()
    {
    }

    /**
     * Returns the variable named $variableName in the global $_ENV variable.
     * 
     * $param string $variableName
     * $param bool   $quiet
     * @return string
     */
    public function environmentVariable( $variableName, $quiet = false )
    {
    }

    /**
     * Sets the environment variable named $variableName to $variableValue.
     * 
     * $param string $variableName
     * $param string $variableValue
     * @return void
     */
    public function setEnvironmentVariable( $variableName, $variableValue )
    {
    }
}

?>
