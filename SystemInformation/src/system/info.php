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
 * specific for each supported system. óorresponding reader automatically
 * detected, attached and forced to scan system info during initialisation.
 * Exception throws if reader can't scan sistem info.
 * 
 * Available readers are:
 * - {@link ezcSystemInfoLinuxReader} reader
 * - {@link ezcSystemInfoMacReader} reader
 * - {@link ezcSystemInfoFreeBsdReader} reader
 * - {@link ezcSystemInfoWindowsReader} reader
 *
 * Readers for otner systems could be added by 
 * implementing the {@link ezcSystemInfoReader} interface.
 *
 * The ezcSystemInfo class has the following properties:<br><br>
 * Reader independent, these properties are availiable even if system reader was not initialized.
 * - String <b>osType</b>, OS type (e.g 'unix') or null.
 * - String <b>osName</b>, OS name (e.g 'Linux') or null.
 * - String <b>fileSystemType</b>, filesystem type (e.g 'linux') or null.
 * - String <b>lineSeparator</b>, which is used for line separators on the current OS.
 * - String <b>backupFileName</b>, backup filename for this platform, '.bak' for win32 
 *   and '~' for unix and mac.
 * - Array <b>phpVersion</b>, with PHP version (e.g. array(5,1,1) )
 * - ezcSystemInfoAccelerator <b>phpAccelerator</b>, structure with PHP accelerator info or null 
 * {@link ezcSystemInfoAccelerator}.
 * - Bool <b>isShellExecution</b>, flag indicates if the script executed over the web or the shell/command line.
 * <br><br>
 * Reader dependent, these properties are not availiable if reader was not intnialized and didn't scan OS:
 * - Integer <b>cpuCount</b> amount of CPUs in system or null .
 * - String <b>cpuType</b> CPU type string (e.g 'AMD Sempron(tm) Processor 3000+') or null.
 * - Float <b>cpuSpeed</b> CPU speed as float (e.g 1808.743) or null.
 * - Integer <b>memorySize</b> Memory Size in bytes int (e.g. 528424960) or null.
 * Example:<br>
 *  <code>
 *  $info = ezcSystemInfo::getInstance();
 *  echo 'Processors: ', $info->cpuCount, "\n";
 *  echo 'CPU Type: ', $info->cpuType, "\n";
 *  echo 'CPU Speed: ', $info->cpuSpeed, "\n";
 *  </code>
 *
 * @package SystemInformation
 * @version //autogentag//
 * @mainclass
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
     * Contains string with type of underlaying OS
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $osType = null;

    /**
     * Contains string with name of underlaying OS
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $osName = null;
    
    /**
     * Contains string with file system type
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $fileSystemType = null;
    
    /**
     * Contains string with file system type
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $lineSeparator = null;

    /**
     * Contains string with file system type
     * or empty string if OS can't be detected
     *
     * @var string
     */
    private $backupFileName = null;
    
    /**
     * Returns the single instance of the ezcSystemInfo class
     * 
     * @throws ezcSystemInfoReaderCantScanOSException
     *         If system variables can't be received from OS.
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
     * Constructs ezcSystemInfo object, init it with correspondent underlaying OS object.
     * 
     * @throws ezcSystemInfoReaderCantScanOSException
     *         If system variables can't be received from OS.
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * Detect underlaying system and setup system properties.
     * 
     * @throws ezcSystemInfoReaderCantScanOSException
     *         If system variables can't be received from OS.
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
     * @throws ezcSystemInfoReaderCantScanOSException
     *         If system variables can't be received from OS.
     * 
     * @return bool
     */
    private function setSystemInfoReader()
    {
        // Determine OS
        $uname = php_uname( 's' );

        if ( substr( $uname, 0, 7 ) == 'Windows' )
        {
            $this->systemInfoReader = new ezcSystemInfoWindowsReader( $uname );
            $this->osType = 'win32';
            $this->osName = 'Windows';
            $this->fileSystemType = 'win32';
            $this->lineSeparator= "\r\n";
            $this->backupFileName = '.bak';
        }
        else if ( substr( $uname, 0, 3 ) == 'Mac' )
        {
            $this->systemInfoReader = new ezcSystemInfoMacReader();
            $this->osType = 'mac';
            $this->osName = 'Mac';
            $this->fileSystemType = 'unix';
            $this->lineSeparator= "\r";
            $this->backupFileName = '~';
        }
        else
        {
            $this->osType = 'unix';
            if ( strtolower( $uname ) == 'linux' )
            {
                $this->systemInfoReader = new ezcSystemInfoLinuxReader();
                $this->osName = 'Linux';
                $this->fileSystemType = 'unix';
                $this->lineSeparator= "\n";
                $this->backupFileName = '~';
            }
            else if ( strtolower( substr( $uname, 0, 7 ) ) == 'freebsd' )
            {
                $this->systemInfoReader = new ezcSystemInfoFreeBsdReader();
                $this->osName = 'FreeBSD';
                $this->fileSystemType = 'unix';
                $this->lineSeparator= "\n";
                $this->backupFileName = '~';
            }
            else
            {
                $this->systemInfoReader = null; 
            }
        }
    }

    /**
     * Detects if a PHP accelerator running and what type it is if one found.
     * 
     * @return ezcSystemInfoAccelerator or null if no PHP accelerator detected
     */
    public static function phpAccelerator()
    {
        $phpAcceleratorInfo = null;
        if ( isset( $GLOBALS['_PHPA'] ) )
        {
            $phpAcceleratorInfo = new ezcSystemInfoAccelerator(
                    "ionCube PHP Accelerator",          // name
                    "http://www.php-accelerator.co.uk", // url
                    $GLOBALS['_PHPA']['ENABLED'],       // isEnabled
                    $GLOBALS['_PHPA']['iVERSION'],      // version int
                    $GLOBALS['_PHPA']['VERSION']        // version string
                );
        }
        if ( extension_loaded( "Turck MMCache" ) )
        {
            $phpAcceleratorInfo = new ezcSystemInfoAccelerator(
                    "Turck MMCache",                        // name
                    "http://turck-mmcache.sourceforge.net", // url
                    true,                                   // isEnabled
                    false,                                  // version int
                    false                                   // version string
                );
        }
        if ( extension_loaded( "eAccelerator" ) )
        {
            $phpAcceleratorInfo = new ezcSystemInfoAccelerator(
                    "eAccelerator",                                     // name            
                    "http://sourceforge.net/projects/eaccelerator/",    // url
                    true,                                               // isEnabled
                    false,                                              // version int
                    phpversion( 'eAccelerator' )                        // version string
                );
        }
        if ( extension_loaded( "apc" ) )
        {
            $phpAcceleratorInfo = new ezcSystemInfoAccelerator(
                    "APC",                                  // name
                    "http://pecl.php.net/package/APC",      // url
                    ( ini_get( 'apc.enabled' ) != 0 ),      // isEnabled
                    false,                                  // version int
                    phpversion( 'apc' )                     // version string
                );
        }
        if ( extension_loaded( "Zend Performance Suite" ) )
        {
            $phpAcceleratorInfo = new ezcSystemInfoAccelerator(
                    "Zend WinEnabler (Zend Performance Suite)",                // name
                    "http://www.zend.com/store/products/zend-win-enabler.php", // url
                    true,                                                      // isEnabled
                    false,                                                     // version int
                    false                                                      // version string
                );
        }
        return $phpAcceleratorInfo;
    }

    /**
     * Determins if the script got executed over the web or the shell/command line.
     *
     * @return bool
     */
    public static function isShellExecution()
    {
        $sapiType = php_sapi_name();

        if ( $sapiType == 'cli' )
            return true;

        // For CGI we have to check, if the script has been executed over shell.
        // Currently it looks like the HTTP_HOST variable is the most reasonable to check.
        if ( substr( $sapiType, 0, 3 ) == 'cgi' )
        {
            if ( !isset( $_SERVER['HTTP_HOST'] ) )
                return true;
            else
                return false;
        }
        return false;
    }

    /**
     * Returns the PHP version as an array with the version elements.
     *
     * @return array
     */
    public static function phpVersion()
    {
        return explode( '.', phpVersion() );
    }

    /**
     * Property read access.
     *
     * @param string $property Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     */
    function __get( $property )
    {
        if ( $this->systemInfoReader == null &&
             ( $property == 'cpuType'  || 
               $property == 'cpuCount' || 
               $property == 'cpuSpeed' || 
               $property == 'memorySize'
             )
           )
        {
            return null;
        }

        switch ( $property )
        {
            case 'osType':
                return $this->osType;
            case 'osName':
                return $this->osName;
            case 'fileSystemType':
                return $this->fileSystemType;
            case 'cpuCount':
                return $this->systemInfoReader->getCpuCount();
            case 'cpuType':
                return $this->systemInfoReader->cpuType();
            case 'cpuSpeed':
                return $this->systemInfoReader->cpuSpeed();
            case 'memorySize':
                return $this->systemInfoReader->memorySize();
            case 'lineSeparator':
                return $this->lineSeparator;
            case 'backupFileName':
                return $this->backupFileName;
            case 'phpVersion':
                return $this->phpVersion();
            case 'phpAccelerator':
                return $this->phpAccelerator();
            case 'isShellExecution':
                return $this->isShellExecution();

            default: 
                break;
        }
        throw new ezcBasePropertyNotFoundException( $property );
    }
}

?>
