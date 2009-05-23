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
class ezcDocumentPdfMediaObjectRendererTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;
    protected $styles;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderMainSinglePage()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/image.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            new ezcDocumentPdfStyleInferencer()
        );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );

        file_put_contents(
            $this->tempDir . ( $fileName = __CLASS__ . '_' . __FUNCTION__ . '.svg' ),
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }

    public function testRenderMainSplitParagraph()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/image.xml' );

        $style = new ezcDocumentPdfStyleInferencer();
        $style->appendStyleDirectives( array(
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
        ) );

        $renderer  = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            $style
        );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );

        file_put_contents(
            $this->tempDir . ( $fileName = __CLASS__ . '_' . __FUNCTION__ . '.svg' ),
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }
}

?>
