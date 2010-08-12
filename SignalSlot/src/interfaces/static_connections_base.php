<?php
/**
 * File containing the ezcSignalStaticConnectionsBase interface
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
 * @package SignalSlot
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Interface for classes that implement a mail transport.
 *
 * Subclasses must implement the send() method.
 *
 * @package SignalSlot
 * @version //autogen//
 */
interface ezcSignalStaticConnectionsBase
{
    /**
     * Returns all the connections for signals $signal in signal collections
     * with the identifier $identifier.
     *
     * The format of the returned array is (priority=>array(phpCallbacks))
     *
     * The callback type is explained in the PHP manual (http://php.net/callback).
     *
     * The returned array MUST be sorted on priority.
     *
     * @param string $identifier
     * @param string $signal
     * @return array(int=>array(callback))
     */
    public function getConnections( $identifier, $signal );

}
?>
