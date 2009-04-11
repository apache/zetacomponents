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

require_once 'pdf_test.php';
require_once 'pdf_mocked_driver.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfParagraphRendererTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

        $this->document = new DOMDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );

        $this->document->load( dirname( __FILE__ ) . '/files/pdf/renderer/paragraph.xml' );

        $this->xpath = new DOMXPath( $this->document );
        $this->xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );
    }

    public function testRenderParagraphWithoutMarkup()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting

        $driver = $this->getMock( 'ezcTextDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcDocumentPdfDefaultHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 0 )
        );
    }

    public function testRenderJustifiedParagraphWithoutMarkup()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting
        $styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'justify',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTextDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 46, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 64, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 14, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcDocumentPdfDefaultHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 0 )
        );
    }
}

?>
