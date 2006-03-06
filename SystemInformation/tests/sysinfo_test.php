<?php
/**
 * ezcSystemInfoTest
 * 
 * @package SystemInformation
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
	public static function suite()
	{
		return new ezcTestSuite( "ezcSystemInfoTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testSystemInfoCpuTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuType = $info->cpuType();

        $this->assertSame( 
            $cpuType,
            'AMD Sempron(tm) Processor 3000+',
            'CPU type was not determined correctly for linux'
        );
    }

    public function testSystemInfoCpuSpeedTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuSpeed = $info->cpuSpeed();

        $this->assertSame( 
            $cpuSpeed,
            '1808.743',
            'CPU speed was not determined correctly for linux'
        );
    }

    public function testSystemInfoCpuUnitTest()
    {
        $info = ezcSystemInfo::getInstance();
        $cpuUnit = $info->cpuUnit();

        $this->assertSame( 
            $cpuUnit,
            'MHz',
            'CPU speed unit was not determined correctly for linux'
        );
    }

    public function testSystemInfoOsNameTest()
    {
        $info = ezcSystemInfo::getInstance();
        $osName = $info->osName();

        $this->assertSame( 
            $osName,
            'Linux',
            'CPU type was not determined correctly for linux'
        );
    }

    public function testSystemInfoOsTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $osType = $info->osType();

        $this->assertSame( 
            $osType,
            'unix',
            'CPU type was not determined correctly for linux'
        );
    }

    public function testSystemInfoMemorySizeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $memorySize = $info->memorySize();

        $this->assertSame( 
            $memorySize,
            527499264,
            'Amount of system memory was not determined correctly for linux'
        );
    }

    public function testSystemInfoFileSystemTypeTest()
    {
        $info = ezcSystemInfo::getInstance();
        $fileSystemType = $info->fileSystemType();

        $this->assertSame( 
            $fileSystemType,
            'unix',
            'File System type was not determined correctly for linux'
        );
    }

    public function testSystemInfoLineSeparatorTest()
    {
        $info = ezcSystemInfo::getInstance();
        $lineSeparator = $info->lineSeparator();

        $this->assertSame( 
            $lineSeparator,
            "\n",
            'Line separator was not determined correctly for linux'
        );
    }

    public function testSystemInfoBackupFileNameTest()
    {
        $info = ezcSystemInfo::getInstance();
        $backupFileName = $info->backupFileName();

        $this->assertSame( 
            $backupFileName,
            "~",
            'Backup file name was not determined correctly for linux'
        );
    }

    public function testSystemInfoPhpVersionTest()
    {
        $info = ezcSystemInfo::getInstance();
        $phpVersion = $info->phpVersion();
        $waitVersion = array( "5", "1", "1");

        $this->assertSame( 
            $phpVersion,
            $waitVersion,
            'Php version was not determined correctly for linux'
        );
    }

    public function testSystemInfoIsShellExecutionTest()
    {
        $info = ezcSystemInfo::getInstance();
        $isShellExecution = $info->isShellExecution();

        $this->assertSame( 
            $isShellExecution,
            true,
            'Execution from shell was not determined correctly for linux'
        );
    }

}
?>
