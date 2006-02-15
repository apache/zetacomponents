<?php
/**
 * File containing the ezcImageEffectFilters interface.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
*/

/**
 * This interface has to implemented by ezcImageFilters classes to
 * support useless filters.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * @see ezcImageFiltersInterface
 *
 * @package ImageConversion
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
