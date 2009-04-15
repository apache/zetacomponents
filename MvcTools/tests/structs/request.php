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
 * Test the struct ezcMvcRequest.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRequestTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRequest();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRequest();
        $struct->date = 'php';
        $this->assertEquals( 'php', $struct->date, 'Property date does not have the expected value' );
        $struct->protocol = 'ezc';
        $this->assertEquals( 'ezc', $struct->protocol, 'Property protocol does not have the expected value' );
        $struct->host = 'ezp';
        $this->assertEquals( 'ezp', $struct->host, 'Property host does not have the expected value' );
        $struct->uri = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->uri, 'Property uri does not have the expected value' );
        $struct->requestId = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->requestId, 'Property requestId does not have the expected value' );
        $struct->referrer = 'django';
        $this->assertEquals( 'django', $struct->referrer, 'Property referrer does not have the expected value' );
        $struct->variables = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->variables, 'Property variables does not have the expected value' );
        $struct->body = 'vim';
        $this->assertEquals( 'vim', $struct->body, 'Property body does not have the expected value' );
        $struct->files = 'linux';
        $this->assertEquals( 'linux', $struct->files, 'Property files does not have the expected value' );
        $struct->accept = 'gentoo';
        $this->assertEquals( 'gentoo', $struct->accept, 'Property accept does not have the expected value' );
        $struct->agent = 'debian';
        $this->assertEquals( 'debian', $struct->agent, 'Property agent does not have the expected value' );
        $struct->authentication = 'oop';
        $this->assertEquals( 'oop', $struct->authentication, 'Property authentication does not have the expected value' );
        $struct->raw = 'random';
        $this->assertEquals( 'random', $struct->raw, 'Property raw does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'date' => 'php',
        'protocol' => 'ezc',
        'host' => 'ezp',
        'uri' => 'buddymiles',
        'requestId' => 'buddyguy',
        'referrer' => 'django',
        'variables' => 'satchmo',
        'body' => 'vim',
        'files' => 'linux',
        'accept' => 'gentoo',
        'agent' => 'debian',
        'authentication' => 'oop',
        'raw' => 'random',
        'cookies' => 'foo',
        'isFatal' => false,
        );
        $struct = ezcMvcRequest::__set_state( $state );
        $this->assertEquals( 'php', $struct->date, 'Property date does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->protocol, 'Property protocol does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->host, 'Property host does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->uri, 'Property uri does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->requestId, 'Property requestId does not have the expected value' );
        $this->assertEquals( 'django', $struct->referrer, 'Property referrer does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->variables, 'Property variables does not have the expected value' );
        $this->assertEquals( 'vim', $struct->body, 'Property body does not have the expected value' );
        $this->assertEquals( 'linux', $struct->files, 'Property files does not have the expected value' );
        $this->assertEquals( 'gentoo', $struct->accept, 'Property accept does not have the expected value' );
        $this->assertEquals( 'debian', $struct->agent, 'Property agent does not have the expected value' );
        $this->assertEquals( 'oop', $struct->authentication, 'Property authentication does not have the expected value' );
        $this->assertEquals( 'random', $struct->raw, 'Property raw does not have the expected value' );
        $this->assertEquals( 'foo', $struct->cookies, 'Property raw does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRequestTest" );
    }
}
?>
