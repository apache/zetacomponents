<?php
/**
 * This file contains the ezcImageImagemagickHandler class.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access private
 */

/**
 * ezcImageHandler implementation for ImageMagick.
 *
 * @see ezcImageConverter
 * @see ezcImageHandler
 *
 * @package ImageConversion
 * @access private
 */
class ezcImageImagemagickHandler extends ezcImageMethodcallHandler implements ezcImageGeometryFilters, ezcImageColorspaceFilters, ezcImageEffectFilters
{
    private $binary;

    private $tagMap = array();

    private $filterOptions = array();

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
        $ref = $this->loadCommon( $file, isset( $mime ) ? $mime : null );

        // Atomic file operation
        $fileTmp = tempnam( dirname( $file ), '.' . basename( $file ) );
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
    public function save( $image, $newFile = null, $mime = null )
    {
        if ( $newFile !== null )
        {
            $this->checkFileName( $newFile );
        }
        $this->saveCommon( $image, isset( $newFile ) ? $newFile : null, isset( $mime ) ? $mime : null );
        
        // Prepare ImageMagick command
        $command = $this->binary . ' ' .
            escapeshellarg( $this->getReferenceData( $image, 'resource' ) ) . ' ' .
            ( isset( $this->filterOptions[$image] ) ? implode( ' ', $this->filterOptions[$image] ) : '' ) . ' ' .
            escapeshellarg( $this->tagMap[$this->getReferenceData( $image, 'mime' )] . ':' . $this->getReferenceData( $image, 'resource' ) );
        
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
            throw new Exception( "The command <{$command}> resulted in an error: <{$errorString}>." );
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
    protected function addFilterOption( $reference, $name, $parameter )
    {
        $this->filterOptions[$reference][] = $name . ' ' . escapeshellarg( $parameter );
    }

    /**
     * Determines the supported input/output types supported by handler.
     * Set's various attributes to reflect the MIME types this handler is
     * capable to process.
     *
     * @return void
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
                    throw new ezcImageHandlerNotAvailableException( $this->name, 'System <'.PHP_OS.'> not supported by handler <'.$this->name.'>.' );
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
     * Creates the Shell filter and returns it.
     *
     * @return ezcImageImagemagickFilters The filters object.
     */
    protected function createFilter()
    {
        if ( !class_exists( 'ezcImageImagemagickFilters' ) )
        {
            // If this code is reached we have a bug in this component.
            throw new Exception( "Filter class not found for filter <{$this->name}>. Must be named <ezcImageImagemagickFilters>" ); 
        }
        return new ezcImageImagemagickFilters( $this );
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

    // Filter methods
    
    /**
     * Scale filter.
     * General scale filter. Scales the image to fit into a given box size, 
     * determined by a given width and height value, measured in pixel. This 
     * method maintains the aspect ratio of the given image. Depending on the
     * given direction value, this method performs the following scales:
     *
     * - ezcImageGeometryFilters::SCALE_BOTH:
     *      The image will be scaled to fit exactly into the given box 
     *      dimensions, no matter if it was smaller or larger as the box
     *      before.
     * - ezcImageGeometryFilters::SCALE_DOWN:
     *      The image will be scaled to fit exactly into the given box 
     *      only if it was larger than the given box dimensions before. If it
     *      is smaller, the image will not be scaled at all.
     * - ezcImageGeometryFilters::SCALE_UP:
     *      The image will be scaled to fit exactly into the given box 
     *      only if it was smaller than the given box dimensions before. If it
     *      is larger, the image will not be scaled at all. ATTENTION:
     *      In this case, the image does not necessarily fit into the given box
     *      afterwards.
     *
     * @param int $width     Scale to width
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scale( $width, $height, $direction = ezcImageGeometryFilters::SCALE_BOTH )
    {
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        
        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.$dirMod.'x'.$height.$dirMod
        );
    }

    /**
     * Scale after width filter.
     * Scales the image to a give width, measured in pixel. Scales the height
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * @param int $width     Scale to width
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleWidth( $width, $direction )
    {
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }

        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize ',
            $width.$dirMod
        );
    }

    /**
     * Scale after height filter.
     * Scales the image to a give height, measured in pixel. Scales the width
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleHeight( $height, $direction )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        $dirMod = $this->getDirectionModifier( $direction );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize ',
            'x'.$height.$dirMod
        );
    }

    /**
     * Scale percent measures filter.
     * Scale an image to a given percentage value size.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scalePercent( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        if ( !is_int( $width ) || $width < 1 || $width > 100 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.'%x'.$height.'%'
        );
    }

    /**
     * Scale exact filter.
     * Scale the image to a fixed given pixel size, no matter to which
     * direction.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleExact( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-resize',
            $width.'!x'.$height.'!'
        );
    }

    /**
     * Crop filter.
     * Crop an image to a given size. This takes cartesian coordinates of a
     * rect area to crop from the image. The cropped area will replace the old
     * image resource (not the input image immediately, if you use the
     * {@link ezcImageConverter}).  Coordinates are given as integer values and
     * are measured from the top left corner.
     *
     * @param int $x      Start cropping, x coordinate.
     * @param int $y      Start cropping, y coordinate.
     * @param int $width  Width of cropping area.
     * @param int $height Height of cropping area.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function crop( $x, $y, $width, $height )
    {
        if ( !is_int( $x ) || $x < 1 )
        {
            throw new ezcBaseValueException( 'x', $x, 'int > 0' );
        }
        if ( !is_int( $y ) || $y < 1 )
        {
            throw new ezcBaseValueException( 'y', $y, 'int > 0' );
        }
        if ( !is_int( $height ) )
        {
            throw new ezcBaseValueException( 'height', $height, 'int' );
        }
        if ( !is_int( $width ) )
        {
            throw new ezcBaseValueException( 'width', $width, 'int' );
        }

        $xStart = ( $xStart = min( $x, $x + $width ) ) > 0 ? '+'.$xStart : $xStart;
        $yStart = ( $yStart = min( $y, $y + $height ) ) > 0 ? '+'.$yStart : $yStart;
        $this->addFilterOption(
            $this->getActiveReference(),
            '-crop ',
            abs( $width ).'x'.abs( $height ).$xStart.$yStart
        );
    }

    /**
     * Colorspace filter.
     * Transform the color space of the picture. The following color space are
     * supported:
     *
     * - {@link self::COLORSPACE_GREY} - 255 grey colors
     * - {@link self::COLORSPACE_SEPIA} - Sepia colors
     * - {@link self::COLORSPACE_MONOCHROME} - 2 colors black and white
     *
     * @param int $space Colorspace, one of self::COLORSPACE_* constants.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference
     * @throws ezcBaseValueException
     *         If the parameter submitted as the colorspace was not within the
     *         self::COLORSPACE_* constants.
     */
    public function colorspace( $space )
    {
        switch ( $space )
        {
            case self::COLORSPACE_GREY:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colorspace',
                    'GRAY'
                );
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colors',
                    '255'
                );
                break;
            case self::COLORSPACE_MONOCHROME:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-monochrome',
                    ''
                );
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-colors',
                    '2'
                );
                break;
            case self::COLORSPACE_SEPIA:
                $this->addFilterOption(
                    $this->getActiveReference(),
                    '-sepia-tone',
                    '80%'
                );
                break;
            return;
            default:
                throw new ezcBaseValueException( 'space', $space, 'self::COLORSPACE_GREY, self::COLORSPACE_SEPIA, self::COLORSPACE_MONOCHROME' );
                break;
        }
    }

    /**
     * Noise filter.
     * Apply a noise transformation to the image. Valid values are the following
     * strings:
     * - 'Uniform'
     * - 'Gaussian'
     * - 'Multiplicative'
     * - 'Impulse'
     * - 'Laplacian'
     * - 'Poisson'
     *
     * @param strings $value Noise value as described above.
     * @return void
     *
     * @throws ezcBaseValueException
     *         If the noise value is out of range.
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     */
    public function noise( $value )
    {
        $value = ucfirst( strtolower( $value ) );
        $possibleValues = array(
           'Uniform',
           'Gaussian',
           'Multiplicative',
           'Impulse',
           'Laplacian',
           'Poisson',
        );
        if ( !in_array( $value, $possibleValues ) )
        {
            throw new ezcBaseValueException( 'value', $value, 'Uniform, Gaussian, Multiplicative, Impulse, Laplacian, Poisson' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '+noise',
            $value
        );
    }

    /**
     * Swirl filter.
     * Applies a swirl with the given intense to the image.
     *
     * @param int $value Intense of swirl.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If the swirl value is out of range.
     */
    public function swirl( $value )
    {
        if ( !is_int( $value ) || $value < 0 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= 0' );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-swirl',
            $value
        );
    }

    /**
     * Border filter.
     * Adds a border to the image. The width is measured in pixel. The color is
     * defined in an array of hex values:
     *
     * <code>
     * array(
     *      0 => <red value>,
     *      1 => <green value>,
     *      2 => <blue value>,
     * );
     * </code>
     *
     * @param int $width        Width of the border.
     * @param array(int) $color Color.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         No loaded file could be found or an error destroyed a loaded reference.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function border( $width, array $color )
    {
        if ( !is_int( $width ) )
        {
            throw new ezcBaseValueException( 'width', $width, 'int' );
        }
        $colorString = '#';
        $i = 0;
        foreach ( $color as $id => $colorVal )
        {
            if ( $i++ > 2 )
            {
                break;
            }
            $colorString .= sprintf( '%02x', $colorVal );
        }
        $this->addFilterOption(
            $this->getActiveReference(),
            '-bordercolor',
            $colorString
        );
        $this->addFilterOption(
            $this->getActiveReference(),
            '-border',
            $width
        );
    }

    /**
     * Returns the ImageMagick direction modifier for a direction constant.
     * ImageMagick supports the following modifiers to determine if an
     * image should be scaled up only, down only or in both directions:
     *
     * <code>
     *  SCALE_UP:   >
     *  SCALE_DOWN: <
     * </code>
     *
     * This method returns the correct modifier for the internal direction
     * constants.
     *
     * @param int $direction One of ezcImageGeometryFilters::SCALE_*
     * @return string The correct modifier.
     *
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    protected function getDirectionModifier( $direction )
    {
        $dirMod = '';
        switch ( $direction )
        {
            case self::SCALE_DOWN:
                $dirMod = '>';
                break;
            case self::SCALE_UP:
                $dirMod = '<';
                break;
            case self::SCALE_BOTH:
                $dirMod = '';
                break;
            default:
                throw new ezcBaseValueException( 'direction', $direction, 'self::SCALE_BOTH, self::SCALE_UP, self::SCALE_DOWN' );
                break;
        }
        return $dirMod;
    }
}
?>
