<?php
/**
 * This file contains the ezcImageImagemagickBaseHandler class.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access private
 */


/**
 * ezcImageHandler implementation for ImageMagick.
 * This class only implements the base funtionality of handling images with 
 * ImageMagick. If you want to manipulate images using ImageMagick in your 
 * application, you should use the {@link ezcImageImagemagickHandler}.
 *
 * You can use this base class to implement your own filter set on basis of
 * ImageMagick, but you can also use {@link ezcImageImagemagickHandler} for 
 * this and profit from its already implemented filters.
 *
 * @see ezcImageConverter
 * @see ezcImageHandler
 *
 * @package ImageConversion
 * @access private
 */
class ezcImageImagemagickBaseHandler extends ezcImageMethodcallHandler 
{
    private $binary;

    private $tagMap = array();

    private $filterOptions = array();

    private $compositeImages = array();

    /**
     * Create a new image handler.
     * Creates an image handler. This should never be done directly,
     * but only through the manager for configuration reasons. One can
     * get a direct reference through manager afterwards.
     *
     * This handler has an option 'binary' available, which allows you to 
     * explicitly set the path to your ImageMagicks "convert" binary (this
     * may be necessary on Windows, since there may be an obscure "convert.exe"
     * in the $PATH variable available, which has nothing to do with
     * ImageMagick).
     *
     * @throws ezcImageHandlerNotAvailableException
     *         If the ImageMagick binary is not found.
     *
     * @param ezcImageHandlerSettings $settings Settings for the handler.
     */
    public function __construct( ezcImageHandlerSettings $settings )
    {
        // Check for ImageMagick
        $this->checkImageMagick( $settings );
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
     *         If the desired file does not exist.
     * @throws ezcImageMimeTypeUnsupportedException
     *         If the desired file has a not recognized type.
     * @throws ezcImageFileNameInvalidException 
     *         If an invalid character (", ', $) is found in the file name.
     */
    public function load( $file, $mime = null )
    {
        $this->checkFileName( $file );
        $ref = $this->loadCommon( $file, $mime );

        // Atomic file operation
        // @todo We should invent a destructor, which cleans up this temp files, 
        // to ensure they don't stay around, if someone forgets to call close()!
        $fileTmp = tempnam( dirname( $file ) . DIRECTORY_SEPARATOR, '.' . basename( $file ) );
        copy( $file, $fileTmp );

        $this->setReferenceData( $ref, $fileTmp, 'resource' );
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
     * @throws ezcBaseFilePermissionException
     *         If the desired file exists and is not writeable.
     * @throws ezcImageMimeTypeUnsupportedException
     *         If the desired MIME type is not recognized.
     * @throws ezcImageFileNameInvalidException 
     *         If an invalid character (", ', $) is found in the file name.
     */
    public function save( $image, $newFile = null, $mime = null, ezcImageSaveOptions $options = null )
    {
        if ( $options === null )
        {
            $options = new ezcImageSaveOptions();
        }

        if ( $newFile !== null )
        {
            $this->checkFileName( $newFile );
        }
        $this->saveCommon( $image, $newFile, $mime );
        
        switch ( $this->getReferenceData( $image, 'mime' ) )
        {
            case "image/jpeg":
                if ( $options->quality !== null )
                {
                    $this->addFilterOption( $image, "quality", $options->quality );
                }
            break;
            case "image/png":
                if ( $options->compression !== null )
                {
                    // ImageMagick uses qualtiy options here and incorporates filter options
                    $this->addFilterOption( $image, "quality", $options->compression * 10 );
                }
            break;
        }

        // Prepare ImageMagick command
        // Here we need a work around, because older ImageMagick versions do not
        // support this option order

        if ( isset( $this->compositeImages[$image] ) )
        {
            $command = $this->binary . ' ' .
                ( isset( $this->filterOptions[$image] ) ? implode( ' ', $this->filterOptions[$image] ) : '' ) . ' ' .
                escapeshellarg( $this->getReferenceData( $image, 'resource' ) ) . ' ' .
                implode( ' ', $this->compositeImages[$image] ) . ' ' .
                escapeshellarg( $this->tagMap[$this->getReferenceData( $image, 'mime' )] . ':' . $this->getReferenceData( $image, 'resource' ) );
        }
        else
        {
            $command = $this->binary . ' ' .
                escapeshellarg( $this->getReferenceData( $image, 'resource' ) ) . ' ' .
                ( isset( $this->filterOptions[$image] ) ? implode( ' ', $this->filterOptions[$image] ) : '' ) . ' ' .
                escapeshellarg( $this->tagMap[$this->getReferenceData( $image, 'mime' )] . ':' . $this->getReferenceData( $image, 'resource' ) );
        }

        
        // Prepare to run ImageMagick command
        $descriptors = array( 
            array( 'pipe', 'r' ),
            array( 'pipe', 'w' ),
            array( 'pipe', 'w' ),
        );
        
        // Open ImageMagick process
        $imageProcess = proc_open( $command, $descriptors, $pipes );
        // Close STDIN pipe
        fclose( $pipes[0] );
        
        $errorString = '';
        // Read STDERR 
        do 
        {
            $errorString .= rtrim( fgets( $pipes[2], 1024) , "\n" );
        } while ( !feof( $pipes[2] ) );
        
        // Wait for process to terminate and store return value
        $return = proc_close( $imageProcess );
        
        // Process potential errors
        if ( $return != 0 || strlen( $errorString ) > 0 )
        {
            // If this code is reached we have a bug in this component or in ImageMagick itself.
            throw new Exception( "The command '{$command}' resulted in an error: '{$errorString}'." );
        }
        // Finish atomic file operation
        copy( $this->getReferenceData( $image, 'resource' ), $this->getReferenceData( $image, 'file' ) );
    }

    /**
     * Close the file referenced by $image.
     * Frees the image reference. You should call close() before.
     *
     * @see ezcImageHandler::load()
     * @see ezcImageHandler::save()
     * @param string $image The image reference.
     */
    public function close( $image )
    {
        unlink( $this->getReferenceData( $image, 'resource' ) );
        $this->setReferenceData( $image, false, 'resource' );
        $this->closeCommon( $image );
    }

    /**
     * Add a filter option to a given reference
     *
     * @param string $reference The reference to add a filter for.
     * @param string $name      The option name.
     * @param string $parameter The option parameter.
     * @return void
     */
    protected function addFilterOption( $reference, $name, $parameter = null )
    {
        $this->filterOptions[$reference][] = $name . ( $parameter !== null ? ' ' . escapeshellarg( $parameter ) : '' );
    }

    /**
     * Add an image to composite with the given reference. 
     * 
     * @param string $reference The reference to add an image to
     * @param string $file      The file to composite with the image.
     * @return void
     */
    protected function addCompositeImage( $reference, $file )
    {
        $this->compositeImages[$reference][] = $file;
    }

    /**
     * Determines the supported input/output types supported by handler.
     * Set's various attributes to reflect the MIME types this handler is
     * capable to process.
     *
     * @return void
     *
     * @apichange Faulty MIME type "image/svg" will be removed and replaced by
     *            correct MIME type image/svg+xml.
     */
    private function determineTypes()
    {
        $tagMap = array(
            'application/pcl' => 'PCL',
            'application/pdf' => 'PDF',
            'application/postscript' => 'PS',
            'application/vnd.palm' => 'PDB',
            'application/x-icb' => 'ICB',
            'application/x-mif' => 'MIFF',
            'image/bmp' => 'BMP3',
            'image/dcx' => 'DCX',
            'image/g3fax' => 'G3',
            'image/gif' => 'GIF',
            'image/jng' => 'JNG',
            'image/jpeg' => 'JPG',
            'image/pbm' => 'PBM',
            'image/pcd' => 'PCD',
            'image/pict' => 'PCT',
            'image/pjpeg' => 'PJPEG',
            'image/png' => 'PNG',
            'image/ras' => 'RAS',
            'image/sgi' => 'SGI',
            'image/svg+xml' => 'SVG',
            // Left over for BC reasons
            'image/svg' => 'SVG',
            'image/tga' => 'TGA',
            'image/tiff' => 'TIF',
            'image/vda' => 'VDA',
            'image/vnd.wap.wbmp' => 'WBMP',
            'image/vst' => 'VST',
            'image/x-fits' => 'FITS',
            'image/x-otb' => 'OTB',
            'image/x-palm' => 'PALM',
            'image/x-pcx' => 'PCX',
            'image/x-pgm' => 'PGM',
            'image/psd' => 'PSD',
            'image/x-ppm' => 'PPM',
            'image/x-ptiff' => 'PTIF',
            'image/x-viff' => 'VIFF',
            'image/x-xbitmap' => 'XPM',
            'image/x-xv' => 'P7',
            'image/xpm' => 'PICON',
            'image/xwd' => 'XWD',
            'text/plain' => 'TXT',
            'video/mng' => 'MNG',
            'video/mpeg' => 'MPEG',
            'video/mpeg2' => 'M2V',
        );
        $types = array_keys( $tagMap );
        $this->inputTypes = $types;
        $this->outputTypes = $types;
        $this->tagMap = $tagMap;
    }

    /**
     * Checks for ImageMagick on the system.
     *
     * @param ezcImageHandlerSettings The settings object of the current handler instance.
     * @return void
     *
     * @throws ezcImageHandlerNotAvailableException
     *         If the ImageMagick binary is not found.
     */
    private function checkImageMagick( ezcImageHandlerSettings $settings )
    {
        if ( !isset( $settings->options['binary'] ) )
        {
            // Try to use basic binary names only, if not provided (standard case 
            // on Unix, binary should be in the $PATH, so is accessable).
            switch ( PHP_OS )
            {
                case 'Linux':
                case 'Unix':
                case 'FreeBSD':
                case 'MacOS':
                case 'Darwin':
                    $this->binary = 'convert';
                    break;
                case 'Windows':
                case 'WINNT':
                case 'WIN32':
                    $this->binary = 'convert.exe';
                    break;
                default:
                    throw new ezcImageHandlerNotAvailableException( $this->name, "System '" . PHP_OS . "' not supported by handler '{$this->name}'." );
                    break;
            }
        }
        else
        {
            $this->binary = $settings->options['binary'];
        }
        
        // Prepare to run ImageMagick command
        $descriptors = array( 
            array( 'pipe', 'r' ),
            array( 'pipe', 'w' ),
            array( 'pipe', 'w' ),
        );

        // Open ImageMagick process
        $imageProcess = proc_open( $this->binary, $descriptors, $pipes );

        // Close STDIN pipe
        fclose( $pipes[0] );

        $outputString = '';
        // Read STDOUT 
        do 
        {
            $outputString .= rtrim( fgets( $pipes[1], 1024 ), "\n" );
        } while ( !feof( $pipes[1] ) );

        $errorString = '';
        // Read STDERR 
        do 
        {
            $errorString .= rtrim( fgets( $pipes[2], 1024 ), "\n" );
        } while ( !feof( $pipes[2] ) );
        
        // Wait for process to terminate and store return value
        $return = proc_close( $imageProcess );

        // Process potential errors
        if ( $return != 0 || strlen( $errorString ) > 0 || strpos( $outputString, 'ImageMagick' ) === false )
        {
            throw new ezcImageHandlerNotAvailableException( $this->name, 'ImageMagick not installed or not available in PATH variable.' );
        }
    }
    
    /**
     * Creates default settings for the handler and returns it.
     * The reference name will be set to 'ImageMagick'.
     *
     * @return ezcImageHandlerSettings
     */
    static public function defaultSettings()
    {
        return new ezcImageHandlerSettings( 'ImageMagick', 'ezcImageImagemagickHandler' );
    }
}

?>
