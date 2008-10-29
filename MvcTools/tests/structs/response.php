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
 * Test the struct ezcMvcResponse.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResponseTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResponse();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResponse();
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
        $struct->body = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->body, 'Property body does not have the expected value' );
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
        'body' => 'satchmo',
        );
        $struct = ezcMvcResponse::__set_state( $state );
        $this->assertEquals( 'php', $struct->status, 'Property status does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->date, 'Property date does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->generator, 'Property generator does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->cache, 'Property cache does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->cookies, 'Property cookies does not have the expected value' );
        $this->assertEquals( 'django', $struct->content, 'Property content does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->body, 'Property body does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResponseTest" );
    }
}
?>