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
require 'driver_haru_tests.php';
require 'driver_tcpdf_tests.php';
require 'driver_svg_tests.php';
require 'driver_transactions_tests.php';
require 'hyphenator_tests.php';
require 'tokenizer_tests.php';
require 'literal_tokenizer_tests.php';
require 'image_handler.php';
require 'page_tests.php';
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
require 'renderer_mediaobject_tests.php';
require 'renderer_table_tests.php';
require 'table_column_width_tests.php';
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
        $this->addTest( ezcDocumentPdfLiteralTokenizerTests::suite() );
        $this->addTest( ezcDocumentPdfImageHandlerTests::suite() );
        $this->addTest( ezcDocumentPdfPageTests::suite() );
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
        $this->addTest( ezcDocumentPdfMediaObjectRendererTests::suite() );
        $this->addTest( ezcDocumentPdfTableColumnWidthCalculatorTests::suite() );
        $this->addTest( ezcDocumentPdfTableRendererTests::suite() );
        $this->addTest( ezcDocumentPdfTests::suite() );
    }
}

?>
