<?php
/**
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once 'file_exception_test.php';
require_once 'variable_collection_test.php';
require_once 'validation_item_test.php';
require_once 'output_context_test.php';
require_once 'xhtml_context_test.php';
require_once 'cursor_test.php';
require_once 'whitespace_removal_test.php';
require_once 'text_block_element_test.php';
require_once 'operator_test.php';
require_once 'code_elements_test.php';
require_once 'source_code_test.php';
require_once 'compiled_code_test.php';
require_once 'configuration_test.php';
require_once 'template_test.php';
require_once 'cache_test.php';
require_once 'regression_test.php';
require_once 'cache_test.php';
require_once 'cache_manager_test.php';
require_once 'locale_test.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Template' );

        $this->addTest( ezcTemplateRegressionTest::suite() );
        $this->addTest( ezcTemplateFileExceptionTest::suite() );
        $this->addTest( ezcTemplateVariableCollectionTest::suite() );
        $this->addTest( ezcTemplateValidationItemTest::suite() );
        $this->addTest( ezcTemplateOutputContextTest::suite() );
        $this->addTest( ezcTemplateXhtmlContextTest::suite() );
        $this->addTest( ezcTemplateCursorTest::suite() );
        $this->addTest( ezcTemplateWhitespaceRemovalTest::suite() );
        $this->addTest( ezcTemplateTextBlockElementTest::suite() );
        $this->addTest( ezcTemplateOperatorTest::suite() );
        $this->addTest( ezcTemplateCodeElementsTest::suite() );
        $this->addTest( ezcTemplateSourceCodeTest::suite() );
        $this->addTest( ezcTemplateCompiledCodeTest::suite() );
        $this->addTest( ezcTemplateConfigurationTest::suite() );
        $this->addTest( ezcTemplateCacheTest::suite() );
        $this->addTest( ezcTemplateCacheManagerTest::suite() );
        $this->addTest( ezcTemplateTest::suite() );
        $this->addTest( ezcTemplateLocaleTest::suite() );
    }

    public static function suite()
    {
        return new ezcTemplateSuite();
    }
}
?>
