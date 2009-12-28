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
    protected $type;

    public function setUp()
    {
        $this->type = $this->getMock(
            'ezcReflectionAbstractType',
            array(
            	'isScalarType', 'getXmlName', 'getXmlSchema', 'getTypeName'
            ),
            array( 'string' )
        );
    }

    public function testIsArray()
    {
        $this->assertFalse( $this->type->isArray() );
    }

    public function testIsObject()
    {
        $this->assertFalse( $this->type->isObject() );
    }

    public function testIsPrimitive()
    {
        $this->assertFalse( $this->type->isPrimitive() );
    }

    public function testIsMap()
    {
        $this->assertFalse( $this->type->isMap() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcReflectionAbstractTypeTest' );
    }
}
?>
