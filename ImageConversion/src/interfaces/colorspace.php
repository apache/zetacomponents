<?php
/**
 * File containing the ezcImageColorspaceFilters interface.
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
 * This interface has to implemented by ezcImageFilters classes to
 * support colorspace filters.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * @see ezcImageFiltersInterface
 *
 * @package ImageConversion
 * @version //autogentag//
 */
interface ezcImageColorspaceFilters
{
    /**
     * Grey color space.
     * 
     * @var int
     */
    const COLORSPACE_GREY = 1;

    /**
     * Sepia color space.
     * 
     * @var int
     */
    const COLORSPACE_SEPIA = 2;

    /**
     * Monochrome color space.
     * 
     * @var int
     */
    const COLORSPACE_MONOCHROME = 3;

    /**
     * Colorspace filter.
     * Transform the colorspace of the picture. The following colorspaces are 
     * supported:
     *
     * - {@link self::COLORSPACE_GREY} - 255 grey colors
     * - {@link self::COLORSPACE_SEPIA} - Sepia colors
     * - {@link self::COLORSPACE_MONOCHROME} - 2 colors black and white
     * 
     * @param int $space Colorspace, one of self::COLORSPACE_* constants.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the parameter submitted as the colorspace was not within the 
     *         self::COLORSPACE_* constants
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    function colorspace( $space );
}
?>
