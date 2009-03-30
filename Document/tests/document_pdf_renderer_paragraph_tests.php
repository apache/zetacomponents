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
            $this->equalTo( 42, 1. ),
            $this->equalTo( 23, 1. ),
            $this->equalTo( 'SomeWord' )
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
