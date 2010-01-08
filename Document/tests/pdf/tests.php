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

require_once 'base.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfTests extends ezcDocumentPdfTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderUnknownElements()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/unknown.xml' );

        try {
            $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
                'driver' => new ezcDocumentPdfSvgDriver(),
            ) ) );
            $pdfDoc->createFromDocbook( $docbook );
            $this->fail( 'Expected ezcDocumentVisitException.' );
        }
        catch ( ezcDocumentVisitException $e )
        { /* Expected */ }
    }

    public function testRenderUnknownElementsSilence()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/unknown.xml' );

        $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
            'driver'         => new ezcDocumentPdfSvgDriver(),
            'errorReporting' => E_PARSE,
        ) ) );
        $pdfDoc->createFromDocbook( $docbook );

        $errors = $pdfDoc->getErrors();
        $this->assertEquals( 2, count( $errors ) );
        $this->assertEquals(
            'Visitor error: Notice: \'Unknown and unhandled element: http://example.org/unknown:article.\' in line 0 at position 0.',
            end( $errors )->getMessage()
        );
    }

    public function testRenderDefault()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/long_text.xml' );

        $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
            'driver' => new ezcDocumentPdfSvgDriver(),
        ) ) );
        $pdfDoc->createFromDocbook( $docbook );
        $pdf = (string) $pdfDoc;

        file_put_contents(
            $this->tempDir . ( $fileName = __CLASS__ . '_' . __FUNCTION__ . '.svg' ),
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }

    public function testRenderCustomStyle()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/long_text.xml' );

        $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
            'driver' => new ezcDocumentPdfSvgDriver(),
        ) ) );
        $pdfDoc->loadStyles( dirname( __FILE__ ) . '/../files/pdf/custom.css' );
        $pdfDoc->createFromDocbook( $docbook );
        $pdf = (string) $pdfDoc;

        file_put_contents(
            $this->tempDir . ( $fileName = __CLASS__ . '_' . __FUNCTION__ . '.svg' ),
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }

    public function testRenderCustomStyleAndAdditionalPdfParts()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/long_text.xml' );

        $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
            'driver' => new ezcDocumentPdfSvgDriver(),
        ) ) );
        $pdfDoc->loadStyles( dirname( __FILE__ ) . '/../files/pdf/custom.css' );
        $pdfDoc->registerPdfPart( new ezcDocumentPdfHeaderPdfPart() );
        $pdfDoc->createFromDocbook( $docbook );
        $pdf = (string) $pdfDoc;

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
