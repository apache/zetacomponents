<?php
/**
 * File containing the ezcDocumentPdfImage class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * PDF image handler
 *
 * Class handling image references, extracting their mime type and dimentsions.
 * Additional handler classes may be registered for yet unhandled file types.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPdfImageHandler
{
    /**
     * List of registered image handlers
     */
    protected static $handler = array();

    /**
     * Path to image file
     * 
     * @var string
     */
    protected $file;

    /**
     * Handler used for the current image file.
     * 
     * @var ezcDocumentPdfBaseImageHandler
     */
    protected $handler;

    /**
     * Construct new image handler
     * 
     * @return void
     */
    public function __construct()
    {
        self::$handler = array(
            new ezcDocumentPdfPhpImageHandler(),
        );
    }

    /**
     * Create image handler object from file
     * 
     * @param string $file 
     * @return ezcDocumentPdfImage
     */
    public static function createFromFile( $file )
    {
        $image = new ezcDocumentPdfImage();
        $image->load( $file );
        return $image;
    }

    /**
     * Register additional image handler
     * 
     * @param ezcDocumentPdfBaseImageHandler $handler 
     * @return void
     */
    public static function registerImageHander( ezcDocumentPdfBaseImageHandler $handler )
    {
        self::$handler[] = $handler;
    }
    
    /**
     * Load image file
     * 
     * @param string $file 
     * @return void
     */
    public function loadFile( $file )
    {
        $this->file = $file;
    }

    /**
     * Get image dimensions
     *
     * Return an array with the image dimensions. The array will look like:
     * array( width, height ).
     * 
     * @return array
     */
    public function getDimensions()
    {
        
    }

    /**
     * Get image mime type
     *
     * Return a string with the image mime type, identifying the type of the
     * image.
     * 
     * @return string
     */
    public function getMimeType()
    {
        
    }
}
?>
