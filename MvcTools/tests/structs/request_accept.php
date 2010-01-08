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
 * Test the struct ezcMvcRequestAccept.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRequestAcceptTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRequestAccept();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRequestAccept();
        $struct->types = 'php';
        $this->assertEquals( 'php', $struct->types, 'Property types does not have the expected value' );
        $struct->charsets = 'ezc';
        $this->assertEquals( 'ezc', $struct->charsets, 'Property charsets does not have the expected value' );
        $struct->languages = 'ezp';
        $this->assertEquals( 'ezp', $struct->languages, 'Property languages does not have the expected value' );
        $struct->encodings = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->encodings, 'Property encodings does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'types' => 'php',
        'charsets' => 'ezc',
        'languages' => 'ezp',
        'encodings' => 'buddymiles',
        );
        $struct = ezcMvcRequestAccept::__set_state( $state );
        $this->assertEquals( 'php', $struct->types, 'Property types does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->charsets, 'Property charsets does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->languages, 'Property languages does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->encodings, 'Property encodings does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRequestAcceptTest" );
    }
}
?>