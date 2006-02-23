<?php
/**
 * This file contains the ezcImageGdHandler class.
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
 *
 * @see ezcImageConverter
 * @see ezcImageHandler
 *
 * @package ImageConversion
 */
class ezcImageGdHandler extends ezcImageMethodcallHandler implements ezcImageGeometryFilters, ezcImageColorspaceFilters
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


    // Filter methods.

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
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $width     Scale to width
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
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
        
        $resource = $this->getActiveResource();
        $oldDim = array( 'x' => imagesx( $resource ), 'y' => imagesy( $resource ) );

        $widthRatio = $width / $oldDim['x'];
        $heighRatio = $height / $oldDim['y'];
        
        $ratio = min( $widthRatio, $heighRatio );
        
        switch ( $direction )
        {
            case self::SCALE_DOWN:
                $ratio = $ratio < 1 ? $ratio : 1;
                break;
            case self::SCALE_UP:
                $ratio = $ratio > 1 ? $ratio : 1;
                break;
            case self::SCALE_BOTH:
                break;
            default:
                throw new ezcBaseValueException( 'direction', $direction, 'self::SCALE_BOTH, self::SCALE_UP, self::SCALE_DOWN' );
                break;
        }
        $newDim = array(
            'x' => round( $oldDim['x'] * $ratio ),
            'y' => round( $oldDim['y'] * $ratio ),
        );
        $this->performScale( $newDim );
    }

    /**
     * Scale after width filter.
     * Scales the image to a give width, measured in pixel. Scales the height
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $width     Scale to width
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleWidth( $width, $direction )
    {
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }

        $resource = $this->getActiveResource();
        $oldDim = array(
            'x' => imagesx( $resource ),
            'y' => imagesy( $resource ),
        );
        switch ( $direction )
        {
            case self::SCALE_BOTH:
                $newDim = array(
                    'x' => $width,
                    'y' => $width / $oldDim['x'] * $oldDim['y']
                );
                break;
            case self::SCALE_UP:
                $newDim = array(
                    'x' => max( $width, $oldDim['x'] ),
                    'y' => $width > $oldDim['x'] ? round( $width / $oldDim['x'] * $oldDim['y'] ) : $oldDim['y'],
                );
                break;
            case self::SCALE_DOWN:
                $newDim = array(
                    'x' => min( $width, $oldDim['x'] ),
                    'y' => $width < $oldDim['x'] ? round( $width / $oldDim['x'] * $oldDim['y'] ) : $oldDim['y'],
                );
                break;
            default:
                throw new ezcBaseValueException( 'direction', $direction, 'self::SCALE_BOTH, self::SCALE_UP, self::SCALE_DOWN' );
                break;
        }
        $this->performScale( $newDim );
    }

    /**
     * Scale after height filter.
     * Scales the image to a give height, measured in pixel. Scales the width
     * automatically while keeping the ratio. The direction dictates, if an
     * image may only be scaled {@link self::SCALE_UP}, {@link self::SCALE_DOWN}
     * or if the scale may work in {@link self::SCALE_BOTH} directions.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $height    Scale to height
     * @param int $direction Scale to which direction
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scaleHeight( $height, $direction )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }

        $resource = $this->getActiveResource();
        $oldDim = array(
            'x' => imagesx( $resource ),
            'y' => imagesy( $resource ),
        );
        switch ( $direction )
        {
            case self::SCALE_BOTH:
                $newDim = array(
                    'x' => $height / $oldDim['y'] * $oldDim['x'],
                    'y' => $height,
                );
                break;
            case self::SCALE_UP:
                $newDim = array(
                    'x' => $height > $oldDim['y'] ? round( $height / $oldDim['y'] * $oldDim['x'] ) : $oldDim['x'],
                    'y' => max( $height, $oldDim['y'] ),
                );
                break;
            case self::SCALE_DOWN:
                $newDim = array(
                    'x' => $height < $oldDim['y'] ? round( $height / $oldDim['y'] * $oldDim['x'] ) : $oldDim['x'],
                    'y' => min( $height, $oldDim['y'] ),
                );
                break;
            default:
                throw new ezcBaseValueException( 'direction', $direction, 'self::SCALE_BOTH, self::SCALE_UP, self::SCALE_DOWN' );
                break;
        }
        $this->performScale( $newDim );
    }

    /**
     * Scale percent measures filter.
     * Scale an image to a given percentage value size.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     * @throws ezcBaseValueException
     *         If a submitted parameter was out of range or type.
     */
    public function scalePercent( $width, $height )
    {
        if ( !is_int( $height ) || $height < 1 )
        {
            throw new ezcBaseValueException( 'height', $height, 'int > 0' );
        }
        if ( !is_int( $width ) || $width < 1 )
        {
            throw new ezcBaseValueException( 'width', $width, 'int > 0' );
        }

        $resource = $this->getActiveResource();
        $newDim = array(
            'x' => round( imagesx( $resource ) * $width / 100 ),
            'y' => round( imagesy( $resource ) * $height / 100 ),
        );
        $this->performScale( $newDim );
    }

    /**
     * Scale exact filter.
     * Scale the image to a fixed given pixel size, no matter to which
     * direction.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $width  Scale to width
     * @param int $height Scale to height
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
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
        $this->performScale( array( 'x' => $width, 'y' => $height ) );
    }

    /**
     * Crop filter.
     * Crop an image to a given size. This takes cartesian coordinates of a
     * rect area to crop from the image. The cropped area will replace the old
     * image resource (not the input image immediately, if you use the
     * {@link ezcImageConverter}).  Coordinates are given as integer values and
     * are measured from the top left corner.
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $x      Start cropping, x coordinate.
     * @param int $y      Start cropping, y coordinate.
     * @param int $width  Width of cropping area.
     * @param int $height Height of cropping area.
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
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
        
        $oldResource = $this->getActiveResource();
        $dimensions = array(
            'x' => abs( $width ),
            'y' => abs( $height ),
        );
        $coords = array(
            'xStart' => min( $x, $x + $width ),
            'xEnd'   => max( $x, $x + $width ),
            'yStart' => min( $y, $y + $height ),
            'yEnd'   => max( $y, $y + $height ),
        );
        if ( imageistruecolor( $oldResource ) )
        {
            $newResource = imagecreatetruecolor( $dimensions['x'], $dimensions['y']  );
        }
        else
        {
            $newResource = imagecreate( $dimensions['x'], $dimensions['y'] );
        }
        $res = imagecopyresampled(
            $newResource,
            $oldResource,
            0, 0, $coords['xStart'], $coords['yStart'],
            $dimensions['x'],
            $dimensions['y'],
            $coords['xEnd'],
            $coords['yEnd']
        );
        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'crop', 'Resampling of image failed.' );
        }
        imagedestroy( $oldResource );
        $this->setActiveResource( $newResource );
    }

    /**
     * Colorspace filter.
     * Transform the colorspace of the picture. The following colorspaces are
     * supported:
     *
     * - {@link self::COLORSPACE_GREY} - 255 grey colors
     * - {@link self::COLORSPACE_SEPIA} - Sepia colors
     * - {@link self::COLORSPACE_MONOCHROME} - 2 colors black and white
     *
     * ATTENTION: Using this filter method directly results in the filter being 
     * applied to the image which is internally marked as "active" (most 
     * commonly this is the last recently loaded one). It is highly recommended
     * to apply filters through the {@link ezcImageGdHandler::applyFilter()} method, 
     * which enables you to specify the image a filter is applied to.
     *
     * @param int $space Colorspace, one of self::COLORSPACE_* constants.
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcBaseValueException
     *         If the parameter submitted as the colorspace was not within the
     *         self::COLORSPACE_* constants.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     */
    public function colorspace( $space )
    {
        switch ( $space )
        {
            case self::COLORSPACE_GREY:
                $this->luminanceColorScale( array( 1.0, 1.0, 1.0 ) );
                break;
            case self::COLORSPACE_MONOCHROME:
                $this->thresholdColorScale(
                    array(
                        127 => array( 0, 0, 0 ),
                        255 => array( 255, 255, 255 ),
                    )
                );
                break;
            return;
            case self::COLORSPACE_SEPIA:
                $this->luminanceColorScale( array( 1.0, 0.89, 0.74 ) );
                break;
            default:
                throw new ezcBaseValueException( 'space', $space, 'self::COLORSPACE_GREY, self::COLORSPACE_SEPIA, self::COLORSPACE_MONOCHROME' );
                break;
        }

    }

    // private

    /**
     * Retrieve luminance value for a specific pixel.
     *
     * @param resource(GD) $resource Image resource
     * @param int $x                 Pixel x coordinate.
     * @param int $y                 Pixel y coordinate.
     * @return float Luminance value.
     */
    private function getLuminanceAt( $resource, $x, $y )
    {
            $currentColor = imagecolorat( $resource, $x, $y );
            $rgbValues = array(
                'r' => ( $currentColor >> 16 ) & 0xff,
                'g' => ( $currentColor >> 8 ) & 0xff,
                'b' => $currentColor & 0xff,
            );
            return $rgbValues['r'] * 0.299 + $rgbValues['g'] * 0.587 + $rgbValues['b'] * 0.114;
    }

    /**
     * Scale colors by threshold values.
     * Thresholds are defined by the following array structures:
     *
     * <code>
     * array(
     *  <int threshold value> => array(
     *      0 => <int red value>,
     *      1 => <int green value>,
     *      2 => <int blue value>,
     *  ),
     * )
     * </code>
     *
     * @param array $thresholds
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     *
     * @todo Optimization as described here: http://lists.ez.no/pipermail/components/2005-November/000566.html
     */
    protected function thresholdColorScale( $thresholds )
    {
        $resource = $this->getActiveResource();
        $dimensions = array( 'x' => imagesx( $resource ), 'y' => imagesy( $resource ) );

        // Check for GIFs and convert them to work properly here.
        if ( !imageistruecolor( $resource ) )
        {
            $resource = $this->paletteToTruecolor( $resource, $dimensions );
        }

        foreach ( $thresholds as $threshold => $colors )
        {
            $thresholds[$threshold] = array_merge(
                $colors,
                array( 'color' => $this->getColor( $resource, $colors[0], $colors[1], $colors[2] ) )
            );
        }
        // Default
        if ( !isset( $thresholds[255] ) )
        {
            $thresholds[255] = end( $thresholds );
            reset( $thresholds );
        }

        $colorCache = array();

        for ( $x = 0; $x < $dimensions['x']; $x++ )
        {
            for ( $y = 0; $y < $dimensions['y']; $y++ )
            {
                $luminance = $this->getLuminanceAt( $resource, $x, $y );
                $color = end( $thresholds );
                foreach ( $thresholds as $threshold => $colorValues )
                {
                    if ( $luminance <= $threshold )
                    {
                        $color = $colorValues;
                        break;
                    }
                }
                imagesetpixel( $resource, $x, $y, $color['color'] );
            }
        }

        $this->setActiveResource( $resource );
    }

    /**
     * Perform luminance color scale.
     *
     * @param array $scale Array of RGB values (numeric index).
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed
     *
     * @todo Optimization as described here: http://lists.ez.no/pipermail/components/2005-November/000566.html
     */
    protected function luminanceColorScale( $scale )
    {
        $resource = $this->getActiveResource();
        $dimensions = array( 'x' => imagesx( $resource ), 'y' => imagesy( $resource ) );

        // Check for GIFs and convert them to work properly here.
        if ( !imageistruecolor( $resource ) )
        {
            $resource = $this->paletteToTruecolor( $resource, $dimensions );
        }

        for ( $x = 0; $x < $dimensions['x']; $x++ )
        {
            for ( $y = 0; $y < $dimensions['y']; $y++ )
            {
                $luminance = $this->getLuminanceAt( $resource, $x, $y );
                $newRgbValues = array(
                    'r' => $luminance * $scale[0],
                    'g' => $luminance * $scale[1],
                    'b' => $luminance * $scale[2],
                );
                $color = $this->getColor( $resource, $newRgbValues['r'], $newRgbValues['g'], $newRgbValues['b'] );
                imagesetpixel( $resource, $x, $y, $color );
            }
        }
        $this->setActiveResource( $resource );
    }

    /**
     * Convert a palette based image resource to a true color one.
     * Takes a GD resource that does not represent a true color image and
     * converts it to a true color based resource. Do not forget, to replace
     * the actual resource in the handler, if you use this ,method!
     *
     * @param resource(GD) $resource The image resource to convert
     * @return resource(GD) The converted resource.
     */
    protected function paletteToTruecolor( $resource, $dimensions )
    {
        $newResource = imagecreatetruecolor( $dimensions['x'], $dimensions['y'] );
        imagecopy( $newResource, $resource, 0, 0, 0, 0, $dimensions['x'], $dimensions['y'] );
        imagedestroy( $resource );
        return $newResource;
    }

    /**
     * Common color determination method.
     * Returns a color identifier for an RGB value. Avoids problems with palette images.
     *
     * @param reource(GD) $resource The image resource to get a color for.
     * @param int $r                Red value.
     * @param int $g                Green value.
     * @param int $b                Blue value.
     *
     * @return int The color identifier.
     *
     * @throws ezcImageFilterFailedException
     *         If the operation performed by the the filter failed.
     */
    protected function getColor( $resource, $r, $g, $b )
    {
        if ( ( $res = imagecolorexact( $resource, $r, $g, $b ) ) !== -1 )
        {
            return $res;
        }
        if ( ( $res = imagecolorallocate( $resource, $r, $g, $b ) ) !== -1 )
        {
            return $res;
        }
        if ( ( $res = imagecolorclosest( $resource, $r, $g, $b ) ) !== -1 )
        {
            return $res;
        }
        throw new ezcImageFilterFailedException( 'colorspace', "Color allocation failed for color r:<{$r}>, g:<{$g}>, b:<{$b}>." );
    }

    /**
     * General scaling method to perform actual scale to new dimensions.
     *
     * @param array $dimensions Dimensions as array('x' => <int>, 'y' => <int>).
     * @return void
     *
     * @throws ezcImageInvalidReferenceException
     *         If no valid resource for the active reference could be found.
     * @throws ezcImageFilterFailedException.
     *         If the operation performed by the the filter failed.
     */
    protected function performScale( $dimensions )
    {
        $oldResource = $this->getActiveResource();
        if ( imageistruecolor( $oldResource ) )
        {
            $newResource = imagecreatetruecolor( $dimensions['x'], $dimensions['y'] );
        }
        else
        {
            $newResource = imagecreate( $dimensions['x'], $dimensions['y'] );
        }
        $res = imagecopyresampled(
            $newResource,
            $oldResource,
            0, 0, 0, 0,
            $dimensions['x'],
            $dimensions['y'],
            imagesx( $this->getActiveResource() ),
            imagesy( $this->getActiveResource() )
        );
        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'scale', 'Resampling of image failed.' );
        }
        imagedestroy( $oldResource );
        $this->setActiveResource( $newResource );
    }
}
?>
