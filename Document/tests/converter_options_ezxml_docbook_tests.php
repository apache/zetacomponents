<?php
/**
 * ezcDocTestConvertXhtmlDocbook
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/options_test_case.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcConverterEzXmlDocbookOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentEzXmlToDocbookConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'linkProvider', new ezcDocumentEzXmlDummyLinkProvider(),
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'linkProvider',
                array( new ezcDocumentEzXmlDummyLinkProvider() ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'linkProvider',
                array( 'foo', new StdClass() ),
            ),
        );
    }
}

?>
