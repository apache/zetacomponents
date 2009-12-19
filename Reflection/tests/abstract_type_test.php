<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionAbstractTypeTest extends ezcTestCase
{
    /**
     * @var ezcReflectionAbstractType
     */
    protected $mock;

    public function setUp()
    {
        $this->mock = $this->getMock(
            'ezcReflectionAbstractType',
            array(
            	'isScalarType', 'getXmlName', 'getXmlSchema', 'getTypeName'
            ),
            array( 'string' )
        );
    }

    public function testIsArray()
    {
        $this->assertFalse( $this->mock->isArray() );
    }

    public function testIsClass()
    {
        $this->assertFalse( $this->mock->isClass() );
    }

    public function testIsPrimitive()
    {
        $this->assertFalse( $this->mock->isPrimitive() );
    }

    public function testIsMap()
    {
        $this->assertFalse( $this->mock->isMap() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionAbstractTypeTest' );
    }
}
?>
