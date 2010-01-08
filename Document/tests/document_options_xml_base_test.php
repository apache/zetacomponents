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
class ezcDocumentOptionsXmlBaseTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentXmlOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'indentXml', false,
            ),
            array(
                'failOnError', true,
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'indentXml',
                array( true, false ),
            ),
            array(
                'failOnError',
                array( true, false ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'indentXml',
                array( 1, 'foo', .5, new StdClass(), array() ),
            ),
            array(
                'failOnError',
                array( 1, 'foo', .5, new StdClass(), array() ),
            ),
        );
    }
}

?>
