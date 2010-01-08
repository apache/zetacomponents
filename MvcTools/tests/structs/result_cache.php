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
 * Test the struct ezcMvcResultCache.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultCacheTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultCache();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultCache();
        $struct->vary = 'php';
        $this->assertEquals( 'php', $struct->vary, 'Property vary does not have the expected value' );
        $struct->expire = 'ezc';
        $this->assertEquals( 'ezc', $struct->expire, 'Property expire does not have the expected value' );
        $struct->controls = 'ezp';
        $this->assertEquals( 'ezp', $struct->controls, 'Property controls does not have the expected value' );
        $struct->pragma = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->pragma, 'Property pragma does not have the expected value' );
        $struct->lastModified = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->lastModified, 'Property lastModified does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'vary' => 'php',
        'expire' => 'ezc',
        'controls' => 'ezp',
        'pragma' => 'buddymiles',
        'lastModified' => 'buddyguy',
        );
        $struct = ezcMvcResultCache::__set_state( $state );
        $this->assertEquals( 'php', $struct->vary, 'Property vary does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->expire, 'Property expire does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->controls, 'Property controls does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->pragma, 'Property pragma does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->lastModified, 'Property lastModified does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultCacheTest" );
    }
}
?>