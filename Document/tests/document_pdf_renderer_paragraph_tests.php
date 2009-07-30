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
    protected $styles;
    protected $page;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

        $this->document = new DOMDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );

        $this->document->load( dirname( __FILE__ ) . '/files/pdf/paragraph.xml' );

        $this->xpath = new DOMXPath( $this->document );
        $this->xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );

        $this->styles = new ezcDocumentPdfStyleInferencer();
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'font-size' => '8mm',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'margin' => '0mm',
                )
            ),
        ) );

        $this->page = new ezcDocumentPdfPage( 1, 108, 108, 108, 100 );
        $this->page->x = 0;
        $this->page->y = 0;
    }

    public function testRenderParagraphWithoutMarkup()
    {
        // Additional formatting

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderJustifiedParagraphWithoutMarkup()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'justify',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 50, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 72, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 17, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderCenteredParagraphWithoutMarkup()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'center',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 4, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 48, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 64, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 8, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderRightAlignedParagraphWithoutMarkup()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'text-align' => 'right',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 8, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 52, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 68, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 16, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphWithBoldMarkup()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 58, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 70, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderJustifiedParagraphWithHyphenator()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
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

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 54, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 80, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separa-' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'ted' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 23.5, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 37, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );
        $driver->expects( $this->at( 6 ) )->method( 'drawWord' )->with(
            $this->equalTo( 62.5, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'lines' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcTestDocumentPdfHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphWithDifferentTextSizes()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
                    'font-size'   => '12mm',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 22.3, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 85, 1. ), $this->equalTo( 22.3, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 36, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphMarkupSpaces()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Spaces' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( '*' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 32, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'should' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'not' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 78, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( '*' )
        );
        $driver->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 88, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'be' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 3 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphReduceRedundantSpace()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'emphasis' ),
                array(
                    'font-weight' => 'bold',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Spaces' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'should' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 68, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'not' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 90, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'be' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'doubled' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 4 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphLineHeight()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'line-height' => '1',
                )
            )
        ) );

        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'by' )
        );
        $driver->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'blank' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphWithReallyLongWord()
    {
        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'This_is_a_really_long_word_' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'to_ensure_even_those_are_ha' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 30.4, 1. ), $this->equalTo( 'ndled_properly_by_the_text_' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 6 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }

    public function testRenderParagraphWithoutWrappingPoints()
    {
        $driver = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $driver->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Testing' )
        );
        $driver->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 42, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'wrapping' )
        );
        $driver->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'without' )
        );
        $driver->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 42, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'any' )
        );

        $renderer  = new ezcDocumentPdfParagraphRenderer( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 7 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );
    }
}

?>
