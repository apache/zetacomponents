<?php
/**
 * File containing the ezcTemplateAutoloaderDefinition class
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
 * @package Template
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * Contains the definition of an autoloader.
 *
 * It defines the minimum data required for locating and initialising a template
 * autoloader and is used by the template engine to reduce the memory usage when
 * templates does not need compilation.
 *
 * The definition will be turned into a class which implements the
 * ezcTemplateTemplateAutoloader class.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAutoloaderDefinition extends ezcBaseStruct
{
    /**
     * The path to the PHP file which contains the autoloader class.
     */
    public $path;

    /**
     * The name of the class contained in $path which implements the
     * ezcTemplateAutoloader base class.
     */
    public $className;

    /**
     * Initialises the definition with the path and class name.
     *
     * @param string $path The file path to the loader which is set as $this->path.
     * @param string $className The class name of the loader which is set as
     *                          $this->className.
     */
    public function __construct( $path, $className )
    {
    }

}
?>
