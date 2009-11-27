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
class ezcConverterDocbookEzXmlOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentDocbookToEzXmlConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'linkConverter', new ezcDocumentEzXmlDummyLinkConverter(),
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'linkConverter',
                array( new ezcDocumentEzXmlDummyLinkConverter() ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'linkConverter',
                array( 'foo', new StdClass() ),
            ),
        );
    }
}

?>
