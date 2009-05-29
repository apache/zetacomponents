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
class ezcDocumentPdfTests extends ezcDocumentPdfTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderDefault()
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/paragraph.xml' );

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
        $docbook->loadFile( dirname( __FILE__ ) . '/files/pdf/paragraph.xml' );

        $pdfDoc = new ezcDocumentPdf( new ezcDocumentPdfOptions( array(
            'driver' => new ezcDocumentPdfSvgDriver(),
        ) ) );
        $pdfDoc->loadStyles( dirname( __FILE__ ) . '/files/pdf/custom.css' );
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
