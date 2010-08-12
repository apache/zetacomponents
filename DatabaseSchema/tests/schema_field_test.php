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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaFieldTest extends ezcTestCase
{
    public function testConstructorAllDefault()
    {
        $schemaField = new ezcDbSchemaField( 'text' );
        self::assertEquals( $schemaField->type, 'text' );
        self::assertEquals( $schemaField->length, 0 );
        self::assertEquals( $schemaField->notNull, false );
        self::assertEquals( $schemaField->default, null );
        self::assertEquals( $schemaField->autoIncrement, false );
        self::assertEquals( $schemaField->unsigned, false );
    }

    public function testConstructorAllGiven1()
    {
        $schemaField = new ezcDbSchemaField( 'text', 40, true, 'testing', true, false );
        self::assertEquals( $schemaField->type, 'text' );
        self::assertEquals( $schemaField->length, 40 );
        self::assertEquals( $schemaField->notNull, true );
        self::assertEquals( $schemaField->default, 'testing' );
        self::assertEquals( $schemaField->autoIncrement, true );
        self::assertEquals( $schemaField->unsigned, false );
    }

    public function testConstructorAllGiven2()
    {
        $schemaField = new ezcDbSchemaField( 'enum', false, true, 'b', true, false );
        self::assertEquals( $schemaField->type, 'enum' );
        self::assertEquals( $schemaField->length, 0 );
        self::assertEquals( $schemaField->notNull, true );
        self::assertEquals( $schemaField->default, 'b' );
        self::assertEquals( $schemaField->autoIncrement, true );
        self::assertEquals( $schemaField->unsigned, false );
    }

    public function testSetStatePerfect1()
    {
        $a = array();
        $a['type'] = 'integer';
        $a['length'] = 42;
        $a['notNull'] = true;
        $a['default'] = 12;
        $a['autoIncrement'] = false;
        $a['unsigned'] = false;
        $schemaField = ezcDbSchemaField::__set_state( $a );
        self::assertEquals( $schemaField->type, 'integer' );
        self::assertEquals( $schemaField->length, 42 );
        self::assertEquals( $schemaField->notNull, true );
        self::assertEquals( $schemaField->default, 12 );
        self::assertEquals( $schemaField->autoIncrement, false );
        self::assertEquals( $schemaField->unsigned, false );
    }

    public function testSetStatePerfect2()
    {
        $a = array();
        $a['type'] = 'integer';
        $a['length'] = 42;
        $a['notNull'] = true;
        $a['default'] = 12;
        $a['autoIncrement'] = false;
        $a['unsigned'] = false;
        $schemaField = ezcDbSchemaField::__set_state( $a );
        self::assertEquals( $schemaField->type, 'integer' );
        self::assertEquals( $schemaField->length, 42 );
        self::assertEquals( $schemaField->notNull, true );
        self::assertEquals( $schemaField->default, 12 );
        self::assertEquals( $schemaField->autoIncrement, false );
        self::assertEquals( $schemaField->unsigned, false );
    }

    public function testSetStateCastValues()
    {
        $a = array();
        $a['type'] = 'integer';
        $a['length'] = '42';
        $a['notNull'] = 1;
        $a['default'] = true;
        $a['autoIncrement'] = '0';
        $a['unsigned'] = 'true';
        $schemaField = ezcDbSchemaField::__set_state( $a );
        self::assertEquals( $schemaField->type, 'integer' );
        self::assertEquals( $schemaField->length, 42 );
        self::assertEquals( $schemaField->notNull, true );
        self::assertEquals( $schemaField->default, true );
        self::assertEquals( $schemaField->autoIncrement, false );
        self::assertEquals( $schemaField->unsigned, true );
    }

    public function testSetIntegerDefaultAsStringNumberIsCasted()
    {
        $field = new ezcDbSchemaField( 'integer', 10, false, "5", false, false );
        $this->assertSame( 5, $field->default );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaFieldTest' );
    }
}
?>
