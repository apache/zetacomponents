<?php
/**
 * File containing the ezcPhpGeneratorFlowException class
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
 * @package PhpGenerator
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Flow exceptions are thrown when control structures like if and while are closed out of order.
 *
 * @package PhpGenerator
 * @version //autogen//
 */
class ezcPhpGeneratorFlowException extends ezcPhpGeneratorException
{
    /**
     * Constructs a new flow exception.
     *
     * $expectedFlow is the name of the control structure you expected the end of
     * and $calledFlow is the actual structure received.
     *
     * @param string $expectedFlow
     * @param string $calledFlow
     */
    function __construct( $expectedFlow, $calledFlow )
    {
        parent::__construct( "Expected end of '{$expectedFlow}' but got end of '{$calledFlow}'" );
    }
}

?>
