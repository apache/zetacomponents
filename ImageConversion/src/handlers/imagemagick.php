<?php
/**
 * This file contains the ezcImageImagemagickHandler class.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access private
 */

/**
 * ezcImageHandler implementation for ImageMagick.
 *
 * @see ezcImageConverter
 * @see ezcImageHandler
 *
 * @package ImageConversion
 * @access private
 */
class ezcImageImagemagickHandler extends ezcImageImagemagickBaseHandler implements ezcImageGeometryFilters, ezcImageColorspaceFilters, ezcImageEffectFilters
{

    /**
     * Scale filter.
     * General scale filter. Scales the image to fit into a given box size, 
     * determined by a given width and height value, measured in pixel. This 
     * method maintains the aspect ratio of the given image. Depending on the
     * given direction value, this method performs the following scales:
     *
     * - ezcImageGeometryFilters::SCALE_BOTH:
     *      The image will be scaled to fit exactly into the given box 
     *      dimensions, no matter if it was smaller or larger as the box
     *      before.
     * - ezcImageGeometryFilters::SCALE_DOWN:
     *      The image will be scaled to fit exactly into the given box 
     *      only if it was larger than the given box dimensions before. If it
     *      is smaller, the image will not be scaled at all.
     * - ezcImageGeometryFilters::SCALE_UP:
     *      The image will be scaled to fit exactly into the given box 
     *      only if it was smaller than the given box dimensions before. If it
     *      is larger, the image will not be scaled at all. ATTENTION:
     *      In this case, the image does not necessarily fit into the given box
     *      afterwards.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $width     Scale to width
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scale( $width, $height, $direction = ezcImageGeometryFilters::SCALE_BOTH )
    {
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        
        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.$dirMod.'x'.$height.$dirMod
        );
    }

    /**
     * Scale after width filter.
     * Scales the image to a give width, measured in pixel. Scales the height
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $width     Scale to width
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleWidth( $width, $direction )
    {
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }

        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize ',
            $width.$dirMod
        );
    }

    /**
     * Scale after height filter.
     * Scales the image to a give height, measured in pixel. Scales the width
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleHeight( $height, $direction )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize ',
            'x'.$height.$dirMod
        );
    }

    /**
     * Scale percent measures filter.
     * Scale an image to a given percentage value size.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scalePercent( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        if ( !is_int( $width ) || $width < 1 || $width > 100 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.'%x'.$height.'%'
        );
    }

    /**
     * Scale exact filter.
     * Scale the image to a fixed given pixel size, no matter to which
     * direction.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleExact( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.'!x'.$height.'!'
        );
    }

    /**
     * Crop filter.
     * Crop an image to a given size. This takes cartesian coordinates of a
     * rect area to crop from the image. The cropped area will replace the old
     * image resource (not the input image immediately, if you use the
     * {@link ezcImageConverter}).  Coordinates are given as integer values and
     * are measured from the top left corner.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $x      X offset of the cropping area.
     * @param int $y      Y offset of the cropping area.
     * @param int $width  Width of cropping area.
     * @param int $height Height of cropping area.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function crop( $x, $y, $width, $height )
    {
        if ( !is_int( $x ) || $x < 0 )
        {
            throw new ezcBaseValueException( 'x', $x, 'int >= 0' );
        }
        if ( !is_int( $y ) || $y < 0 )
        {
            throw new ezcBaseValueException( 'y', $y, 'int >= 0' );
        }
        if ( !is_int( $height ) )
        {
            throw new ezcBaseValueException( 'height', $height, 'int' );
        }
        if ( !is_int( $width ) )
        {
            throw new ezcBaseValueException( 'width', $width, 'int' );
        }

        $xStart = ( $xStart = min( $x, $x + $width ) ) >= 0 ? '+'.$xStart : $xStart;
        $yStart = ( $yStart = min( $y, $y + $height ) ) >= 0 ? '+'.$yStart : $yStart;
        $this->addFilterOption(
            $this->getActiveReference(),
            '-crop ',
            abs( $width ).'x'.abs( $height ).$xStart.$yStart.'!'
        );
    }

    /**
     * Colorspace filter.
     * Transform the color space of the picture. The following color space are
     * supported:
     *
     * - {@link self::COLORSPACE_GREY} - 255 grey colors
     * - {@link self::COLORSPACE_SEPIA} - Sepia colors
     * - {@link self::COLORSPACE_MONOCHROME} - 2 colors black and white
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $space Colorspace, one of self::COLORSPACE_* constants.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If the parameter submitted as the colorspace was not within the
     *         self::COLORSPACE_* constants.
     */
    public function colorspace( $space )
    {
        switch ( $space )
        {
            case self::COLORSPACE_GREY:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colorspace',
                    'GRAY'
                );
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colors',
                    '255'
                );
                break;
            case self::COLORSPACE_MONOCHROME:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-monochrome',
                    ''
                );
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colors',
                    '2'
                );
                break;
            case self::COLORSPACE_SEPIA:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-sepia-tone',
                    '80%'
                );
                break;
            return;
            default:
                throw new ezcBaseValueException( 'space', $space, 'self::COLORSPACE_GREY, self::COLORSPACE_SEPIA, self::COLORSPACE_MONOCHROME' );
                break;
        }
    }

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
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param strings $value Noise value as described above.
     * @return void
     *
     * @throws ezcBaseValueException
     *         If the noise value is out of range.
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     */
    public function noise( $value )
    {
        $value = ucfirst( strtolower( $value ) );
        $possibleValues = array(
           'Uniform',
           'Gaussian',
           'Multiplicative',
           'Impulse',
           'Laplacian',
           'Poisson',
        );
        if ( !in_array( $value, $possibleValues ) )
        {
            throw new ezcBaseValueException( 'value', $value, 'Uniform, Gaussian, Multiplicative, Impulse, Laplacian, Poisson' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '+noise',
            $value
        );
    }

    /**
     * Swirl filter.
     * Applies a swirl with the given intense to the image.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $value Intense of swirl.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If the swirl value is out of range.
     */
    public function swirl( $value )
    {
        if ( !is_int( $value ) || $value < 0 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-swirl',
            $value
        );
    }

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
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageImagemagickHandler::applyFilter()}
     * method, which enables you to specify the image a filter is applied to.
     *
     * @param int $width        Width of the border.
     * @param array(int) $color Color.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function border( $width, array $color )
    {
        if ( !is_int( $width ) )
        {
            throw new ezcBaseValueException( 'width', $width, 'int' );
        }
        $colorString = '#';
        $i = 0;
        foreach ( $color as $id => $colorVal )
        {
            if ( $i++ > 2 )
            {
                break;
            }
            $colorString .= sprintf( '%02x', $colorVal );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-bordercolor',
            $colorString
        );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-border',
            $width
        );
    }

    /**
     * Returns the ImageMagick direction modifier for a direction constant.
     * ImageMagick supports the following modifiers to determine if an
     * image should be scaled up only, down only or in both directions:
     *
     * <code>
     *  SCALE_UP:   >
     *  SCALE_DOWN: <
     * </code>
     *
     * This method returns the correct modifier for the internal direction
     * constants.
     *
     * @param int $direction One of ezcImageGeometryFilters::SCALE_*
     * @return string The correct modifier.
     *
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    protected function getDirectionModifier( $direction )
    {
        $dirMod = '';
        switch ( $direction )
        {
            case self::SCALE_DOWN:
                $dirMod = '>';
                break;
            case self::SCALE_UP:
                $dirMod = '<';
                break;
            case self::SCALE_BOTH:
                $dirMod = '';
                break;
            default:
                throw new ezcBaseValueException( 'direction', $direction, 'self::SCALE_BOTH, self::SCALE_UP, self::SCALE_DOWN' );
                break;
        }
        return $dirMod;
    }
}
?>
