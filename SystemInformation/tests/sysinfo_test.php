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

}
?>
