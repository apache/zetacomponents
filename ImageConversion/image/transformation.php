<?php
/**
 * Representation of different image transformations.
 * Objects of this class group MIME type conversion and filtering of images
 * into transformations of images. Transformations can be chained by referencing
 * to another transformation so that multiple transformations will be produced 
 * after each other.
 * 
 * @see ezcImageConverter
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Representation of different image transformations.
 * Objects of this class group MIME type conversions and filtering of images
 * into transformations of images. 
 *
 * <code>
 * $filters = array(
 *  'scaleDownByWidth' => array(
 *      'width' => 100
 *  ),
 *  'border' => array(
 *      'width' => 2,
 *      'color' => array(100, 100, 100),
 *  ),
 * );
 * $mimeTypes = array('image/JPEG', 'image/PNG');
 * 
 * // ezcImageTransformation object returned for further manipulation
 * $thumbnail = $converter->createTransformation('thumbnail', 
 *                                               array('filters' => $filters, 
 *                                                     'mimeOut' => $mimeTypes));
 * 
 * $converter->transform('thumbnail', 'var/storage/myOrinal1.jpg', 
 *                       'var/storage/myThumbnail1'); // res: myThumbnail1.jpg
 * $converter->transform('thumbnail', 'var/storage/myOrinal2.png', 
 *                       'var/storage/myThumbnail2'); // res: myThumbnail2.png
 * $converter->transform('thumbnail', 'var/storage/myOrinal3.gif', 
 *                       'var/storage/myThumbnail3'); // res: myThumbnail2.png
 * 
 * // Animated GIF, will simply be copied!
 * $converter->transform('thumbnail', 'var/storage/myOrinal4.gif', 'var/storage/myThumbnail4');
 * </code>
 * 
 * @see ezcImageConverter
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcImageTransformation {

    /**
     * Array of MIME types allowed as output for this transformation.
     * Leave empty, for all MIME types to be allowed.
     *
     * @var array(string)
     */
    public $mimeOut;

    /**
     * Stores the filters utilized by a transformation.
     * <pre>
     * array( 
     *      'filterName' => array(
     *          '<optionname>'  => <value>,
     *      )
     * )
     * </pre>
     *
     * @var array(string)
     */
    public $filters;    // virtual, __set()/__get()

    /**
     * Create a transformation
     *
     * @param string $name                   Name for the transformation
     * @param array(ezcImageFilter) $filters Filters to apply
     * @param array(string) $mimeOut         Output MIME types
     *
     * @throws ezcImageFilterException On invalid filter or settings error
     * @throws ezcImageConversionException When the output type is unsupported.
     */
    public function __construct( $name, $filters = array(), $mimeOut = array()  ) 
    {
        
    }

    /**
     * Add a filter to the conversion.
     * Adds a filter with the specific settings. Filters can be added either 
     * before an existing filter or at the end (leave out $before parameter).
     *
     * @param string $name            Name of the filter
     * @param array(string) $settings Settings for the filter
     * @param string $before          Where to add the filter
     * 
     * @throws ezcImageFilterException On invalid filter or settings error
     */
    public function addFilter( $name, $settings, $before = null ) {
        
    }
    /**
     * Determine output MIME type
     * Returns the MIME type that the transformation will output.
     *
     * @param string $fileIn File that should deal as input for the transformation.
     *
     * @return string MIME type the transformation will output.
     *
     * @throws ezcImageConversionException When the input type is unsupported.
     */
    public function getOutType( $fileIn ) {

    }

    /**
     * Apply the given transformations and create the image transformation wanted.
     *
     * @param string $fileIn  The file to transform.
     * @param string $fileOut The file to save the transformed image to.
     * @return void
     *
     * @throws ezcImageConversionException When the input type is unsupported.
     */
    public function transform( $fileIn, $fileOut )
    {
        
    }
}
