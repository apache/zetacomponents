<?php
/**
 * This file contains the ezcImageGdBaseHandler class.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access private
 */

/**
 * ezcImageHandler implementation for the GD2 extension of PHP.
 * This class only implements the base funtionality of handling GD images. If
 * you want to manipulate images using ext/GD in your application, you should
 * use the {@link ezcImageGdHandler}.
 *
 * You can use this base class to implement your own filter set on basis of
 * ext/GD, but you can also use {@link ezcImageGdHandler} for this and profit
 * from its already implemented filters.
 *
 * @see ezcImageConverter
 * @see ezcImageHandler
 *
 * @package ImageConversion
 * @access private
 */
class ezcImageGdBaseHandler extends ezcImageMethodcallHandler 
{
    /**
     * Create a new image handler.
     * Creates an image handler. This should never be done directly,
     * but only through the manager for configuration reasons. One can
     * get a direct reference through manager afterwards.
     *
     * @param ezcImageHandlerSettings $settings
     *        Settings for the handler.
     *
     * @throws ezcImageHandlerNotAvailableException
     *         If the precondition for the handler is not fulfilled.
     */
    public function __construct( ezcImageHandlerSettings $settings )
    {
        if ( !extension_loaded( 'gd' ) )
        {
            throw new ezcImageHandlerNotAvailableException( 'ezcImageGdHandler', 'PHP extension <GD> not available.' );
        }
        $this->determineTypes();
        parent::__construct( $settings );
    }

    /**
     * Load an image file.
     * Loads an image file and returns a reference to it.
     *
     * @param string $file File to load.
     * @param string $mime The MIME type of the file.
     *
     * @return string Reference to the file in this handler.
     *
     * @see ezcImageAnalyzer
     *
     * @throws ezcBaseFileNotFoundException
     *         If the given file does not exist.
     * @throws ezcImageMimeTypeUnsupportedException
     *         If the type of the given file is not recognized
     * @throws ezcImageFileNotProcessableException
     *         If the given file is not processable using this handler.
     * @throws ezcImageFileNameInvalidException 
     *         If an invalid character (", ', $) is found in the file name.
     */
    public function load( $file, $mime = null )
    {
        $this->checkFileName( $file );
        $ref = $this->loadCommon( $file, isset( $mime ) ? $mime : null );
        $loadFunction = $this->getLoadFunction( $this->getReferenceData( $ref, 'mime' ) );
        if ( !function_exists( $loadFunction ) || ( $handle = @$loadFunction( $file ) ) === '' )
        {
            throw new ezcImageFileNotProcessableException( $file, "File could not be opened using $loadFunction." );
        }
        $this->setReferenceData( $ref, $handle, 'resource' );
        return $ref;
    }

    /**
     * Save an image file.
     * Saves a given open file. Can optionally save to a new file name.
     *
     * @see ezcImageHandler::load()
     *
     * @param string $image   File reference created through load().
     * @param string $newFile Filename to save the image to.
     * @param string $mime    New MIME type, if differs from initial one.
     * @return void
     *
     * @throws ezcImageFileNotProcessableException
     *         If the given file could not be saved with the given MIME type.
     * @throws ezcBaseFilePermissionException
     *         If the desired file exists and is not writeable.
     * @throws ezcImageMimeTypeUnsupportedException
     *         If the desired MIME type is not recognized
     * @throws ezcImageFileNameInvalidException 
     *         If an invalid character (", ', $) is found in the file name.
     */
    public function save( $image, $newFile = null, $mime = null )
    {
        if ( $newFile !== null )
        {
            $this->checkFileName( $newFile );
        }
        $this->saveCommon( $image, isset( $newFile ) ? $newFile : null, isset( $mime ) ? $mime : null );
        $saveFunction = $this->getSaveFunction( $this->getReferenceData( $image, 'mime' ) );
        if ( !function_exists( $saveFunction ) ||
            $saveFunction( $this->getReferenceData( $image, 'resource' ), $this->getReferenceData( $image, 'file' ) ) === false )
        {
            throw new ezcImageFileNotProcessableException( $file, "Unable to save file <{$file}> of type <{$mime}>." );
        }
    }

    /**
     * Close the file referenced by $image.
     * Frees the image reference. You should call close() before.
     *
     * @see ezcImageHandler::load()
     * @see ezcImageHandler::save()
     *
     * @param string $image The image reference.
     * @return void
     */
    public function close( $image )
    {
        $res = $this->getReferenceData( $image, 'resource' );
        imagedestroy( $res );
        $this->closeCommon( $image );
    }

    /**
     * Determine, the image types the available GD extension is able to process.
     *
     * @return void
     */
    private function determineTypes()
    {
        $possibleTypes = array(
            IMG_GIF  => 'image/gif',
            IMG_JPG  => 'image/jpeg',
            IMG_PNG  => 'image/png',
            IMG_WBMP => 'image/wbmp',
            IMG_XPM  => 'image/xpm',
        );
        $imageTypes = imagetypes();
        foreach ( $possibleTypes as $bit => $mime )
        {
            if ( $imageTypes & $bit )
            {
                $this->inputTypes[] = $mime;
                $this->outputTypes[] = $mime;
            }
        }
    }

    /**
     * Generate imagecreatefrom* function out of a MIME type.
     *
     * @param string $mime MIME type in format "image/<type>".
     * @return string imagecreatefrom* function name.
     * 
     * @throws ezcImageMimeTypeUnsupportedException
     *         If the load function for a given MIME type does not exist.
     */
    private function getLoadFunction( $mime )
    {
        if ( !$this->allowsInput( $mime ) )
        {
            throw new ezcImageMimeTypeUnsupportedException( $mime, 'input' );
        }
        return 'imagecreatefrom' . substr( strstr( $mime, '/' ), 1 );
    }

    /**
     * Generate image* function out of a MIME type.
     *
     * @param string $mime MIME type in format "image/<type>".
     * @return string image* function name for saving.
     * 
     * @throws ezcImageImagemagickHandler
     *         If the save function for a given MIME type does not exist.
     */
    private function getSaveFunction( $mime )
    {
        if ( !$this->allowsOutput( $mime ) )
        {
            throw new ezcImageMimeTypeUnsupportedException( $mime, 'output' );
        }
        return 'image' . substr( strstr( $mime, '/' ), 1 );
    }

    /**
     * Creates default settings for the handler and returns it.
     * The reference name will be set to 'GD'.
     *
     * @return ezcImageHandlerSettings
     */
    static public function defaultSettings()
    {
        return new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' );
    }

    
}

?>
