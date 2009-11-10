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

require_once dirname( __FILE__ ) . '/../helper/pdf_mocked_driver.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPcssMeasureTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getUnitConversions()
    {
        return array(
            array( '10', 'mm', 10 ),
            array( '10mm', 'mm', 10 ),
            array( 10, 'mm', 10 ),
            array( .1, 'mm', .1 ),
            array( '.1in', 'mm', 2.54 ),
            array( '10pt', 'mm', 3.53 ),
            array( '10px', 'mm', 3.53 ),
            array( '10px', 'px', 10 ),
            array( '10px', 'pt', 10 ),
            array( '10pt', 'px', 10 ),
            array( '10', 'pt', 28.35 ),
            array( '10', 'px', 28.35 ),
            array( '10', 'in', .39 ),
            array( '-2.3pt', 'mm', -.81 ),
            array( '+2.3pt', 'mm', .81 ),
        );
    }

    /**
     * @dataProvider getUnitConversions
     */
    public function testValueConversion( $input, $unit, $expected )
    {
        $measure = new ezcDocumentPcssMeasure( $input );
        $this->assertEquals(
            $expected,
            $measure->get( $unit ),
            "Converting $input to $unit lead to unexpected result.",
            .1
        );
    }

    public function testUnparsableValue()
    {
        try {
            ezcDocumentPcssMeasure::create( '10 mm' )->get();
            $this->fail( 'Expected ezcDocumentParserException.' );
        }
        catch ( ezcDocumentParserException $e )
        { /* Expected */ }
    }

    public function testUnhandledUnit1()
    {
        $driver = new ezcTestDocumentPdfMockDriver();

        try {
            ezcDocumentPcssMeasure::create( '10foo' )->get();
            $this->fail( 'Expected ezcDocumentParserException.' );
        }
        catch ( ezcDocumentParserException $e )
        { /* Expected */ }
    }

    public function testUnhandledUnit2()
    {
        $driver = new ezcTestDocumentPdfMockDriver();

        try {
            ezcDocumentPcssMeasure::create( '10mm' )->get( 'foo' );
            $this->fail( 'Expected ezcDocumentParserException.' );
        }
        catch ( ezcDocumentParserException $e )
        { /* Expected */ }
    }
}

?>
