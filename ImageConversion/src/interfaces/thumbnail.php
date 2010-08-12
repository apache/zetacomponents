<?php
/**
 * File containing the ezcImageThumbnailFilters interface.
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
 * support thumbnail filters.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * @see ezcImageFiltersInterface
 *
 * @package ImageConversion
 * @version //autogentag//
 */
interface ezcImageThumbnailFilters
{
    /**
     * Creates a thumbnail, and crops parts of the given image to fit the range best.
     * This filter creates a thumbnail of the given image. The image is scaled
     * down, keeping the original ratio and keeping the image larger as the
     * given range, if necessary. Overhead for the target range is cropped from
     * both sides equally.
     *
     * If you are looking for a filter that just resizes your image to
     * thumbnail size, you should consider the {@link
     * ezcImageGeometryFilters::scale()} filter.
     *
     * @param int $width  Width of the thumbnail.
     * @param int $height Height of the thumbnail.
     */
    public function croppedThumbnail( $width, $height );

    /**
     * Creates a thumbnail, and fills up the image to fit the given range.
     * This filter creates a thumbnail of the given image. The image is scaled
     * down, keeping the original ratio and scaling the image smaller as the
     * given range, if necessary. Overhead for the target range is filled with the given
     * color on both sides equally.
     *
     * The color is defined by the following array format (integer values 0-255):
     *
     * <code>
     * array( 
     *      0 => <red value>,
     *      1 => <green value>,
     *      2 => <blue value>,
     * );
     * </code>
     *
     * If you are looking for a filter that just resizes your image to
     * thumbnail size, you should consider the {@link
     * ezcImageGeometryFilters::scale()} filter.
     * 
     * @param int $width  Width of the thumbnail.
     * @param int $height Height of the thumbnail.
     * @param array $color Fill color.
     * @return void
     */
    public function filledThumbnail( $width, $height, $color = array() );
}

?>
