<?php
/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'WorkflowDatabaseTiein/tests/case.php';

/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 */
abstract class ezcWorkflowEventLogTieinTestCase extends ezcWorkflowDatabaseTieinTestCase
{
    protected $log;

    protected function setUp()
    {
        parent::setUp();

        $writer = new ezcLogUnixFileWriter(
          dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data', 'actual.log'
        );

        $this->log = ezcLog::getInstance();
        $mapper = $this->log->getMapper();
        $filter = new ezcLogFilter;
        $rule = new ezcLogFilterRule( $filter, $writer, true );
        $mapper->appendRule( $rule );

        $this->setUpExecution();
    }

    protected function tearDown()
    {
        parent::tearDown();

        @unlink( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'actual.log' );
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

    protected function setUpExecution( $id = null )
    {
        $this->execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $this->execution->addListener( new ezcWorkflowEventLogListener( $this->log ) );
    }

    protected function readActual()
    {
        $actual = file( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'actual.log' );

        return $this->cleanupTimestamps( $actual );
    }

    protected function readExpected( $name )
    {
        $expected = file( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $name . '.log' );

        return $this->cleanupTimestamps( $expected );
    }
}
?>
