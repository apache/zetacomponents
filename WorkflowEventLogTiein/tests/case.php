<?php
/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

require_once 'WorkflowDatabaseTiein/tests/case.php';
require_once 'WorkflowDatabaseTiein/tests/execution.php';

/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 */
abstract class WorkflowEventLogTieinTestCase extends ezcWorkflowDatabaseTieinTestCase
{
    protected $log;

    protected function setUp()
    {
        parent::setUp();

        $writer = new ezcLogUnixFileWriter(
          dirname( __FILE__ ) . '/data', 'actual.log' 
        );

        $this->log = ezcLog::getInstance();
        $mapper = $this->log->getMapper();
        $filter = new ezcLogFilter;
        $rule = new ezcLogFilterRule( $filter, $writer, true );
        $mapper->appendRule( $rule ); 

        $this->execution = new WorkflowDatabaseTestExecution( $this->db );
        $this->execution->addListener( new ezcWorkflowEventLogListener( $this->log ) );
    }

    protected function tearDown()
    {
        parent::tearDown();

        @unlink( dirname( __FILE__ ) . '/data/actual.log' );
    }

    protected function readActual()
    {
        $actual = file( dirname( __FILE__ ) . '/data/actual.log' );

        return $this->cleanupTimestamps( $actual );
    }

    protected function readExpected( $name )
    {
        $expected = file( dirname( __FILE__ ) . '/data/' . $name . '.log' );

        return $this->cleanupTimestamps( $expected );
    }

    protected function cleanupTimestamps( Array $buffer )
    {
        $max = count( $buffer );

        for ( $i = 0; $i < $max; $i++ )
        {
            $buffer[$i] = substr_replace( $buffer[$i], 'MMM DD HH:MM:SS', 0, 15 );
        }

        return implode( '', $buffer );
    }
}
?>
