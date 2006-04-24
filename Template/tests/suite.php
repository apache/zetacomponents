<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once 'variable_exception_test.php';
require_once 'file_exception_test.php';

require_once 'variable_test.php';
require_once 'variable_collection_test.php';

require_once 'location_test.php';
require_once 'template_exception_test.php';

require_once 'validation_item_test.php';
require_once 'output_context_test.php';
require_once 'xhtml_context_test.php';

require_once 'cursor_test.php';
//require_once 'source_to_tst_parser_test.php';
require_once 'whitespace_removal_test.php';

require_once 'text_block_element_test.php';

require_once 'operator_test.php';

require_once 'code_elements_test.php';

require_once 'source_code_test.php';
require_once 'compiled_code_test.php';

require_once 'resource_locator_test.php';
require_once 'direct_resource_locator_test.php';

require_once 'configuration_test.php';

require_once 'manager_test.php';

require_once 'parser_test.php';

require_once 'regression_test.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Template" );
        $this->addTest( ezcTemplateRegressionTest::suite() );

        $this->addTest( ezcTemplateParserTest::suite() );

        $this->addTest( ezcTemplateVariableExceptionTest::suite() );
        $this->addTest( ezcTemplateFileExceptionTest::suite() );

        $this->addTest( ezcTemplateVariableTest::suite() );
        //$this->addTest( ezcTemplateVariableCollectionTest::suite() );

        $this->addTest( ezcTemplateLocationTest::suite() );
        $this->addTest( ezcTemplateExceptionTest::suite() );

        $this->addTest( ezcTemplateValidationItemTest::suite() );

        $this->addTest( ezcTemplateOutputContextTest::suite() );
        $this->addTest( ezcTemplateXhtmlContextTest::suite() );

        $this->addTest( ezcTemplateCursorTest::suite() );
 //       $this->addTest( ezcTemplateSourceToTstParserTest::suite() );
        $this->addTest( ezcTemplateWhitespaceRemovalTest::suite() );

        $this->addTest( ezcTemplateTextBlockElementTest::suite() );

        $this->addTest( ezcTemplateOperatorTest::suite() );

        $this->addTest( ezcTemplateCodeElementsTest::suite() );

        $this->addTest( ezcTemplateSourceCodeTest::suite() );
        $this->addTest( ezcTemplateCompiledCodeTest::suite() );

        $this->addTest( ezcTemplateResourceLocatorTest::suite() );
        $this->addTest( ezcTemplateDirectResourceLocatorTest::suite() );

        $this->addTest( ezcTemplateConfigurationTest::suite() );

        $this->addTest( ezcTemplateManagerTest::suite() );

    }

    public static function suite()
    {
        return new ezcTemplateSuite();
    }
}

?>
