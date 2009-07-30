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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfMainRendererTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;
    protected $styles;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderUnknownElements()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/unknown.xml' );

        try {
            $renderer  = new ezcDocumentPdfMainRenderer(
                new ezcDocumentPdfSvgDriver(),
                new ezcDocumentPdfStyleInferencer()
            );

            $pdf = $renderer->render(
                $docbook,
                new ezcDocumentPdfDefaultHyphenator()
            );
            $this->fail( 'Expected ezcDocumentVisitException.' );
        }
        catch ( ezcDocumentVisitException $e )
        { /* Expected */ }
    }

    public function testRenderUnknownElementsSilence()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/unknown.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            new ezcDocumentPdfStyleInferencer(),
            E_PARSE
        );

        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );

        $errors = $renderer->getErrors();
        $this->assertEquals( 1, count( $errors ) );
        $this->assertEquals(
            'Visitor error: Notice: \'Unknown and unhandled element: http://example.org/unknown:article.\' in line 0 at position 0.',
            reset( $errors )->getMessage()
        );
    }

    protected function renderFile( $file, $fileName, array $styles = array() )
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( $file );

        $style = new ezcDocumentPdfStyleInferencer();
        $style->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'font-family'  => 'serif',
                    'line-height'  => '1',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'title' ),
                array(
                    'font-family'  => 'sans-serif',
                )
            ),
        ) );
        $style->appendStyleDirectives( $styles );

        $renderer  = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            $style
        );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );

        file_put_contents(
            $this->tempDir . $fileName,
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }

    public function testRenderMainSinglePage()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/paragraph.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }

    public function testRenderMainSinglePageNotNamespaced()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/paragraph_nons.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }

    public function testRenderMainMulticolumnLayout()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/paragraph.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '3',
                        'line-height'  => '1',
                    )
                ),
            )
        );
    }

    public function testRenderMainSplitParagraph()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/long_text.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'font-size'    => '10pt',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderMainSplitParagraphHandleOrphans()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/orphans.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'widows'       => '0',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderMainSplitParagraphHandleShortOrphans()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/orphans_short.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'widows'       => '0',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderMainSplitParagraphHandleWidows()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/widows.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'widows'       => '3',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderMainSplitParagraphHandleOrphansAndWidows()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/orphans_widows.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'widows'       => '3',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderMainShiftTitleNotFollowedByParagraph()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/long_text.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPdfCssDirective(
                    array( 'article' ),
                    array(
                        'text-columns' => '2',
                        'font-size'    => '11.5pt',
                        'widows'       => '3',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'title' ),
                    array(
                        'text-columns' => '2',
                    )
                ),
                new ezcDocumentPdfCssDirective(
                    array( 'page' ),
                    array(
                        'page-size'    => 'A5',
                    )
                ),
            )
        );
    }

    public function testRenderLongTextParagraphConflict()
    {
        $this->renderFile(
            dirname( __FILE__ ) . '/files/pdf/test_long_wrapping.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array()
        );
    }
}

?>
