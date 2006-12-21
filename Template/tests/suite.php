<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
//require_once 'source_to_tst_parser_test.php';
require_once 'whitespace_removal_test.php';

require_once 'text_block_element_test.php';

require_once 'operator_test.php';

require_once 'code_elements_test.php';

require_once 'source_code_test.php';
require_once 'compiled_code_test.php';

require_once 'configuration_test.php';

require_once 'template_test.php';

require_once 'parser_test.php';

require_once 'cache_test.php';
require_once 'regression_test.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Template" );
        $this->addTest( ezcTemplateRegressionTest::suite() );

        // Caching is disabled. Check also parsers/source_to_tst/cache.php
        //$this->addTest( ezcTemplateCacheTest::suite() );

        $this->addTest( ezcTemplateParserTest::suite() );

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


        $this->addTest( ezcTemplateTest::suite() );

    }

    public static function suite()
    {
        return new ezcTemplateSuite();
    }
}

?>
