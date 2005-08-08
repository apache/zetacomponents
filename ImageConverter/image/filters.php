<?php

interface ezcImageFilters {

    /**
     * The handler this filter class belongs to. Set while instnciating.
     */
//    private $handler;

    /**
     * Create a new Filters object for a handler.
     * This class should never be instanciated directly. Objects are created
     * by the specific handler, this class belongs to. It's just the outsourced
     * filter callbacks of the handler {@link ezcImageHandler}.
     *
     * @param ezcImageHandler $handler Handler utilized by this filters.
     */
    public function __construct( ezcImageHandler $handler )
    {
        
    }

    /**
     * Apply the filter named to the image resource given.
     * Apply's the filter named to the given resource using the given parameters.
     *
     * @param mixed $image The input resource.
     * @param string $filter Filter to apply.
     * @param array(string) Parameters expected by the filter.
     * 
     * @throws ezcImageFiltersParameterException
     * @throws ezcImageHandlerResourceException
     * 
     * @return void
     */
    public function apply( $image, $filter, $parameters )
    {
        
    }
}

