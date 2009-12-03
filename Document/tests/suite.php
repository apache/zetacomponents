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
require 'document_test.php';
require 'converter_test.php';
require 'parser_test.php';

require 'document_options_xml_base_test.php';
require 'document_xml_base_test.php';

require 'document_docbook_test.php';

require 'document_rst_tokenizer_tests.php';
require 'document_rst_parser_tests.php';
require 'document_rst_visitor_docbook_tests.php';
require 'document_rst_visitor_xhtml_tests.php';
require 'document_rst_visitor_xhtml_body_tests.php';
require 'document_rst_validation_tests.php';

require 'document_wiki_creole_tokenizer_tests.php';
require 'document_wiki_dokuwiki_tokenizer_tests.php';
require 'document_wiki_confluence_tokenizer_tests.php';
require 'document_wiki_parser_tests.php';
require 'document_wiki_visitor_docbook_tests.php';
require 'document_wiki_tests.php';

require 'document_xhtml_docbook_tests.php';
require 'document_xhtml_validation_tests.php';

require 'document_odt_docbook_tests.php';
require 'document_options_odt_test.php';

require 'document_ezxml_tests.php';

require 'pcss/location_id_tests.php';
require 'pcss/match_location_id_tests.php';
require 'pcss/measure_tests.php';
require 'pcss/parser_test.php';
require 'pcss/style_inference_tests.php';
require 'pcss/value_parser_tests.php';

require_once 'list_bullet_guesser_test.php';

require 'pdf/suite.php';

require 'odt/suite.php';

require 'converter_docbook_html_test.php';
require 'converter_docbook_html_xsl_test.php';
require 'converter_docbook_rst_test.php';
require 'converter_docbook_wiki_test.php';
require 'converter_docbook_ezxml_test.php';
require 'converter_docbook_odt_test.php';

require 'converter_options_docbook_ezxml_tests.php';
require 'converter_options_ezxml_docbook_tests.php';
require 'converter_options_odt_tests.php';
require 'converter_options_rst_tests.php';
require 'converter_options_tests.php';
require 'converter_options_wiki_tests.php';
require 'converter_options_xslt_tests.php';
require 'document_docbook_options_tests.php';
require 'document_ezxml_options_tests.php';
require 'document_options_tests.php';
require 'document_pdf_footer_options_tests.php';
require 'document_pdf_options_tests.php';
require 'document_rst_options_tests.php';
require 'document_wiki_options_tests.php';
require 'document_xhtml_options_tests.php';


class ezcDocumentSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        return new ezcDocumentSuite( __CLASS__ );
    }

    public function __construct()
    {
        parent::__construct();
        $this->setName( "Document" );

        $this->addTest( ezcDocumentDocumentTests::suite() );
        $this->addTest( ezcDocumentParserTests::suite() );
        $this->addTest( ezcDocumentConverterTests::suite() );

        $this->addTest( ezcDocumentOptionsXmlBaseTests::suite() );
        $this->addTest( ezcDocumentXmlBaseTests::suite() );

        $this->addTest( ezcDocumentDocbookTests::suite() );

        $this->addTest( ezcDocumentRstTokenizerTests::suite() );
        $this->addTest( ezcDocumentRstParserTests::suite() );
        $this->addTest( ezcDocumentRstDocbookVisitorTests::suite() );
        $this->addTest( ezcDocumentRstXhtmlVisitorTests::suite() );
        $this->addTest( ezcDocumentRstXhtmlBodyVisitorTests::suite() );
        $this->addTest( ezcDocumentRstValidationTests::suite() );

        $this->addTest( ezcDocumentWikiCreoleTokenizerTests::suite() );
        $this->addTest( ezcDocumentWikiDokuwikiTokenizerTests::suite() );
        $this->addTest( ezcDocumentWikiConfluenceTokenizerTests::suite() );
        $this->addTest( ezcDocumentWikiParserTests::suite() );
        $this->addTest( ezcDocumentWikiDocbookVisitorTests::suite() );
        $this->addTest( ezcDocumentWikiTests::suite() );

        $this->addTest( ezcDocumentXhtmlDocbookTests::suite() );
        $this->addTest( ezcDocumentXhtmlValidationTests::suite() );

        $this->addTest( ezcDocumentOptionsOdtTests::suite() );
        $this->addTest( ezcDocumentOdtDocbookTests::suite() );

        $this->addTest( ezcDocumentEzXmlTests::suite() );

        $this->addTest( ezcDocumentPcssLocationIdTests::suite() );
        $this->addTest( ezcDocumentPcssMatchLocationIdTests::suite() );
        $this->addTest( ezcDocumentPcssMeasureTests::suite() );
        $this->addTest( ezcDocumentPcssParserTests::suite() );
        $this->addTest( ezcDocumentPcssValueParserTests::suite() );
        $this->addTest( ezcDocumentPcssStyleInferenceTests::suite() );

        $this->addTest( ezcDocumentListBulletGuesserTest::suite() );

        $this->addTest( ezcDocumentPdfSuite::suite() );

        $this->addTest( ezcDocumentOdtSuite::suite() );

        $this->addTest( ezcDocumentConverterDocbookToHtmlTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToHtmlXsltTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToRstTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToWikiTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToEzXmlTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToOdtTests::suite() );

        $this->addTest( ezcConverterRstOptionsTests::suite() );
        $this->addTest( ezcDocumentWikiOptionsTests::suite() );
        $this->addTest( ezcDocumentRstOptionsTests::suite() );
        $this->addTest( ezcDocumentPdfOptionsTests::suite() );
        $this->addTest( ezcConverterOptionsTests::suite() );
        $this->addTest( ezcDocumentOptionsTests::suite() );
        $this->addTest( ezcConverterXsltOptionsTests::suite() );
        $this->addTest( ezcDocumentXhtmlOptionsTests::suite() );
        $this->addTest( ezcDocumentEzXmlOptionsTests::suite() );
        $this->addTest( ezcDocumentDocbookOptionsTests::suite() );
        $this->addTest( ezcDocumentPdfFooterOptionsTests::suite() );
        $this->addTest( ezcConverterDocbookEzXmlOptionsTests::suite() );
        $this->addTest( ezcConverterEzXmlDocbookOptionsTests::suite() );
        $this->addTest( ezcConverterWikiOptionsTests::suite() );
        $this->addTest( ezcConverterOdtOptionsTests::suite() );
    }
}

?>
