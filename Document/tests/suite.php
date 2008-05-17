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

require_once 'document_options_xml_base_test.php';
require_once 'document_xml_base_test.php';
require_once 'document_rst_tokenizer_tests.php';
require_once 'document_rst_parser_tests.php';
require_once 'document_rst_visitor_docbook_tests.php';
require_once 'document_rst_visitor_xhtml_tests.php';

require_once 'converter_options_ezp3_ezp4_test.php';
require_once 'converter_ezp3_ezp4_test.php';
require_once 'converter_xhtml_docbook_test.php';


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

        $this->addTest( ezcDocumentOptionsXmlBaseTests::suite() );
        $this->addTest( ezcDocumentXmlBaseTests::suite() );
        $this->addTest( ezcDocumentRstTokenizerTests::suite() );
        $this->addTest( ezcDocumentRstParserTests::suite() );
        $this->addTest( ezcDocumentRstDocbookVisitorTests::suite() );
        $this->addTest( ezcDocumentRstXhtmlVisitorTests::suite() );

        $this->addTest( ezcDocumentConverterOptionsEzp3ToEzp4Tests::suite() );
        $this->addTest( ezcDocumentConverterEzp3ToEzp4Tests::suite() );
        $this->addTest( ezcDocumentConverterXhtmlToDocbookTests::suite() );
    }
}

?>
