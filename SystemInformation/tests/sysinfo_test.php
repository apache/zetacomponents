<?php
/**
 * ezcSystemInfoTest
 * 
 * @package SystemInformation
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package SystemInformation
 * @subpackage Tests
 */
class ezcSystemInfoTest extends ezcTestCase
{
    public function testSystemInfoCpuCountTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuCount = $info->cpuCount;
        if ( !is_int( $cpuCount ) || $cpuCount <= 0 )
        {
            self::fail( 'Amount of CPUs was not determined correctly' );
        }
    }

    public function testSystemInfoCpuTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuType = $info->cpuType;
        $haveCpuVendor = preg_match( '/AMD|Intel|Cyrix/', $cpuType ) ? true : false;

        if ( !is_string( $cpuType ) || $cpuType=='' || !$haveCpuVendor )
        {
            self::fail( 'CPU type was not determined correctly' );
        }
    }

    public function testSystemInfoCpuSpeedTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuSpeed = $info->cpuSpeed;

        if ( !is_float($cpuSpeed) || $cpuSpeed <= 0 ) 
        {
            self::fail( 'CPU speed was not determined correctly' );
        }
    }

    public function testSystemInfoOsNameTest()
    {
        $info = ezcSystemInfo::getInstance();
        $osName = $info->osName;

        $haveOsName = preg_match( '/Linux|FreeBSD|Windows|Mac/', $osName ) ? true : false;

        if ( !$haveOsName )
        {
            self::fail( 'OS name was not determined correctly' );
        }
    }

    public function testSystemInfoOsTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $osType = $info->osType;

        $haveOsType = preg_match( '/unix|win32|mac/', $osType ) ? true : false;

        if ( !$haveOsType ) 
        {
            self::fail( 'OS type was not determined correctly' );
        }
    }

    public function testSystemInfoMemorySizeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $memorySize = $info->memorySize;

        if ( substr( php_uname( 's' ), 0, 7 ) == 'Windows' && !ezcBaseFeatures::hasExtensionSupport( "win32ps" ) )
        {
            // scanning of Total Physical memory not implemented for Windows
            // without php_win32ps.dll extention installed
            if ( $memorySize != null )
            {
                self::fail( 'OS memory size should be null in Windows when win32ps extention is not installed in PHP' );
            }
            return;
        }

        if ( !is_int( $memorySize ) || $memorySize == 0 || $memorySize % 1024 != 0 )
        {
            self::fail( 'OS memory size was not determined correctly' );
        }
    }

    public function testSystemInfoFileSystemTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $fileSystemType = $info->fileSystemType;

        $haveFileSysType = preg_match( '/unix|win32/', $fileSystemType ) ? true : false;
        if ( !$haveFileSysType )
        {
            self::fail( 'File System type was not determined correctly' );
        }
    }

    public function testSystemInfoLineSeparatorTest()
    {
        $info = ezcSystemInfo::getInstance();
        $lineSeparator = $info->lineSeparator;

        if ( $lineSeparator != "\n" && $lineSeparator != "\r\n" && $lineSeparator != "\r" )
        {
            self::fail( 'Line separator was not determined correctly' );
        }
    }

    public function testSystemInfoBackupFileNameTest()
    {
        $info = ezcSystemInfo::getInstance();
        $backupFileName = $info->backupFileName;

        if ( $backupFileName != "~" && $backupFileName != ".bak" )
        {
            self::fail( 'Backup file name was not determined correctly' );
        }
    }

    public function testSystemInfoPhpVersionTest()
    {
        $phpVersion = ezcSystemInfo::phpVersion();
        $waitVersion = explode( '.', phpVersion() );

        self::assertEquals(
            $phpVersion,
            $waitVersion,
            'Php version was not determined correctly'
        );
        unset( $phpVersion );
        $info = ezcSystemInfo::getInstance();
        $phpVersion = $info->phpVersion;
        self::assertEquals(
            $phpVersion,
            $waitVersion,
            'Php version was not determined correctly'
        );
    }

    public function testSystemInfoIsShellExecutionTest()
    {
        $info = ezcSystemInfo::getInstance();
        $isShellExecution = $info->isShellExecution;

        self::assertEquals(
            $isShellExecution,
            true,
            'Execution from shell was not determined correctly'
        );

        unset ( $isShellExecution );
        $isShellExecution = ezcSystemInfo::isShellExecution();
        self::assertEquals(
            $isShellExecution,
            true,
            'Execution from shell was not determined correctly'
        );
    }

    public function testSystemInfoPhpAcceleratorTest()
    {
        $testSample = null;
        $info = ezcSystemInfo::getInstance();
        $accelerator = $info->phpAccelerator;

        if ( isset( $GLOBALS['_PHPA'] ) )
        {
            $testSample = new ezcSystemInfoAccelerator(
                    "ionCube PHP Accelerator",          // name
                    "http://www.php-accelerator.co.uk", // url
                    $GLOBALS['_PHPA']['ENABLED'],       // isEnabled
                    $GLOBALS['_PHPA']['iVERSION'],      // version int
                    $GLOBALS['_PHPA']['VERSION']        // version string
            );
            self::assertEquals( $accelerator, $testSample, 'PHP Accelerator not determined correctly' );
        }
        else if ( ezcBaseFeatures::hasExtensionSupport( "Turck MMCache" ) )
        {
            $testSample = new ezcSystemInfoAccelerator(
                "Turck MMCache",                        // name
                "http://turck-mmcache.sourceforge.net", // url
                true,                                   // isEnabled
                false,                                  // version int
                false                                   // version string
            );
            self::assertEquals( $accelerator, $testSample, 'PHP Accelerator not determined correctly' );
        }
        else if ( ezcBaseFeatures::hasExtensionSupport( "eAccelerator" ) )
        {
            $testSample = new ezcSystemInfoAccelerator(
                "eAccelerator",                                     // name
                "http://sourceforge.net/projects/eaccelerator/",    // url
                true,                                               // isEnabled
                false,                                              // version int
                phpversion('eAccelerator')                          // version string
            );
            self::assertEquals( $accelerator, $testSample, 'PHP Accelerator not determined correctly' );
        }
        else if ( ezcBaseFeatures::hasExtensionSupport( "apc" ) )
        {
            $testSample = new ezcSystemInfoAccelerator(
                 "APC",                                  // name
                 "http://pecl.php.net/package/APC",      // url
                 (ini_get( 'apc.enabled' ) != 0),        // isEnabled
                 false,                                  // version int
                 phpversion( 'apc' )                     // version string
            );
            self::assertEquals( $accelerator, $testSample, 'PHP Accelerator not determined correctly' );
        }
        else if ( ezcBaseFeatures::hasExtensionSupport( "Zend Performance Suite" ) )
        {
            $testSample = new ezcSystemInfoAccelerator(
                    "Zend WinEnabler (Zend Performance Suite)",                // name
                    "http://www.zend.com/store/products/zend-win-enabler.php", // url
                    true,                                                      // isEnabled
                    false,                                                     // version int
                    false                                                      // version string
            );
            self::assertEquals( $accelerator, $testSample, 'PHP Accelerator not determined correctly' );
        }
        else
        {
            self::assertEquals( $accelerator, null, 'phpAccelerator() should return null' );
        }
    }

    public function testGetInvalidProperty()
    {
        $info = ezcSystemInfo::getInstance();
        try
        {
            $info->no_such_property;
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $expected = "No such property name 'no_such_property'.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcSystemInfoTest" );
    }
}
?>
