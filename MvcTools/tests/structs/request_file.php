<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the struct ezcMvcRequestFile.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRequestFileTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRequestFile();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRequestFile();
        $struct->mimeType = 'php';
        $this->assertEquals( 'php', $struct->mimeType, 'Property mimeType does not have the expected value' );
        $struct->name = 'ezc';
        $this->assertEquals( 'ezc', $struct->name, 'Property name does not have the expected value' );
        $struct->size = 'ezp';
        $this->assertEquals( 'ezp', $struct->size, 'Property size does not have the expected value' );
        $struct->status = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->status, 'Property status does not have the expected value' );
        $struct->tmpPath = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->tmpPath, 'Property tmpPath does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'mimeType' => 'php',
        'name' => 'ezc',
        'size' => 'ezp',
        'status' => 'buddymiles',
        'tmpPath' => 'buddyguy',
        );
        $struct = ezcMvcRequestFile::__set_state( $state );
        $this->assertEquals( 'php', $struct->mimeType, 'Property mimeType does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->name, 'Property name does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->size, 'Property size does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->status, 'Property status does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->tmpPath, 'Property tmpPath does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRequestFileTest" );
    }
}
?>