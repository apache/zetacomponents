<?php
/**
 * ezcDocumentPdfDriverHaruTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'driver_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfTableColumnWidthCalculatorTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTableColumnWidths()
    {
        return array(
            array(
                'simple_tables.xml',
                '//doc:table[1]',
                array( .294, .294, .412 ),
            ),
            array(
                'simple_tables.xml',
                '//doc:table[2]',
                array( .3, .3, .4 ),
            ),
            array(
                'simple_tables.xml',
                '//doc:table[3]',
                array( .268, .732 ),
            ),
        );
    }

    /**
     * @dataProvider getTableColumnWidths
     */
    public function testTableColumnWidthEstimation( $file, $query, $expectation )
    {
        $doc = new DOMDocument();
        $doc->load( __DIR__ . '/../files/pdf/' . $file );

        $xpath = new DOMXPath( $doc );
        $xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );
        $table = $xpath->query( $query )->item( 0 );

        $calculator = new ezcDocumentPdfDefaultTableColumnWidthCalculator();
        $this->assertEquals(
            $expectation,
            $calculator->estimateWidths( $table ),
            'Wrong table width estimations',
            .001
        );
    }
}

?>
