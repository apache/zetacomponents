<?php
/**
 * File containing the ezcImageConverterSettings struct.
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
 * @package ImageConversion
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Struct to store the settings for objects of ezcImageConverter.
 *
 * This class is used as a struct for the settings of ezcImageConverter.
 *
 * @see ezcImageConverter
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConverterSettings extends ezcBaseStruct
{
    /**
     * Array with {@link ezcImageHandlerSettings handler settings} objects.
     * Each settings objects is consulted by the converter to figure out which
     * {@link ezcImageHandler image handlers} to use.
     *
     * @see ezcImageHandler
     * @see ezcImageGdHandler
     * @see ezcImageImagemagickHandler
     *
     * @var array(ezcImageHandlerSettings)
     */
    public $handlers = array();

    /**
     * Map of automatic MIME type conversions. The converter will automatically
     * perform the defined conversions when a transformation is applied through
     * it and the specific MIME type is recognized.
     *
     * The conversion map has the following structure:
     * <code>
     * array(
     *     'image/gif' => 'image/png',  // Note: lower case!
     *     'image/bmp' => 'image/jpeg',
     * )
     * </code>
     *
     * @var array
     */
    public $conversions = array();

    /**
     * Create a new instance of ezcImageConverterSettings.
     * Create a new instance of ezcImageConverterSettings to be used with
     * {@link ezcImageConverter} objects..
     *
     * @see ezcImageConverterSettings::$handlers
     * @see ezcImageConverterSettings::$conversions
     *
     * @param array $handlers    Array of {@link ezcImageHandlerSettings handler objects}.
     * @param array $conversions Map of standard MIME type conversions.
     */
    public function __construct( array $handlers = array(), array $conversions = array() )
    {
        $this->handlers    = $handlers;
        $this->conversions = $conversions;
    }
}
?>
