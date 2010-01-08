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
class ezcConverterRstOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentDocbookToRstConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'headerTypes', array( '==', '--', '=', '-', '^', '~', '`', '*', ':', '+', '/', '.', ),
            ),
            array(
                'wordWrap', 78,
            ),
            array(
                'itemListCharacter', '-',
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'headerTypes',
                array( array( '--' ), array( '--', '=', '"' ) ),
            ),
            array(
                'wordWrap',
                array( 20, 1023 ),
            ),
            array(
                'itemListCharacter',
                array( '*', "\xe2\x80\xa2" ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'headerTypes',
                array( '--', 23 ),
            ),
            array(
                'wordWrap',
                array( 'foo', new StdClass() ),
            ),
            array(
                'itemListCharacter',
                array( '>', 23 ),
            ),
        );
    }
}

?>
