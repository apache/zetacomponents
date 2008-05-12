<?php
/**
 * ezcDocTestConvertXhtmlDocbook
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/options_test_case.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentConverterOptionsEzp3ToEzp4Tests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentEzp3ToEzp4ConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'customInlineTags', array(),
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'customInlineTags',
                array( array(), array( 'foo' ), array( 'foo', 'bar' ) ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'customInlineTags',
                array( 
                    1, 'foo', .5, new StdClass()
                    // This should faild too, but does not yet:
                    // array( 1 ), array( '<foo>' ), array( new StdClass() ),
                ),
            ),
        );
    }
}

?>
