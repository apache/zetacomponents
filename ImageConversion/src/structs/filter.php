<?php
/**
 * File containing the ezcImageFilter struct.
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
 * Struct to store information about a filter operation.
 *
 * The struct contains the {@link self::name name} of the filter to use and
 * which {@link self::options options} to use for it.
 *
 * Possible filter names are determined by the methods defined in the following
 * filter interfaces:
 *
 * <ul>
 *  <li>{@link ezcImageGeometryFilters}</li>
 *  <li>{@link ezcImageColorspaceFilters}</li>
 *  <li>{@link ezcImageEffectFilters}</li>
 *  <li>{@link ezcImageWatermarkFilters}</li>
 *  <li>{@link ezcImageThumbnailFilters}</li>
 * </ul>
 *
 * The options for each filter are represented by the parameters received by
 * their corresponding method. You can determine if a certain {@link
 * ezcImageHandler} implementation supports a filter by checking the interfaces
 * this handler implements.
 *
 * @see ezcImageTransformation
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageFilter extends ezcBaseStruct
{
    /**
     * Name of filter operation to use.
     *
     * @see ezcImageEffectFilters
     * @see ezcImageGeometryFilters
     * @see ezcImageColorspaceFilters
     *
     * @var string
     */
    public $name;

    /**
     * Associative array of options for the filter operation.
     * The array key is the option name and the array entry is the value for
     * the option.
     * Consult each filter operation to see which names and values to use.
     *
     * @see ezcImageEffectFilters
     * @see ezcImageGeometryFilters
     * @see ezcImageColorspaceFilters
     *
     * @var array(string=>mixed)
     */
    public $options;

    /**
     * Initialize with the filter name and options.
     *
     * @see ezcImageFilter::$name
     * @see ezcImageFilter::$options
     *
     * @param array $name    Name of filter operation.
     * @param array $options Associative array of options for filter operation.
     */
    public function __construct( $name, array $options = array() )
    {
        $this->name    = $name;
        $this->options = $options;
    }
}
?>
