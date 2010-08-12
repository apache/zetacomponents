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
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateValidationItemTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateValidationItemTest" );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $validation = new ezcTemplateValidationItem( ezcTemplateValidationItem::TYPE_ERROR,
                                                     'templates/zhadum.tpl', 4, 20,
                                                     'template is not valid', 'unknown function "list_types"' );

        self::assertSame( ezcTemplateValidationItem::TYPE_ERROR, $validation->type, 'Property <type> does not return correct value.' );
        self::assertSame( 'templates/zhadum.tpl', $validation->filePath, 'Property <filePath> does not return correct value.' );
        self::assertSame( 4, $validation->line, 'Property <line> does not return correct value.' );
        self::assertSame( 20, $validation->column, 'Property <column> does not return correct value.' );
        self::assertSame( 'template is not valid', $validation->description, 'Property <description> does not return correct value.' );
        self::assertSame( 'unknown function "list_types"', $validation->details, 'Property <details> does not return correct value.' );
    }

    /**
     * Test modifying properties
     */
    public function testSetProperties()
    {
        $validation = new ezcTemplateValidationItem( ezcTemplateValidationItem::TYPE_ERROR,
                                                     'templates/zhadum.tpl', 4, 20,
                                                     'template is not valid', 'unknown function "list_types"' );

        self::assertSetProperty( $validation, 'type', array( ezcTemplateValidationItem::TYPE_WARNING, ezcTemplateValidationItem::TYPE_ERROR ) );
        self::assertSetProperty( $validation, 'filePath', array( 'templates/pagelayout.tpl', '', 'templates/zhadum.tpl' ) );
        self::assertSetProperty( $validation, 'line', array( 0, 1, 200, 4 ) );
        self::assertSetProperty( $validation, 'column', array( 0, 1, 5, 20 ) );
        self::assertSetProperty( $validation, 'description', array( 'errors in template', 'template is not valid' ) );
        self::assertSetProperty( $validation, 'details', array( 'invalid syntax {$list|wash}', 'unknown function "list_types"' ) );
    }
}

?>
