<?php
/**
 * File containing the ezcLogFilter class.
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
 * The ezcLogFilter class provides a structure to set a log filter.
 *
 * ezcLogFilter has three public member variables:
 * - severity, contains the severity of the log message.
 * - source, contain the source of the log message.
 * - category, contains the category of the log message.
 *
 * Severity is an integer mask that expects one more multiple ezcLog severity constants.
 * Multiple values can be assigned by using a logical-or on the values. The value zero
 * represents all possible severities.
 *
 * Source and category are an array. An empty array reprseents all possible sources
 * and categories.
 *
 * The ezclogFilter class is mainly used by the {@link ezcLog::attach()} and {@link ezcLog::detach()}
 * methods.
 *
 * @package EventLog
 * @version //autogentag//
 * @mainclass
 */
class ezcLogFilter extends ezcBaseStruct
{
   /**
    * The severities that are accepted by the ezcLogFilter.
    *
    * The default value zero specifies that all severities are accepted.
    *
    * @var int
    */
   public $severity;

   /**
    * The source of the log message.
    *
    * The default empty array specifies that all sources are accepted by this filter.
    *
    * @var array(string)
    */
   public $source;

   /**
    * The category of the log message.
    *
    * The default empty array specifies that all categories are accepted by this filter.
    *
    * @var array(string)
    */
   public $category;

   /**
    * Empty constructor
    *
    * @param int $severity
    * @param array(string) $source
    * @param array(string) $category
    */
   public function __construct( $severity = 0, array $source = array(), array $category = array() )
   {
       $this->severity = $severity;
       $this->source = $source;
       $this->category = $category;
   }
}
?>
