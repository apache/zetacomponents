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
class ezcDocumentPdfFooterOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentPdfFooterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'height', ezcDocumentPcssMeasure::create( '15mm' ),
            ),
            array(
                'footer', true,
            ),
            array(
                'showDocumentTitle', true,
            ),
            array(
                'showDocumentAuthor', true,
            ),
            array(
                'showPageNumber', true,
            ),
            array(
                'pageNumberOffset', 0,
            ),
            array(
                'centerPageNumber', false,
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'footer',
                array( true, false ),
            ),
            array(
                'showDocumentTitle',
                array( true, false ),
            ),
            array(
                'showDocumentAuthor',
                array( true, false ),
            ),
            array(
                'showPageNumber',
                array( true, false ),
            ),
            array(
                'centerPageNumber',
                array( true, false ),
            ),
            array(
                'pageNumberOffset',
                array( 0, 1, 23 ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'height',
                array( '15nm', 'foo', new StdClass() ),
            ),
            array(
                'footer',
                array( 1, 23, 'foo', new StdClass() ),
            ),
            array(
                'showDocumentTitle',
                array( 1, 23, 'foo', new StdClass() ),
            ),
            array(
                'showDocumentAuthor',
                array( 1, 23, 'foo', new StdClass() ),
            ),
            array(
                'showPageNumber',
                array( 1, 23, 'foo', new StdClass() ),
            ),
            array(
                'centerPageNumber',
                array( 1, 23, 'foo', new StdClass() ),
            ),
            array(
                'pageNumberOffset',
                array( true, 'foo', new StdClass() ),
            ),
        );
    }
}

?>
