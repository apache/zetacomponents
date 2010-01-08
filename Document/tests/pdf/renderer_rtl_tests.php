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
class ezcDocumentPdfRenderRtlTests extends ezcDocumentPdfTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderAllRtl()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/long_text.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPcssLayoutDirective(
                    array( 'article' ),
                    array(
                        'direction' => 'rtl',
                    )
                ),
            )
        );
    }

    public function testRenderParagraphRtl()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/long_text.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPcssLayoutDirective(
                    array( 'para' ),
                    array(
                        'direction' => 'rtl',
                    )
                ),
            )
        );
    }

    public function testRenderTitleRtl()
    {
        $this->renderFullDocument(
            dirname( __FILE__ ) . '/../files/pdf/long_text.xml',
            __CLASS__ . '_' . __FUNCTION__ . '.svg',
            array(
                new ezcDocumentPcssLayoutDirective(
                    array( 'title' ),
                    array(
                        'direction' => 'rtl',
                    )
                ),
            )
        );
    }
}

?>
