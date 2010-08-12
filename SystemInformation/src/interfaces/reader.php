<?php
/**
 * File containing the ezcSystemInfoReader class
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
 * @package SystemInformation
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The ezcSystemInfoReader represents common interface of OS info reader.
 *
 * @package SystemInformation
 * @version //autogentag//
 */
abstract class ezcSystemInfoReader
{
    /**
     * Returns true if the property $propertyName holds a valid value and false otherwise.
     *
     * @param string $propertyName
     * @return bool
     */
    abstract public function isValid( $propertyName );

    /**
     * Returns number of CPUs in system.
     *
     * @return int the number of CPUs in system or null if number of CPUs is unknown.
     */
    abstract public function getCpuCount();

    /**
     * Returns string with CPU type.
     *
     * @return string the CPU type or null if the CPU type is unknown.
     */
    abstract public function cpuType();

    /**
     * Returns CPU speed
     *
     * If the CPU speed could not be read null is returned.
     * Average processor speed returned for multiprocessor systems.
     *
     * @return float the CPU speed or null if the CPU speed is unknown.
     */
    abstract public function cpuSpeed();

    /**
     * Returns memory size in bytes.
     *
     * If the memory size could not be read null is returned.
     *
     * @return int the memory size in bytes or null
     */
    abstract public function memorySize();
}
?>
