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
 * Test the struct ezcMvcHttpRawRequest.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcHttpRawRequestTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcHttpRawRequest();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcHttpRawRequest();
        $struct->headers = 'php';
        $this->assertEquals( 'php', $struct->headers, 'Property headers does not have the expected value' );
        $struct->body = 'ezc';
        $this->assertEquals( 'ezc', $struct->body, 'Property body does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'headers' => 'php',
        'body' => 'ezc',
        );
        $struct = ezcMvcHttpRawRequest::__set_state( $state );
        $this->assertEquals( 'php', $struct->headers, 'Property headers does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->body, 'Property body does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcHttpRawRequestTest" );
    }
}
?>