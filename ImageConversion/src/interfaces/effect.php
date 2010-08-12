<?php
/**
 * File containing the ezcImageEffectFilters interface.
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
 * This interface has to be implemented by ezcImageFilters classes to
 * support effect filters.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * @see ezcImageFiltersInterface
 *
 * @package ImageConversion
 * @version //autogentag//
 */
interface ezcImageEffectFilters
{
    /**
     * Noise filter.
     * Apply a noise transformation to the image. Valid values are the following 
     * strings:
     * - 'Uniform'
     * - 'Gaussian'
     * - 'Multiplicative'
     * - 'Impulse'
     * - 'Laplacian'
     * - 'Poisson'
     *
     * @param strings $value Noise value as described above.
     * @return void
     *
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     */
    function noise( $value );

    /**
     * Swirl filter.
     * Applies a swirl with the given intense to the image.
     *
     * @param int $value Intense of swirl.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    function swirl( $value );

    /**
     * Border filter.
     * Adds a border to the image. The width is measured in pixel. The color is 
     * defined in an array of hex values:
     *
     * <code>
     * array( 
     *      0 => <red value>,
     *      1 => <green value>,
     *      2 => <blue value>,
     * );
     * </code>
     *
     * @param int $width        Width of the border.
     * @param array(int) $color Color.
     * @return void
     * 
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    function border( $width, array $color );
}
?>
