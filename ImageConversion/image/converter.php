<?php
/**
 * File containing the ezcImageConverter class.
 *
 * @package ImageConversion
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
 * <code>
 *
 * $settings = array('GD', 'Shell');
 * $options = array(
 *  'conversions'   => array(
 *      'image/GIF' => 'image/PNG',
 *      'image/BMP' => 'image/JPG',
 *  )
 * );
 * $converter = new ezcImageConverter($settings, $options);
 *
 * $thumbnail = array(
 *  'filters' = array(
 *      'scaleDownByWidth' => array(
 *          'width' => 100
 *      ),
 *      'border' => array(
 *          'width' => 2,
 *          'color' => array(100, 100, 100),
 *      ),
 *  'mimeTypes' = array('image/JPEG', 'image/PNG');
 * );
 * $converter->createTransformation('thumbnail', $thumbnail);
 *
 * $converter->transform('thumbnail', 'var/storage/football.bmp', 'var/storage/footballThumb');
 *
 * </code>
 *
 * @see ezcImageHandler
 * @see ezcImageTransformation
 * 
 * @package ImageConversion
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
     *      'handlers'    => array( // in priority order
     *          <string>,           // handler name
     *          ...
     *      ),
     * )
     * </code>
     *
     * @var array(string)
     */
    public $settings;           // virtual, __get()
    
    /**
     * Manager options
     * Optional settings to influence transformation behavior.
     * Array of the following structure:
     * <code>
     * array(
     *      'handlerDir' => <string>        // Additional directory to look for handlers
     *      'conversions'=> array(
     *          <mime>   => <mime>,         // Which MIME types to convert by default
     *      ),
     * )
     * </code>
     *
     * @todo Management of conversion exceptions has to be defined.
     * @var array(string)
     */
    public $options = array();  // virtual, __get()/__set()

    private $init = false;

    /**
     * Create a new ezcImageConverter
     * The ezcImageConverter can be directly instanciated, but it's
     * highly recommended to use a manual singleton implementation
     * to have just 1 instance of a ezcImageConverter per Request.
     *
     * ATTENTION: The ezcImageConverter does not support animated
     * GIFs. Animated GIFs will simply be ignored by all filters and
     * conversions.
     *
     * @param array(string) $settings
     * @param array(string) $options
     * @throws ezcImageConverterException for missmatching settings.
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
     * @param string $name Name of the transformation.
     * @param array(string) $filters Array definition of filters.
     * @param array(sting) $mimeOut Array definition of output MIME types.
     *
     * @return ezcImageTransformation
     *
     * @throws ezcImageFilterException on nonexistant filter.
     * @throws eczImageConversionException When the output type is unsupported.
     */
    public function createTransformation( $name, $filters, $mimeOut )
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
     * Returns an array of input filenames mapped to the outputted
     * file names.
     * <code>
     * array(
     *      '<inFile>'    => '<outFile>',
     * )
     * </code>
     *
     * @param string $name Name of the transformation to perform
     * @param string $inFile The file to transform
     * @param string $outFile The file to save transformed version to
     *
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
     *
     * @return void
     *
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
     *  '<filterName>',
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
