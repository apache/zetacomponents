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
class ezcConverterXsltOptionsTests extends ezcDocumentOptionsTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function getOptionsClassName()
    {
        return 'ezcDocumentXsltConverterOptions';
    }

    public static function provideDefaultValues()
    {
        return array(
            array(
                'xslt', null,
            ),
            array(
                'parameters', array(),
            ),
            array(
                'failOnError', false,
            ),
        );
    }

    public static function provideValidData()
    {
        return array(
            array(
                'xslt',
                array( 'http://example.org/' ),
            ),
            array(
                'parameters',
                array( array( 'foo' => 'bar' ) ),
            ),
            array(
                'failOnError',
                array( true ),
            ),
        );
    }

    public static function provideInvalidData()
    {
        return array(
            array(
                'parameters',
                array( 'foo', new StdClass() ),
            ),
            array(
                'failOnError',
                array( 'foo', 23 ),
            ),
        );
    }
}

?>
