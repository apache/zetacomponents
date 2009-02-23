<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the struct ezcMvcRequestAuthentication.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRequestAuthenticationTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRequestAuthentication();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRequestAuthentication();
        $struct->identifier = 'php';
        $this->assertEquals( 'php', $struct->identifier, 'Property identifier does not have the expected value' );
        $struct->password = 'ezc';
        $this->assertEquals( 'ezc', $struct->password, 'Property password does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'identifier' => 'php',
        'password' => 'ezc',
        );
        $struct = ezcMvcRequestAuthentication::__set_state( $state );
        $this->assertEquals( 'php', $struct->identifier, 'Property identifier does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->password, 'Property password does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRequestAuthenticationTest" );
    }
}
?>