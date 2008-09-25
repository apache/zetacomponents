<?php
/**
 * File containing the ezcDocument test suite
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * 
 * A base class for document type handlers.
 *
 */

/**
* Required test suites.
*/
// require_once 'convert_ezp3_test.php';
// require_once 'convert_xhtml_test.php';

require 'document_test.php';
require 'converter_test.php';
require 'parser_test.php';

require 'document_options_xml_base_test.php';
require 'document_xml_base_test.php';
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

require 'document_xhtml_docbook_tests.php';
require 'document_xhtml_validation_tests.php';

require 'converter_options_ezp3_ezp4_test.php';
require 'converter_ezp3_ezp4_test.php';
require 'converter_docbook_html_test.php';
require 'converter_docbook_html_xsl_test.php';
require 'converter_docbook_rst_test.php';

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

        $this->addTest( ezcDocumentXhtmlDocbookTests::suite() );
        $this->addTest( ezcDocumentXhtmlValidationTests::suite() );

        $this->addTest( ezcDocumentConverterOptionsEzp3ToEzp4Tests::suite() );
        $this->addTest( ezcDocumentConverterEzp3ToEzp4Tests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToHtmlTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToHtmlXsltTests::suite() );
        $this->addTest( ezcDocumentConverterDocbookToRstTests::suite() );
    }
}

?>
