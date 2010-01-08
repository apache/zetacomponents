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
 * Test the struct ezcMvcResultCookie.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultCookieTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultCookie();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultCookie();
        $struct->name = 'php';
        $this->assertEquals( 'php', $struct->name, 'Property name does not have the expected value' );
        $struct->value = 'ezc';
        $this->assertEquals( 'ezc', $struct->value, 'Property value does not have the expected value' );
        $struct->expire = 'ezp';
        $this->assertEquals( 'ezp', $struct->expire, 'Property expire does not have the expected value' );
        $struct->path = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->path, 'Property path does not have the expected value' );
        $struct->domain = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->domain, 'Property domain does not have the expected value' );
        $struct->secure = 'django';
        $this->assertEquals( 'django', $struct->secure, 'Property secure does not have the expected value' );
        $struct->httpOnly = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->httpOnly, 'Property httpOnly does not have the expected value' );
    }

    public function testSetState()
    {
        $date = new DateTime();
        $state = array(
        'name' => 'php',
        'value' => 'ezc',
        'expire' => $date,
        'path' => 'buddymiles',
        'domain' => 'buddyguy',
        'secure' => 'django',
        'httpOnly' => 'satchmo',
        );
        $struct = ezcMvcResultCookie::__set_state( $state );
        $this->assertEquals( 'php', $struct->name, 'Property name does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->value, 'Property value does not have the expected value' );
        $this->assertEquals( $date, $struct->expire, 'Property expire does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->path, 'Property path does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->domain, 'Property domain does not have the expected value' );
        $this->assertEquals( 'django', $struct->secure, 'Property secure does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->httpOnly, 'Property httpOnly does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultCookieTest" );
    }
}
?>
