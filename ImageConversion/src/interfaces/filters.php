<?php
/**
 * File containing the abstract class ezcImageFilters.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access private
 */

/**
 * Abstract base for ezcImageFilters classes.
 * This abstract class has to be implemented by classes that deal as
 * storage for image filters. An ezcImageFilter class strictly belongs
 * to an ezcImageHandler. Its purpose ist to carry the filter callbacks for
 * the handler classes.
 *
 * Which filter methods an ezcImageFilters class provides is defined by
 * the ezcImageFiltersInterface it implements.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * @see ezcImageFiltersInterface
 *
 * @package ImageConversion
 * @access private
 */
abstract class ezcImageFilters
{
    /**
     * The handler this filter class belongs to. Set while instantiating.
     *
     * @var ezcImageHandler
     */
    protected $handler;

    /**
     * Caches the getFilters() methods output.
     *
     * @var array
     */
    private $filterCache;

    /**
     * Create a new Filters object for a handler.
     * This class should never be instantiated directly. Objects are created
     * by the specific handler, this class belongs to. It's just the
     * outsourced filter callbacks of the handler {@link ezcImageHandler}.
     *
     * @param ezcImageHandler $handler Handler utilized by this filters.
     */
    public function __construct( ezcImageHandler $handler )
    {
        $this->handler = $handler;
    }

    /**
     * Returns an array of available filters in this filters class.
     * Returns an array containing all filters available in this filters class:
     *
     * array(
     *  '<filtername>',
     *  '<filtername>',
     * );
     *
     * @return array Available filters.
     */
    public function getFilters()
    {
        if ( isset( $this->filterCache ) )
        {
            return $this->filterCache;
        }
        $exclusions = array(
            '__construct' => true,
            'getFilters'  => true,
        );
        $res = array();
        foreach ( get_class_methods( $this ) as $method )
        {
            // Skip special PHP methods
            if ( substr( $method, 0, 1 ) === '_' )
            {
                continue;
            }
            if ( !isset( $exclusions[$method] ) )
            {
                $res[] = $method;
            }
        }
        $this->filterCache = $res;
        return $res;
    }
}
?>
