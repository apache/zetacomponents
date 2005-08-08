<?php

/**
 * Representation of different image types.
 * Objects of this class group MIME type conversion and filtering of images
 * into types of images. Transformations can be chained by referencing to another type
 * so that multiple types will be produced after each other.
 * 
 * @see ezcImageManager
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcImageTransformation {

    /**
     * Array of MIME types allowed as output for this type.
     * Leave empty, for all MIME types to be allowed.
     *
     * @var array(string)
     */
    public $mimeOut;

    /**
     * Stores the filters utilized by a type.
     * <pre>
     * array( 
     *      'filterName' => array(
     *          'settings' => array(),
     *          'options'  => array(),
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
     * @param string $name
     * @param array(ezcImageFilter) Filters to apply
     * @param array(string) Output MIME types
     */
    public function __construct( $name, $filters, $mimeOut = array()  ) 
    {
        
    }

    /**
     * Apply the given transformations and create the image type wanted.
     *
     * @param string $fileIn The file to transform.
     * @param string $fileOut The file to save the transformed image to.
     * @return void
     */
    public function transform( $fileIn, $fileOut )
    {
        
    }
}
