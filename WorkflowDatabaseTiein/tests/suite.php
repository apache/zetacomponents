<?php
/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'definition_test.php';
require_once 'execution_test.php';
require_once 'options_test.php';

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
class ezcWorkflowDatabaseTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'WorkflowDatabaseTiein' );

        $this->addTest( ezcWorkflowDatabaseTieinDefinitionTest::suite() );
        $this->addTest( ezcWorkflowDatabaseTieinExecutionTest::suite() );
        $this->addTest( ezcWorkflowDatabaseTieinOptionsTest::suite() );
    }

    public static function suite()
    {
        return new ezcWorkflowDatabaseTieinSuite;
    }
}
?>
