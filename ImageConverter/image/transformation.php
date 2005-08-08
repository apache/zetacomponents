<?php
/**
 * Representation of different image transformations.
 * Objects of this class group MIME type conversion and filtering of images
 * into transformations of images. Transformations can be chained by referencing to another transformation
 * so that multiple transformations will be produced after each other.
 * 
 * @see ezcImageConverter
 * 
 * @package ImageConverter
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
 * $converter->createTransformation('thumbnail', array('filters' => $filters, 'mimeOut' => $mimeTypes));
 * $converter->transform('thumbnail', 'var/storage/myOrinal1.jpg', 'var/storage/myThumbnail1'); // res: myThumbnail1.jpg
 * $converter->transform('thumbnail', 'var/storage/myOrinal2.png', 'var/storage/myThumbnail2'); // res: myThumbnail2.png
 * $converter->transform('thumbnail', 'var/storage/myOrinal3.gif', 'var/storage/myThumbnail3'); // res: myThumbnail2.png
 * // Animated GIF:
 * $converter->transform('thumbnail', 'var/storage/myOrinal4.gif', 'var/storage/myThumbnail4'); // res: error no transform on animated GIF!
 * </code>
 * 
 * @see ezcImageConverter
 * 
 * @package ImageConverter
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
     * @param string $name
     * @param array(ezcImageFilter) Filters to apply
     * @param array(string) Output MIME types
     */
    public function __construct( $name, $filters, $mimeOut = array()  ) 
    {
        
    }

    /**
     * Apply the given transformations and create the image transformation wanted.
     *
     * @param string $fileIn The file to transform.
     * @param string $fileOut The file to save the transformed image to.
     * @return void
     */
    public function transform( $fileIn, $fileOut )
    {
        
    }
}
