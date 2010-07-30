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
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
