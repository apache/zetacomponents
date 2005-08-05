<?php

/**
 * Manages image conversions.
 *
 * This is a global class to handle all kinds of image conversion
 */

class ezcImageManager
{
   
    private static $instance;

    /**
     * Manager settings
     * Settings basis for all image manipulations.
     * Array of the following structure:
     * <code>
     * array(
     *      'tmpDir'    => <string>,
     *      'outDir'    => <string>,
     * )
     * </code>
     *
     * @var array(string)
     */
    public $settings;           // virtual, __get() only
    
    /**
     * Manager options
     * Optional settings to influence transformation behavior.
     * Array of the following structure:
     * <code>
     * array(
     *      'handlerDir' => <string>        // Additional directory to look for handlers
     *      'handlers'   => array(
     *          <name>   => <class>
     *      ),
     *      'conversions'=> array(
     *          <mime>   => <mime>,
     *      ),
     *      'exceptions' => array(
     *          <mime>   => array(
     *              <criteria>  => <match>,
     *          ),
     *      ),
     * )
     * </code>
     * 
     * @var array(string)
     */
    public $options = array();  // virtual, __get()/__set()

    /**
     * Receive ezcImageManager instance
     * Creates a new ezcImageManager or returns an existing one.
     *
     */
    public function instance( )
    {
        
    }

    /**
     * Initialize the ezcImageManager
     * This initialized the manager with the given settings/options.
     * The ezcManager is reset completly at the start of this method.
     * All added transformations will be lost when calling this.
     *
     * @param array(string) $settings
     * @param array(string) $options
     * @return void
     */
    public function init( $settings, $options = array() )
    {
        
    }

    /**
     * Create a transformation in the manager
     * Creates a transformation and stores it in the manager. A reference to the
     * transformation is returned by this method for further manipulation and 
     * to set options on it.
     *
     * @param string $name Name of the transformation
     * @param array(string) $settings Settings for the transformation
     * @return ezcImageTransformation
     */
    public function createTransformation( $name, $settings )
    {
        
    }

    /**
     * Removes a transformation from the manager
     *
     * @param string $name
     * @return ezcImageTransformation The removed transformation
     */
    public function removeTransformation( $name )
    {
        
    }
   
    /**
     * Apply transformation on a file
     * This applies the given transformation to teh given file.
     * Returns an array containing all performed transformations 
     * in the followin format:
     * <code>
     * array(
     *      <transformationName>    => <file>,
     * )
     * </code>
     *
     * @param string $name Name of the transformation to perform
     * @param string $file The file to transform
     * @return array(string)
     */
    public function transform( $name, $file )
    {
        
    }
    
    /**
     * Returns a single filter instance
     * Returns a single filter to by manually applied to a file.
     *
     * @param string $name Name of the filter
     * @param string $handler To choose a specific handler
     * @return ezcImageFilter
     */
    public function getFilter( $name, $handler = null)
    {
        
    }

    /**
     * Returns a list of enabled filters
     * Gives you an overview on filters enbled in the manager.
     *
     * @return array(string) Names of enabled filters
     */
    public function listFilters( )
    {
        
    }

    /**
     * Checks if a given filter is available
     * Returns either an array of handler names this filter
     * is available in or false if the filter is not enabled.
     *
     * @param string $name
     * @return mixed Array of handlers on succes, otherwise false.
     */
    public function filterExists( $name )
    {

    }
}
