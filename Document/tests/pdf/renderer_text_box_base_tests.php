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

require_once 'base.php';
require_once dirname( __FILE__ ) . '/../helper/pdf_mocked_driver.php';
require_once dirname( __FILE__ ) . '/../helper/pdf_test_hyphenator.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfTextBoxRendererBaseTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;
    protected $styles;
    protected $page;

    /**
     * Renderer used for the tests
     * 
     * @var string
     */
    protected $renderer = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

        $this->document = new DOMDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );

        $this->document->load( dirname( __FILE__ ) . '/../files/pdf/paragraph.xml' );

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
                array( 'page' ),
                array(
                    'page-size' => 'TEST',
                    'margin'    => '0',
                    'padding'   => '10',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'margin'  => '0mm',
                    'padding' => '0',
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 50, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 72, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 17, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 4, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 48, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 64, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 8, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 8, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 52, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 68, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 16, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 58, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 70, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 54, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 80, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separa-' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'ted' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 23.5, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 37, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'blank' )
        );
        $mock->expects( $this->at( 6 ) )->method( 'drawWord' )->with(
            $this->equalTo( 62.5, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'lines' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcTestDocumentPdfHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 22.3, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 85, 1. ), $this->equalTo( 22.3, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 36, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 1 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Spaces' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( '*' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 32, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'should' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'not' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 78, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( '*' )
        );
        $mock->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 88, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'be' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 3 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Spaces' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 28, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'should' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 68, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'not' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 90, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'be' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'doubled' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 4 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
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

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 44, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 12, 1. ), $this->equalTo( 16, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithReallyLongWord()
    {
        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'This_is_a_really_long_word_' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'to_ensure_even_those_are_ha' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 30.4, 1. ), $this->equalTo( 'ndled_properly_by_the_text_' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 6 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithoutPoints()
    {
        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'Testing' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 42, 1. ), $this->equalTo( 8, 1. ), $this->equalTo( 'wrapping' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 0, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'without' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 42, 1. ), $this->equalTo( 19.2, 1. ), $this->equalTo( 'any' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 7 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithPadding()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'line-height' => '1',
                    'padding'     => '10',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 54, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 50, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 62, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithMargin()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'line-height' => '1',
                    'margin'      => '10',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawWord'
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 54, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 50, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 62, 1. ), $this->equalTo( 26, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithPaddingMarginAndBackground()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'line-height'      => '1',
                    'padding'          => '10',
                    'margin'           => '10',
                    'background-color' => '#eeeeef',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawPolyline',
            'drawPolygon',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawPolygon' )->with(
            $this->equalTo( array(
                array( 10, 10 ),
                array( 98, 10 ),
                array( 98, 70 ),
                array( 10, 70 ),
            ), 1. ),
            $this->equalTo( array(
                'red'   => .93,
                'green' => .93,
                'blue'  => .94,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 28, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawWord' )->with(
            $this->equalTo( 64, 1. ), $this->equalTo( 28, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 36, 1. ), $this->equalTo( 'separated' )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawWord' )->with(
            $this->equalTo( 60, 1. ), $this->equalTo( 36, 1. ), $this->equalTo( 'by' )
        );
        $mock->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 20, 1. ), $this->equalTo( 44, 1. ), $this->equalTo( 'blank' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }

    public function testRenderParagraphWithPaddingMarginAndBorder()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'para' ),
                array(
                    'line-height'      => '1',
                    'padding'          => '10',
                    'margin'           => '10',
                    'border'           => '1mm solid #A00000',
                    'background-color' => '#eedbdb',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'drawPolyline',
            'drawPolygon',
            'drawWord',
        ) );

        // Expectations
        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'drawPolygon' )->with(
            $this->equalTo( array(
                array( 10, 10 ),
                array( 98, 10 ),
                array( 98, 72 ),
                array( 10, 72 ),
            ), 1. ),
            $this->equalTo( array(
                'red'   => .93,
                'green' => .86,
                'blue'  => .86,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawPolyline' )->with(
            $this->equalTo( array( array( 10.5, 10.5 ), array( 10.5, 71.5 ) ), .1 ),
            $this->equalTo( array(
                'red'   => .63,
                'green' => .0,
                'blue'  => .0,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 2 ) )->method( 'drawPolyline' )->with(
            $this->equalTo( array( array( 10.5, 10.5 ), array( 97.5, 10.5 ) ), .1 ),
            $this->equalTo( array(
                'red'   => .63,
                'green' => .0,
                'blue'  => .0,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 3 ) )->method( 'drawPolyline' )->with(
            $this->equalTo( array( array( 97.5, 10.5 ), array( 97.5, 71.5 ) ), .1 ),
            $this->equalTo( array(
                'red'   => .63,
                'green' => .0,
                'blue'  => .0,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 4 ) )->method( 'drawPolyline' )->with(
            $this->equalTo( array( array( 97.5, 71.5 ), array( 10.5, 71.5 ) ), .1 ),
            $this->equalTo( array(
                'red'   => .63,
                'green' => .0,
                'blue'  => .0,
                'alpha' => 0
            ), .01 )
        );
        $mock->expects( $this->at( 5 ) )->method( 'drawWord' )->with(
            $this->equalTo( 21, 1. ), $this->equalTo( 29, 1. ), $this->equalTo( 'Paragraphs' )
        );
        $mock->expects( $this->at( 6 ) )->method( 'drawWord' )->with(
            $this->equalTo( 65, 1. ), $this->equalTo( 29, 1. ), $this->equalTo( 'are' )
        );
        $mock->expects( $this->at( 7 ) )->method( 'drawWord' )->with(
            $this->equalTo( 21, 1. ), $this->equalTo( 37, 1. ), $this->equalTo( 'separated' )
        );

        $driver = new ezcDocumentPdfTransactionalDriverWrapper();
        $driver->setDriver( $mock );

        $rendererClass = $this->renderer;
        $renderer  = new $rendererClass( $driver, $this->styles );
        $this->assertTrue( $renderer->render(
            $this->page,
            new ezcDocumentPdfDefaultHyphenator(),
            new ezcDocumentPdfDefaultTokenizer(),
            $this->xpath->query( '//doc:para' )->item( 0 ),
            new ezcDocumentPdfMainRenderer( $driver, $this->styles )
        ) );

        $driver->commit();
    }
}

?>
