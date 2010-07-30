<?php
/**
 * File containing the ezcReflectionAnnotationFactory class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Creates a ezcReflectionAnnotation object be the given annotation
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotationFactory
{

	/**
	 * Don't allow objects, it is just a static factory
	 */
    // @codeCoverageIgnoreStart
    private function __construct() {}
    // @codeCoverageIgnoreEnd

    /**
     * @param string $type
     * @param string[] $line array of words
     * @return ezcReflectionAnnotation
     */
    static public function createAnnotation($type, $line) {
        $annotationClassName = 'ezcReflectionAnnotation' . ucfirst($type);
        $annotation = null;
        if (!empty($type) and class_exists($annotationClassName)) {
            $annotation = new $annotationClassName($line);
        }
        else {
            $annotation = new ezcReflectionAnnotation($line);
        }
        return $annotation;
    }
}
?>
