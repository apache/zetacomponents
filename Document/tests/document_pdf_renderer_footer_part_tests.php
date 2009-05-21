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
class ezcDocumentPdfRendererFooterPartTests extends ezcDocumentPdfTestCase
{
    protected $renderer;
    protected $docbook;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        parent::setUp();

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

        $this->docbook = new ezcDocumentDocbook();
        $this->docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/long_text.xml' );

        $this->renderer = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            $style
        );
    }

    public function testRenderDefaultFooter()
    {
        $this->renderer->registerPdfPart(
            new ezcDocumentPdfFooterPdfPart()
        );

        $pdf = $this->renderer->render(
            $this->docbook,
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

    public function testRenderHeader()
    {
        $this->renderer->registerPdfPart(
            new ezcDocumentPdfFooterPdfPart( new ezcDocumentPdfFooterOptions( array(
                'footer' => false,
            ) ) )
        );

        $pdf = $this->renderer->render(
            $this->docbook,
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

    public function testRenderHeaderAndFooter()
    {
        $this->renderer->registerPdfPart(
            new ezcDocumentPdfFooterPdfPart( new ezcDocumentPdfFooterOptions( array(
                'showDocumentTitle'  => false,
                'showDocumentAuthor' => false,
                'pageNumberOffset'   => 7,
                'height'             => '5mm',
            ) ) )
        );

        $this->renderer->registerPdfPart(
            new ezcDocumentPdfHeaderPdfPart( new ezcDocumentPdfFooterOptions( array(
                'showPageNumber'   => false,
                'height'           => '10mm',
            ) ) )
        );

        $pdf = $this->renderer->render(
            $this->docbook,
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
