<?php
/**
 * File containing the abstract class ezcImageFilters.
 *
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Abstract base for ezcImageFilters classes.
 * This abstract class has to be implemented by classes that deal as
 * storage for image filters. An ezcImageFilter class strictly belongs
 * to an ezcImageHandler. Its purpose ist to carry the filter callbacks for
 * the handler classes.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
abstract class ezcImageFilters {

    /**
     * Scale up and down, as fits
     * 
     * @var int
     */
    const SCALE_BOTH = 10;
    
    /**
     * Scale down only
     * 
     * @var int
     */
    const SCALE_DOWN = 11;
    
    /**
     * Scale up only
     * 
     * @var int
     */
    const SCALE_UP   = 12;   


    /**
     * Grey color space
     *
     * @var int
     */
    const COLOR_SPACE_GREY        = 20;
    
    /**
     * Transparent color space
     *
     * @var int
     */
    const COLOR_SPACE_TRANSPARENT = 21;
    
    /**
     * Monochrome color space
     *
     * @var int
     */
    const COLOR_SPCAE_MONOCHROME  = 22;

    /**
     * Grey luminance
     *
     * @var int
     */
    const LUMINANCE_GREY  = 30;
    
    /**
     * Sepia luminance
     *
     * @var int
     */
    const LUMINANCE_SEPIA = 31;

    /**
     * Filter definitions.
     * This array defines which filters are available in the 
     * specific filters class.
     * 
     * <code>
     * array(
     *  'filterName'  => <bool>
     * );
     * </code>
     *
     * @var array
     */
    protected $filters = array( );

    /**
     * The handler this filter class belongs to. Set while instanciating.
     *
     * @var ezcImageHandler
     */
    protected $handler;

    /**
     * Create a new Filters object for a handler.
     * This class should never be instanciated directly. Objects are created
     * by the specific handler, this class belongs to. It's just the 
     * outsourced filter callbacks of the handler {@link ezcImageHandler}.
     *
     * @param ezcImageHandler $handler Handler utilized by this filters.
     */
    public abstract function __construct( ezcImageHandler $handler );

    /**
     * Apply the filter named to the image resource given.
     * Apply's the filter named to the given resource using the given parameters.
     *
     * @param mixed $image          The input resource.
     * @param string $filter        Filter to apply.
     * @param array(string) $params Parameters expected by the filter.
     * 
     * @throws ezcImageFiltersException If parameters not match.
     * @throws ezcImageHandlerException If $image is not a valid image resource.
     * 
     * @return void
     */
    public abstract function apply( $image, $filter, $params );

    /**
     * Prototype definition for the scale filter.
     *
     * @param int $height    Height to scale to.
     * @param int $width     Width to scale to.
     * @param int $direction One of ezcImageFilters::SCALE_* constants.
     * @return void
     */
    protected abstract function scale( $height, $width, $direction = ezcImageFilters::SCALE_BOTH );
    /**
     * Prototype definition for the scaleWidth filter.
     *
     * @param int $width     Width to scale to.
     * @param int $direction One of ezcImageFilters::SCALE_* constants.
     * @return void
     */
    protected abstract function scaleWidth( $width, $direction = ezcImageFilters::SCALE_BOTH );
    /**
     * Prototype definition for the scaleHeight filter.
     *
     * @param int $height    Height to scale to.
     * @param int $direction One of ezcImageFilters::SCALE_* constants.
     * @return void
     */
    protected abstract function scaleHeight( $height, $direction = ezcImageFilters::SCALE_BOTH );
    /**
     * Prototype definition for the scalePercent filter.
     *
     * @param int $height Height percent value.
     * @param int $width  Width percent value.
     * @return void
     */
    protected abstract function scalePercent( $height, $width );
    /**
     * Prototype definition for the scaleExact filter.
     *
     * @param int $height Height to scale to.
     * @param int $width  Width to scale to.
     * @return void
     */
    protected abstract function scaleExact( $height, $width );
    
    /**
     * Prototype definition for the crop filter.
     *
     * @param int $xStart x coordinate to start cropping.
     * @param int $yStart y coordinate to start cropping.
     * @param int $xEnd   x coordinate to end cropping.
     * @param int $xEnd   y coordinate to end cropping.
     * @return void
     */
    protected abstract function crop( $xStart, $yStart, $xEnd, $yEnd );
    
    /**
     * Prototype definition for the noise filter.
     *
     * @param int $value Noise value.
     * @return void
     */
    protected abstract function noise( $value );
    /**
     * Prototype definition for the swirl filter.
     *
     * @param int $value Swirl value.
     * @return void
     */
    protected abstract function swirl( $value );

    /**
     * Prototype for the colorspace filter.
     *
     * @param int $space Colorspace, one of ezcImageFilters::COLORSPACE_*.
     * @return void
     */
    protected abstract function colorspace( $space );

    /**
     * Prototype for the luminance filter.
     *
     * @param int $type Luminance, one of ezcImageFilters::LUMINANCE_*.
     * @return void
     */
    protected abstract function luminance( $type );

    /**
     * Prototype for the border adding filter.
     *
     * Color value is defined like this:
     * <code>
     * array(
     *  <int>   // Red value
     *  <int>   // Green value
     *  <int>   // Blue value
     *  <int>   // Transparency value
     * );
     * </code>
     *
     * @param int $width        Width of the border.
     * @param array(int) $color Color of the border (RGB, decimal).
     * @return void
     */
    protected abstract function border( $width, $color = array(0, 0, 0) );
    
}
