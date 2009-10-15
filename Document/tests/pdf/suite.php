<?php
/**
 * File containing the ezcDocument test suite
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * 
 * A base class for document type handlers.
 *
 */

/**
* Required test suites.
*/
require 'driver_haru_tests.php';
require 'driver_tcpdf_tests.php';
require 'driver_svg_tests.php';
require 'driver_transactions_tests.php';
require 'hyphenator_tests.php';
require 'tokenizer_tests.php';
require 'location_id_tests.php';
require 'match_location_id_tests.php';
require 'measure_tests.php';
require 'image_handler.php';
require 'page_tests.php';
require 'pcss_parser_tests.php';
require 'renderer_paragraph_tests.php';
require 'renderer_text_box_tests.php';
require 'renderer_literallayout_tests.php';
require 'renderer_variablelist_tests.php';
require 'renderer_list_tests.php';
require 'renderer_blockquote_tests.php';
require 'renderer_rtl_tests.php';
require 'render_text_decorations_tests.php';
require 'renderer_main_tests.php';
require 'renderer_footer_part_tests.php';
require 'style_inference_tests.php';
require 'value_parser_tests.php';
require 'renderer_mediaobject_tests.php';
require 'tests.php';

class ezcDocumentPdfSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        return new ezcDocumentPdfSuite( __CLASS__ );
    }

    public function __construct()
    {
        parent::__construct();
        $this->setName( "Document PDF tests" );

        $this->addTest( ezcDocumentPdfDriverHaruTests::suite() );
        $this->addTest( ezcDocumentPdfDriverTcpdfTests::suite() );
        $this->addTest( ezcDocumentPdfDriverSvgTests::suite() );
        $this->addTest( ezcDocumentPdfTransactionalDriverWrapperTests::suite() );
        $this->addTest( ezcDocumentPdfHyphenatorTests::suite() );
        $this->addTest( ezcDocumentPdfTokenizerTests::suite() );
        $this->addTest( ezcDocumentPdfLocationIdTests::suite() );
        $this->addTest( ezcDocumentPdfMatchLocationIdTests::suite() );
        $this->addTest( ezcDocumentPdfMeasureTests::suite() );
        $this->addTest( ezcDocumentPdfImageHandlerTests::suite() );
        $this->addTest( ezcDocumentPdfPageTests::suite() );
        $this->addTest( ezcDocumentPcssParserTests::suite() );
        $this->addTest( ezcDocumentPdfParagraphRendererTests::suite() );
        $this->addTest( ezcDocumentPdfTextBoxRendererTests::suite() );
        $this->addTest( ezcDocumentPdfLiterallayoutRendererTests::suite() );
        $this->addTest( ezcDocumentPdfVariableListRendererTests::suite() );
        $this->addTest( ezcDocumentPdfListRendererTests::suite() );
        $this->addTest( ezcDocumentPdfBlockquoteRendererTests::suite() );
        $this->addTest( ezcDocumentPdfRenderRtlTests::suite() );
        $this->addTest( ezcDocumentPdfRendererTextDecorationsTests::suite() );
        $this->addTest( ezcDocumentPdfMainRendererTests::suite() );
        $this->addTest( ezcDocumentPdfRendererFooterPartTests::suite() );
        $this->addTest( ezcDocumentPdfStyleInferenceTests::suite() );
        $this->addTest( ezcDocumentPdfValueParserTests::suite() );
        $this->addTest( ezcDocumentPdfMediaObjectRendererTests::suite() );
        $this->addTest( ezcDocumentPdfTests::suite() );
    }
}

?>
