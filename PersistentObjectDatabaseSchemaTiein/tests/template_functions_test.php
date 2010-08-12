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
class ezcPersistentObjectSchemaTemplateFunctionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(__CLASS__ );
    }

    public function testUnderScoreToCamelCaseFirstUpper()
    {
        $this->assertEquals(
            'MyCoolClassName',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                'my_cool_class_name'
            )
        );
    }

    public function testUnderScoreToCamelCaseFirstLower()
    {
        $this->assertEquals(
            'myCoolPropertyName',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                'my_cool_property_name',
                true
            )
        );
    }

    public function testUnderScoreToCamelCaseFirstUpperOneElement()
    {
        $this->assertEquals(
            'Class',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                'class'
            )
        );
    }

    public function testUnderScoreToCamelCaseFirstLowerOneElement()
    {
        $this->assertEquals(
            'property',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                'property',
                true
            )
        );
    }

    public function testUnderScoreToCamelCaseFirstUpperEmpty()
    {
        $this->assertEquals(
            '',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                ''
            )
        );
    }

    public function testUnderScoreToCamelCaseFirstLowerEmpty()
    {
        $this->assertEquals(
            '',
            ezcPersistentObjectSchemaTemplateFunctions::underScoreToCamelCase(
                '',
                true
            )
        );
    }
}
?>
