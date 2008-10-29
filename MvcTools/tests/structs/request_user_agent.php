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
 * Test the struct ezcMvcRequestUserAgent.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRequestUserAgentTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRequestUserAgent();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRequestUserAgent();
        $struct->agent = 'php';
        $this->assertEquals( 'php', $struct->agent, 'Property agent does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'agent' => 'php',
        );
        $struct = ezcMvcRequestUserAgent::__set_state( $state );
        $this->assertEquals( 'php', $struct->agent, 'Property agent does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRequestUserAgentTest" );
    }
}
?>