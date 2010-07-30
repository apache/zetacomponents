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
 * @package Execution
 */

/**
 * Simple implementation of a callback handler to use with ezcExecution.
 *
 * This is a very simple callback handler which only issues a simple message.
 * Of course in applications you will need to either extend this class, or just
 * implement the ezcExecutionErrorHandler interface.
 *
 * @package Execution
 * @version //autogentag//
 */
class ezcExecutionBasicErrorHandler implements ezcExecutionErrorHandler
{
    /**
     * Processes an error situation
     *
     * This method is called by the ezcExecution environment whenever an error
     * situation (uncaught exception or fatal error) happens.  It accepts one
     * default parameter in case there was an uncaught exception.
     *
     * This class just serves as an example, for your own application you
     * should write your own class that implements the ezcExecutionErrorHandler
     * interface and use that as parameter to {@link ezcExecution::init()}
     *
     * @param Exception $e
     *
     * @return void
     */
    static public function onError( Exception $e = null )
    {
        echo <<<END
This application stopped in an unclean way. Please contact the site
administrator to report the error.

Have a nice day!

END;
    }
}
?>
