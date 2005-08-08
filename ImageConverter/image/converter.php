<?php
/**
 * File containing the ezcImageConverter class.
 *
 * @package ImageConverter
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Manager class to manage all image conversions/filterings/...
 * This class is highly recommended to be used with an external
 * singleton pattern to have just 1 converter in place over the whole
 * application.
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * 
 * @package ImageConverter
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcImageConverter
{
   
    private static $instance;

    /**
     * Manager settings
     * Settings basis for all image manipulations.
     * Array of the following structure:
     * <code>
     * array(
     *      'tmpDir'    => <string>,
     * )
     * </code>
     *
     * @var array(string)
     */
    public $settings;           // virtual, __get()/__set() 
    
    /**
     * Manager options
     * Optional settings to influence transformation behavior.
     * Array of the following structure:
     * <code>
     * array(
     *      'handlerDir' => <string>        // Additional directory to look for handlers
     *      'handlers'   => array(
     *          <name>   => <class>         // Additional handlers to use
     *      ),
     *      'conversions'=> array(
     *          <mime>   => <mime>,         // Which MIME types to convert by default
     *      ),
     *      'exceptions' => array(
     *          <mime>   => array(
     *              <criteria>  => <match>, // Exceptions from transformation, if this criteria matches, no transformation will be processed
     *          ),
     *      ),
     * )
     * </code>
     * 
     * @var array(string)
     */
    public $options = array();  // virtual, __get()/__set()

    private $init = false;

    /**
     * Create a new ezcImageManager
     * The ezcImageManager can be directly instanciated, but it's
     * highly recommended to use a manual singleton implementation
     * to have just 1 instance of a ezcImageManager per Request.
     *
     * @param array(string) $settings
     * @param array(string) $options
     * @throws ezcImageConversionSettingsException
     */
    public function __construct( $settings, $options = array() )
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
     * @param string $inFile The file to transform
     * @param string $outFile The file to save transformed version to
     * @return array(string)
     */
    public function transform( $name, $inFile, $outFile )
    {
        
    }
    
    /**
     * Apply a single filter to an image.
     * Applies just a single filter to an image. Optionally you can select
     * a handler yourself, which is not recommended, but possible.
     *
     * @param string $name Name of the filter.
     * @param string $inFile Name of the input file.
     * @param string $outFile Name of the output file.
     * @param string $handler To choose a specific handler.
     * @return void
     * @throws ezcImageFiltersException if filter is notavailable
     * @throws ezcImageConverterFileException if an error occurs while file
     *                                        reading / writing.
     */
    public function applyFilter( $name, $inFile, $outFile, $handler = null)
    {
        
    }

    /**
     * Returns a list of enabled filters
     * Gives you an overview on filters enbled in the manager.
     * Format is:
     * <code>
     * array(
     *  '<filterName>' => array(
     *      '<optionName>',
     *      ...
     *  ),
     * );
     * </code>
     *
     * @return array(string) 
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
