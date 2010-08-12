<?php
/**
 * Autoloader definition for the Execution component.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Execution
 */

return array(
    'ezcExecutionException'                   => 'Execution/exceptions/exception.php',
    'ezcExecutionAlreadyInitializedException' => 'Execution/exceptions/already_initialized.php',
    'ezcExecutionInvalidCallbackException'    => 'Execution/exceptions/invalid_callback.php',
    'ezcExecutionNotInitializedException'     => 'Execution/exceptions/not_initialized.php',
    'ezcExecutionWrongClassException'         => 'Execution/exceptions/wrong_class.php',
    'ezcExecutionErrorHandler'                => 'Execution/interfaces/execution_handler.php',
    'ezcExecution'                            => 'Execution/execution.php',
    'ezcExecutionBasicErrorHandler'           => 'Execution/handlers/basic_handler.php',
);
?>
