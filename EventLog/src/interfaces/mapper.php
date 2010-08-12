<?php
/**
 * File containing the ezcLogMapper interface.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The ezcLogMapper provides a public interface to implement a mapper.
 *
 * The ezcLogMapper interface has one method that must be implemented.
 * This method returns a writer (or in some cases a string) that matches the
 * incoming message.
 *
 * An implementation of ezcLogMapper is the {@link ezcLogFilterSet}.
 *
 * @package EventLog
 * @version //autogentag//
 */
interface ezcLogMapper
{
    /**
     * Returns the containers (results) that are mapped to this $severity, $source, and $category.
     *
     * @param int $severity
     * @param string $source
     * @param string $category
     * @return mixed|ezcLogWriter
     */
    public function get( $severity, $source, $category );
}
?>
