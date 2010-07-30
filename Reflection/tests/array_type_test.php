<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionArrayTypeTest extends ezcReflectionPrimitiveTypeTest
{
    /**
     * @var ezcReflectionArrayType
     */
    protected $type;

    public function setUp()
    {
        $this->type = new ezcReflectionArrayType( 'string[]' );
    }

    public function testGetTypeName()
    {
        self::assertEquals( 'string[]', $this->type->getTypeName() );
    }

    public function testGetGetKeyType()
    {
        $this->assertEquals( new ezcReflectionPrimitiveType( 'integer' ), $this->type->getKeyType() );
    }

    public function testGetValueType()
    {
        $this->assertEquals( new ezcReflectionPrimitiveType( 'string' ), $this->type->getValueType() );
    }

    public function testIsArray()
    {
        $this->assertTrue( $this->type->isArray() );
    }

    public function testIsMap()
    {
        $this->assertFalse( $this->type->isMap() );
    }

    public function testIsScalarType()
    {
        $this->assertFalse( $this->type->isScalarType() );
    }

    public function testGetXmlNameWithPrefix()
    {
        $this->assertEquals( 'tns:ArrayOfstring', $this->type->getXmlName( ) );
    }

    public function testGetXmlNameWithoutPrefix()
    {
        $this->assertEquals( 'ArrayOfstring', $this->type->getXmlName( false ) );
    }

    public function testGetNamespace()
    {
        $this->assertEquals( '', $this->type->getNamespace() );
    }

    public function testGetXmlSchema()
    {
        $expected = new DOMDocument;
        $expected->preserveWhiteSpace = false;
        $expected->load( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schemas' . DIRECTORY_SEPARATOR . 'array.xsd' );

        $actual = new DOMDocument;
        $actual->appendChild( $this->type->getXmlSchema( $actual ) );

        $this->assertEquals( $expected, $actual );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcReflectionArrayTypeTest' );
    }
}
?>
