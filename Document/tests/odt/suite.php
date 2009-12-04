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
require_once 'formatting_properties.php';
require_once 'formatting_property_collection.php';
require_once 'paragraph_property_generator_test.php';
require_once 'text_property_generator_test.php';
require_once 'style.php';
require_once 'style_converters.php';
require_once 'text_processor_test.php';
require_once 'list_level_style_test.php';
require_once 'style_parser_test.php';
require_once 'style_extractor_test.php';
require_once 'meta_generator_test.php';

/**
 * This file is not in use, yet, therefore not tested.
 */
PHPUnit_Util_Filter::addFileToFilter(
    dirname( __FILE__ ) . '/../../src/document/xml/odt/filter/element/html_table.php'
);

class ezcDocumentOdtSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        return new ezcDocumentOdtSuite();
    }

    public function __construct()
    {
        parent::__construct();
        $this->setName( "Document ODT tests" );

        $this->addTest( ezcDocumentOdtFormattingPropertiesTest::suite() );
        $this->addTest( ezcDocumentOdtFormattingPropertyCollectionTest::suite() );
        $this->addTest( ezcDocumentOdtStyleParagraphPropertyGeneratorTest::suite() );
        $this->addTest( ezcDocumentOdtStyleTextPropertyGeneratorTest::suite() );
        $this->addTest( ezcDocumentOdtStyleTest::suite() );
        $this->addTest( ezcDocumentOdtPcssConvertersTest::suite() );
        $this->addTest( ezcDocumentOdtTextProcessorTest::suite() );
        $this->addTest( ezcDocumentOdtListLevelStyleTest::suite() );
        $this->addTest( ezcDocumentOdtStyleParserTest::suite() );
        $this->addTest( ezcDocumentOdtStyleExtractorTest::suite() );
        $this->addTest( ezcDocumentOdtMetaGeneratorTest::suite() );
    }
}

?>
