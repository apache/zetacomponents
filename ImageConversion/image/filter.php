<?php

class ezcImageFilter {

    private $handler;

    private $name;

    private $settings = array();    // virtual, __get() only

    private $options = array();     // virtual, __get()/__set()

    /**
     * Create a new Filter.
     * Do not use this method directly. Create filters using 
     * {@link ezcImageHandler::createFilter()}.
     *
     * @param ImageHandler $handler Handler utilized by this filter.
     * @param string $name Name of the filter.
     * @param array(string) $settings
     * @param array(string) $options
     */
    public function __construct( ImageHandler $handler, $name, $settings, $options = null )
    {
        
    }

    /**
     * Apply this filter to the given image handler resources.
     *
     * @param string $image The input resource.
     * @return void
     */
    public function apply( $image )
    {
        
    }

    /**
     * Dispatches the filter action to the specific handler.
     */
    private function dispatch( )
    {

    }
}

