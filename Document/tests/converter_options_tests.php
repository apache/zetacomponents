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
class ezcConverterOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'errorReporting', 15,
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
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'errorReporting',
                array( 'foo', E_ALL & ~E_PARSE ),
            ),
        );
    }
}

?>
