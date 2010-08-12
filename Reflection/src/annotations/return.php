<?php
/**
 * File containing the ezcReflectionAnnotationReturn class.
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
 * @package Reflection
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Represents a return annotation in the php source code comment.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotationReturn extends ezcReflectionAnnotation {

	/**
    * @param string[] $line array of words
    */
    public function __construct($line) {
        $this->annotationName = $line[0];

        if (isset($line[1])) {
            $this->params[0] = ezcReflectionTypeMapper::getInstance()->getTypeName($line[1]);
        }
        if (isset($line[2])) {
            $this->desc = $line[2];
        }
        if (isset($line[3])) {
            $this->desc .= ' '.$line[3];
        }
    }

    /**
    * @return string
    */
    public function getTypeName() {
        return $this->params[0];
    }
}
?>
