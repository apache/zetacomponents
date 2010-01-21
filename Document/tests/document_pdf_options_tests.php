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
class ezcDocumentPdfOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentPdfOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'errorReporting', 15,
            ),
            array(
                'hyphenator', new ezcDocumentPdfDefaultHyphenator(),
            ),
            array(
                'tokenizer', new ezcDocumentPdfDefaultTokenizer(),
            ),
            array(
                'tableColumnWidthCalculator', new ezcDocumentPdfDefaultTableColumnWidthCalculator(),
            ),
            array(
                'driver', null,
            ),
            array(
                'compress', false,
            ),
            array(
                'ownerPassword', null,
            ),
            array(
                'userPassword', null,
            ),
            array(
                'permissions', -1,
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'errorReporting',
                array( E_PARSE, E_PARSE | E_NOTICE ),
            ),
            array(
                'hyphenator',
                array( new ezcDocumentPdfDefaultHyphenator() ),
            ),
            array(
                'tokenizer',
                array( new ezcDocumentPdfDefaultTokenizer() ),
            ),
            array(
                'tableColumnWidthCalculator',
                array( new ezcDocumentPdfDefaultTableColumnWidthCalculator() ),
            ),
            array(
                'driver',
                array( new ezcDocumentPdfHaruDriver() ),
            ),
            array(
                'compress',
                array( true, false ),
            ),
            array(
                'ownerPassword',
                array( 'foo', null ),
            ),
            array(
                'userPassword',
                array( null ),
            ),
            array(
                'permissions',
                array( 0, -1, ezcDocumentPdfOptions::EDIT | ezcDocumentPdfOptions::PRINTABLE ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'errorReporting',
                array( 'foo', E_ALL & ~E_PARSE ),
            ),
            array(
                'hyphenator',
                array( 'foo', new StdClass() ),
            ),
            array(
                'tokenizer',
                array( 'foo', new StdClass() ),
            ),
            array(
                'tableColumnWidthCalculator',
                array( 'foo', new StdClass() ),
            ),
            array(
                'driver',
                array( 'foo', new StdClass() ),
            ),
            array(
                'compress',
                array( 1, null, 23.4, 'foo', new StdClass() ),
            ),
            array(
                'ownerPassword',
                array( 1, 23.4, new StdClass() ),
            ),
            array(
                'userPassword',
                array( 'foo', 1, 23.4, new StdClass() ),
            ),
            array(
                'permissions',
                array( null, 23.4, 'foo', new StdClass() ),
            ),
        );
    }
}

?>
