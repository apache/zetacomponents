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
        $this->addTest( ezcDocumentOdtStyleConvertersTest::suite() );
    }
}

?>
