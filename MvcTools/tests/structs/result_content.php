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
 * Test the struct ezcMvcResultContent.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultContentTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultContent();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultContent();
        $struct->language = 'php';
        $this->assertEquals( 'php', $struct->language, 'Property language does not have the expected value' );
        $struct->type = 'ezc';
        $this->assertEquals( 'ezc', $struct->type, 'Property type does not have the expected value' );
        $struct->charset = 'ezp';
        $this->assertEquals( 'ezp', $struct->charset, 'Property charset does not have the expected value' );
        $struct->encoding = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->encoding, 'Property encoding does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'language' => 'php',
        'type' => 'ezc',
        'charset' => 'ezp',
        'encoding' => 'buddymiles',
        'disposition' => new ezcMvcResultContentDisposition(),
        );
        $struct = ezcMvcResultContent::__set_state( $state );
        $this->assertEquals( 'php', $struct->language, 'Property language does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->type, 'Property type does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->charset, 'Property charset does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->encoding, 'Property encoding does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultContentTest" );
    }
}
?>
