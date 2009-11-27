<?php
/**
 * ezcDocTestConvertXhtmlDocbook
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/options_test_case.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentDocbookOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentDocbookOptions';
    }

    public function testOptionsDefaultValues( $property = 'schema', $value = null )
    {
        $class = $this->getOptionsClassName();
        $option = new $class();

        $this->assertTrue(
            strpos( $option->$property, 'docbook.xsd' ) !== false
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'schema',
                array( __FILE__ ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'schema',
                array( 'foo', 12 ),
            ),
        );
    }
}

?>
