<?php

/**
 * Driver interface to access different image manipulation backends of PHP.
 * This interface has to be implemented by a handler class in order to be
 * used with the ImageConversion package. Reference implementations are 
 * the GD and ImageMagick backends.
 *
 * @see ezcImageManager
 * @see ezcImageHandlerGD
 * @see ezcImageHandlerShell
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
interface ezcImageHandler {

    /**
     * Name of the handler
     *
     * @var string
     */
//    public $name;       // virtual, __get() only

    /**
     * Available filters.
     * <pre>
     * array( 
     *      'filterName' => array(
     *          'settings' => array(),
     *          'options'  => array(),
     *      )
     * )
     * </pre>
     *
     * @var array
     */
//    public $filters;    // virtual, __get() only

    /**
     * Array of MIME types usable for input
     *
     * @var array
     */
//    public $inputTypes; // virtual, __get() only

    /**
     * Array of MIME types usable for output
     *
     * @var array
     */
//    public $outputTypes;// virtual, __get() only

    /**
     * Create a new image handler.
     * Creates an image handler. This should never be done directly,
     * but only through the manager for configuration reasons. One can 
     * get a direct refernce through manager afterwards.
     *
     * @param array(string) $settings
     * @param array(string) $options
     */
    public function __construct( $settings, $options = null );

    /**
     * Load an image file.
     * Loads an image file and returns a reference to it.
     *
     * @param string $file
     * @return string Reference to the file in this handler.
     */
    public function load( $file );
    
    /**
     * Save an image file.
     * Saves a given open file. Can optionally save to a new file name.
     *
     * @param string $image File reference created through {@link load()}.
     * @param string $newFile
     * @return void
     */
    public function save( $image, $newFile = null );

    /**
     * Check wether a specific MIME type is allowed as input for this handler.
     *
     * @param string $mime
     * @return bool
     */
    public function allowsInput( $mime );

    /**
     * Checks wether a specific MIME type is allowed as output for this handler.
     *
     * @param string $mime
     * @return bool
     */
    public function allowsOutput( $mime );

    /**
     * Checks if a given filter is available in this handler.
     *
     * @param string $name
     * @return bool
     */
    public function hasFilter( $name );

    /**
     * Returns the settings required by a filter.
     *
     * @param string $name
     * @return array(string) Settings
     */
    public function getFilterSettings( $name );

    /**
     * Returns the options possible for a filter.
     *
     * @param string $name
     * @return array(string)
     */
    public function getFilterOptions( $name );

    /**
     * Creates a filter and returns it.
     * This is a factory method, to create a filter from the current handler.
     *
     * @param string $name The filter to create.
     * @param array(string) $settings Settings for the filter.
     * @param array(string) $options Options for the filter.
     * @return ImageFilter
     */
    public function createFilter( $name, $settings, $options = null );

    /**
     * Applies a filter to a given image.
     * 
     * @internal This method is the main one, which will dispatch the
     * filter action to the specific function of the backend.
     * 
     * @param ImageFilter $filter
     * @param string $image Image reference to apply the filter on.
     * @return void
     */
    public function applyFilter( ImageFilter $filter, $image );

    /**
     * Converts an image to another MIME type.
     *
     * @param string $image Image reference to convert.
     * @param string $mime MIME type to convert to.
     */
    public function convert( $image, $mime );
}

