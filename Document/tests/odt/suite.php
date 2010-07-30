<?php
/**
 * File containing the ezcDocument test suite
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
