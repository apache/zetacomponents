<?php
/**
 * File containing the ezcMvcResultStatusObject class
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
 * @package MvcTools
 */

/**
 * The interface that should be implemented by all special status objects.
 *
 * Statis objects are used to specify non-normal results from actions.
 * As an example that could be a "Authorization Required" status, an external
 * redirect etc.
 *
 *
 * @package MvcTools
 * @version //autogentag//
 */
interface ezcMvcResultStatusObject
{
    /**
     * This method is called by the response writers to process the data
     * contained in the status objects.
     *
     * The process method it responsible for undertaking the proper action
     * depending on which response writer is used.
     *
     * @param ezcMvcResponseWriter $writer
     */
    public function process( ezcMvcResponseWriter $writer );
}
?>
