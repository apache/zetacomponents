<?php
/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'listener_test.php';

/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 */
class ezcWorkflowEventLogTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'WorkflowEventLogTiein' );

        $this->addTest( ezcWorkflowEventLogTieinListenerTest::suite() );
    }

    public static function suite()
    {
        return new ezcWorkflowEventLogTieinSuite;
    }
}
?>
