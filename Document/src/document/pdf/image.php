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
class ezcDocumentPdfImage
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
     * @var ezcDocumentPdfImageHandler
     */
    protected $currentHandler;

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
        $image->loadFile( $file );
        return $image;
    }

    /**
     * Register additional image handler
     *
     * @param ezcDocumentPdfImageHandler $handler
     * @return void
     */
    public static function registerImageHander( ezcDocumentPdfImageHandler $handler )
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

        foreach ( self::$handler as $handler )
        {
            if ( $handler->canHandle( $file ) )
            {
                $this->currentHandler = $handler;
                $this->file           = $file;
                return true;
            }
        }

        throw new ezcBaseFunctionalityNotSupportedException( $file, 'Unhandled file type' );
    }

    /**
     * Get image dimensions
     *
     * Return an array with the image dimensions. The array will look like:
     * array( ezcDocumentPdfMeasure $width, ezcDocumentPdfMeasure $height ).
     *
     * @return array
     */
    public function getDimensions()
    {
        return $this->currentHandler->getDimensions( $this->file );
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
        return $this->currentHandler->getMimeType( $this->file );
    }
}
?>
