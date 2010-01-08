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
class ezcDocumentOptionsOdtTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentOdtOptions';
    }

    public static function provideDefaultValues()
    {
        $res = array(
            array(
                'indentXml', false,
            ),
            array(
                'failOnError', true,
            ),
            array(
                'imageDir', sys_get_temp_dir()
            )
        );
        return $res;
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
            array(
                'imageDir', array( dirname( __FILE__ ) )
            )
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
            array(
                'imageDir', array( '/foo', 'bar', 23, true, false, array() )
            )
        );
    }
}

?>
