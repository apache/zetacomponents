<?php
/**
 * ezcDocumentPdfDriverTcpdfTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'renderer_text_box_base_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfBlockquoteRendererTests extends ezcDocumentPdfTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

        $this->styles = new ezcDocumentPcssStyleInferencer();
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPcssLayoutDirective(
                array( 'page' ),
                array(
                    'page-size' => 'TEST',
                    'margin'    => '0',
                    'padding'   => '10',
                )
            ),
            new ezcDocumentPcssLayoutDirective(
                array( 'blockquote' ),
                array(
                    'font-size' => '6mm',
                )
            ),
        ) );
    }

    public function testRenderBlockquote()
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
            $this->equalTo( 20, 1. ), $this->equalTo( 21, 1. ), $this->equalTo( "Some" )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 35, 1. ), $this->equalTo( 21, 1. ), $this->equalTo( "random" )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 29.4, 1. ), $this->equalTo( "which" )
        );
        $mock->expects( $this->at( 13 ) )->method( 'drawWord' )->with(
            $this->equalTo( 25, 1. ), $this->equalTo( 46.8, 1. ), $this->equalTo( "Name" )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/blockquote.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }
}

?>
