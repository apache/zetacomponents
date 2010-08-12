<?php
/**
 * File containing the ezcLogWriterException class.
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
 * @package EventLog
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The ezcLogWriterException will be thrown when an {@link ezcLogWriter} or
 * a subclass encounters an exceptional state.
 *
 * This exception is a container, containing any kind of exception.
 *
 * @apichange Remove the wrapping of exceptions.
 * @package EventLog
 * @version //autogen//
 */
class ezcLogWriterException extends ezcBaseException
{
    /**
     * The wrapped exception.
     *
     * @var Exception
     */
    public $exception;

    /**
     * Constructs a new ezcLogWriterException with the original exception $e.
     *
     * @param Exception $e
     */
    public function __construct( Exception $e )
    {
        $this->exception = $e;
        parent::__construct( $e->getMessage() );
    }
}
?>
