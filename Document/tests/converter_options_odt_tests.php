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
class ezcConverterOdtOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentDocbookToOdtConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'styler', new ezcDocumentOdtPcssStyler(),
            ),
            array(
                'lengthMeasure', 'px',
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'template',
                array( __FILE__ ),
            ),
            array(
                'styler',
                array( new ezcDocumentOdtPcssStyler() ),
            ),
            array(
                'lengthMeasure',
                array( 'cm', 'mm', 'in', 'pt', 'pc', 'px' ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'template',
                array( 'foo', '23', new StdClass() ),
            ),
            array(
                'styler',
                array( 'foo', 23, new StdClass() ),
            ),
            array(
                'lengthMeasure',
                array( 'foo', 23, new StdClass() ),
            ),
        );
    }
}

?>
