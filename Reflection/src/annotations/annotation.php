<?php
/**
 * File containing the ezcReflectionAnnotation class.
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
 * Represents a annotation in the php source code comment.
 *
 * This class is used as standard implementation for representing
 * annotations. It is only used if no specialized annotation class could be
 * found deriving from this class.
 *
 * The comment line is tokenized by at spaces and if no further structure is recognized,
 * tokens are available at getParams.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotation {
    /**
    * @var string
    */
    protected $annotationName;

    /**
    * @var string[]
    */
    protected $params;

    /**
    * @var string
    */
    protected $desc;


    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->annotationName = $line[0];

        if (count($line) == 4) {
            $this->params[] = $line[1];
            $this->params[] = $line[2];
            $this->desc = $line[3];
        }
        elseif (count($line) == 3) {
            $this->params[] = $line[1];
            $this->desc = $line[2];
        }
        elseif (count($line) == 2) {
            $this->params[] = $line[1];
        }
        else {
            $this->params = $line;
        }
    }

    /**
    * @return string
    */
    public function getDescription() {
        return $this->desc;
    }

    /**
    * @param string $line
    */
    public function addDescriptionLine($line) {
        $this->desc .= "\n".$line;
    }

    /**
    * @return string
    */
    public function getName() {
        return $this->annotationName;
    }

    /**
    * @return string[]
    */
    public function getParams() {
        return $this->params;
    }
}
?>
