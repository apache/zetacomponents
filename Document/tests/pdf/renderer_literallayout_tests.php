<?php
/**
 * ezcDocumentPdfDriverTcpdfTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'renderer_text_box_base_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfLiterallayoutRendererTests extends ezcDocumentPdfTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

        $this->styles = new ezcDocumentPdfStyleInferencer();
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'page' ),
                array(
                    'page-size' => 'TEST',
                    'margin'    => '0',
                    'padding'   => '10',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'literallayout' ),
                array(
                    'font-size' => '6mm',
                )
            ),
        ) );
    }

    public function testRenderLiterallayout()
    {
        // Additional formatting

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( "    " )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 24, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( "public" )
        );
        $mock->expects( $this->at( 9 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 34.8, 1. ), $this->equalTo( "    " )
        );
        $mock->expects( $this->at( 10 ) )->method( 'drawWord' )->with(
            $this->equalTo( 24, 1. ), $this->equalTo( 34.8, 1. ), $this->equalTo( "{" )
        );
        $mock->expects( $this->at( 11 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 43.2, 1. ), $this->equalTo( "        " )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/literallayout_short.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderLiterallayoutWrapped()
    {
        // Additional formatting

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
            'drawPolygon',
            'drawPolyline',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( "1" )
        );
        $mock->expects( $this->at( 13 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 85.2, 1. ), $this->equalTo( "9" )
        );
        $mock->expects( $this->at( 14 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 27 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 32 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( "9" )
        );
        $mock->expects( $this->at( 33 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 26.4, 1. ), $this->equalTo( "0" )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/literallayout_long.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }
}

?>
