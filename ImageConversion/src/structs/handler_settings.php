<?php
/**
 * File containing the ezcImageHandlerSettings struct.
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
 * Struct to store the settings for objects of ezcImageHandler.
 *
 * This class is used as a struct for the settings of ezcImageHandler
 * subclasses.
 *
 * @see ezcImageHandler
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageHandlerSettings extends ezcBaseStruct
{
    /**
     * The reference name for the handler.
     * This name can be used when referencing the handler in certain operations
     * in the {@link ezcImageConverter converter} class.
     *
     * e.g. 'GD' and 'ImageMagick'.
     *
     * @var string
     */
    public $referenceName;

    /**
     * Name of the class to instantiate as image handler.
     *
     * Note: This class must be a subclass of the {@link ezcImageHandler} class.
     *
     * @var string
     */
    public $className;

    /**
     * Associative array of misc options for the handler.
     * These options will be read by the handler class and varies from handler
     * to handler. Consult the handler class for the available settings.
     *
     * The options array has the following structure:
     * <code>
     * array(
     *     <optionName> => <optionValue>,
     *     [ <optionName> => <optionValue>, ...]
     * )
     * </code>
     *
     * @var array
     */
    public $options = array();

    /**
     * Initialize settings to be used by image handler.
     * The settings passed as parameter will be read by the
     * {@link ezcImageConverter converter} to figure out which image handler to
     * use and then passed to the {@link ezcImageHandler image handler objects}.
     *
     * @see ezcImageHandlerSettings::$referenceName
     * @see ezcImageHandlerSettings::$className
     * @see ezcImageHandlerSettings::$settings
     *
     * @param string $referenceName
     *        The reference name for the handler, e.g. 'GD' or 'ImageMagick'
     * @param string $className
     *        The name of the handler class to instantiate, e.g.
     *        'ezcImageGdHandler' or 'ezcImageImagemagickHandler'
     * @param array  $options
     *        Associative array of settings for the handler.
     */
    public function __construct( $referenceName, $className, array $options = array() )
    {
        $this->referenceName = $referenceName;
        $this->className     = $className;
        $this->options       = $options;
    }
}
?>
