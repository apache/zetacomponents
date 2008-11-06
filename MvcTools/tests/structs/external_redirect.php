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
 * Test the struct ezcMvcExternalRedirect.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcExternalRedirectTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcExternalRedirect();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcExternalRedirect();
        $struct->location = 'php';
        $this->assertEquals( 'php', $struct->location, 'Property location does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcExternalRedirectTest" );
    }
}
?>
