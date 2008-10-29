<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the struct ezcMvcResult.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResult();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResult();
        $struct->status = 'php';
        $this->assertEquals( 'php', $struct->status, 'Property status does not have the expected value' );
        $struct->date = 'ezc';
        $this->assertEquals( 'ezc', $struct->date, 'Property date does not have the expected value' );
        $struct->generator = 'ezp';
        $this->assertEquals( 'ezp', $struct->generator, 'Property generator does not have the expected value' );
        $struct->cache = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->cache, 'Property cache does not have the expected value' );
        $struct->cookies = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->cookies, 'Property cookies does not have the expected value' );
        $struct->content = 'django';
        $this->assertEquals( 'django', $struct->content, 'Property content does not have the expected value' );
        $struct->variables = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->variables, 'Property variables does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'status' => 'php',
        'date' => 'ezc',
        'generator' => 'ezp',
        'cache' => 'buddymiles',
        'cookies' => 'buddyguy',
        'content' => 'django',
        'variables' => 'satchmo',
        );
        $struct = ezcMvcResult::__set_state( $state );
        $this->assertEquals( 'php', $struct->status, 'Property status does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->date, 'Property date does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->generator, 'Property generator does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->cache, 'Property cache does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->cookies, 'Property cookies does not have the expected value' );
        $this->assertEquals( 'django', $struct->content, 'Property content does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->variables, 'Property variables does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultTest" );
    }
}
?>