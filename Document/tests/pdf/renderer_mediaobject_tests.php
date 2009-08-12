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
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/image.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testRenderInMultipleColumns()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/image.xml',
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

    public function testRenderLargeImage()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/image_large.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
            )
        );
    }

    public function testRenderHighImage()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/image_high.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
            )
        );
    }

    public function testRenderWrappedLargeImageAndWrappedText()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/image_wrapped.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
            )
        );
    }
}

?>
