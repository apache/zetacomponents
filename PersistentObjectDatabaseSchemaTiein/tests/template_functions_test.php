<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
