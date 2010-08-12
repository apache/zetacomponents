<?php
/**
 * File containing the ezcSystemInfoAccelerator structure.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * A container to store information about a PHP accelerator.
 *
 * This structure used to represent information about a PHP accelerator parameters
 * {@link self::name name}
 * {@link self::url url}
 * {@link self::isEnabled isEnabled}
 * {@link self::versionInt versionInt}
 * {@link self::versionString versionString}
 *
 * @see ezcSystemInfo
 *
 * @package SystemInformation
 * @version //autogentag//
 */
class ezcSystemInfoAccelerator extends ezcBaseStruct
{
    /**
     * Name of PHP accelerator.
     *
     * @var string
     */
    public $name;

    /**
     * URL of the site of PHP accelerator developer.
     *
     * @var string
     */
    public $url;

    /**
     * Flag that informs if PHP accelerator enabled or not.
     *
     * @var bool
     */
    public $isEnabled;

    /**
     * PHP accelerator version number.
     *
     * @var int
     */
    public $versionInt;

    /**
     * PHP accelerator version number as a string.
     *
     * @var string
     */
    public $versionString;

    /**
     * Initialize all structure fields with values.
     *
     * @param string $name
     * @param string $url
     * @param bool   $isEnabled
     * @param int    $versionInt
     * @param string $versionString
     */
    public function __construct( $name, $url, $isEnabled, $versionInt, $versionString )
    {
        $this->name = $name;
        $this->url  = $url;
        $this->isEnabled     = $isEnabled;
        $this->versionInt    = $versionInt;
        $this->versionString = $versionString;
    }
}
?>
