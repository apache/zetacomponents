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
require_once 'helper/pdf_mocked_driver.php';
require_once 'helper/pdf_test_hyphenator.php';

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

    public function testRenderCenteredParagraphWithoutMarkup()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting
        $styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'center',
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
            $this->equalTo( 44, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 4, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 16, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcDocumentPdfDefaultHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 0 )
        );
    }

    public function testRenderRightAlignedParagraphWithoutMarkup()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting
        $styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'right',
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
            $this->equalTo( 44, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 8, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcDocumentPdfDefaultHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 0 )
        );
    }

    public function testRenderParagraphWithBoldMarkup()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting
        $styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
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
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcDocumentPdfDefaultHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 1 )
        );
    }

    public function testRenderJustifiedParagraphWithHyphenator()
    {
        $styles = new ezcDocumentPdfStyleInferencer();

        // Additional formatting
        $styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'justify',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
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
            $this->equalTo( 64, 1. ), $this->equalTo( 0, 1. ), $this->equalTo( 'separ-' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'ated' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 31.3, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 50.6, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'blank' )
        );
        $driver->expects( $this->at( 6 ) )->method( 'drawWord' )->with(
            $this->equalTo( 88, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'l-' )
        );
        $driver->expects( $this->at( 7 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'ines' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $styles );
        $renderer->render(
            new ezcDocumentPdfPage( 100, 100 ),
            new ezcTestDocumentPdfHyphenator(),
            $this->xpath->query( '//doc:para' )->item( 1 )
        );
    }
}

?>
