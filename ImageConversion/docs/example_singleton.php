<?php
/**
 * General example for the ImageConversion component.
 *
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'Base/src/base.php';
/**
 * Autoload ezc classes
 *
 * @param string $className
 */
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

function getImageConverterInstance()
{
    if ( !isset( $GLOBALS['_ezcImageConverterInstance'] ) )
    {
        // Prepare settings for ezcImageConverter
        // Defines the handlers to utilize and auto conversions.
        $settings = new ezcImageConverterSettings(
            array(
                new ezcImageHandlerSettings( 'GD',          'ezcImageGdHandler' ),
                new ezcImageHandlerSettings( 'ImageMagick', 'ezcImageImagemagickHandler' ),
            ),
            array(
                'image/gif' => 'image/png',
                'image/bmp' => 'image/jpeg',
            )
        );


        // Create the converter itself.
        $converter = new ezcImageConverter( $settings );

        // Define a transformation
        $filters = array(
            new ezcImageFilter(
                'scale',
                array(
                    'width'     => 100,
                    'height'    => 300,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
            new ezcImageFilter(
                'colorspace',
                array(
                    'space' => ezcImageColorspaceFilters::COLORSPACE_SEPIA,
                )
            ),
            new ezcImageFilter(
                'border',
                array(
                    'width' => 5,
                    'color' => array( 255, 0, 0 ),
                )
            ),
        );

        // Which MIME types the conversion may output
        $mimeTypes = array( 'image/jpeg', 'image/png' );

        // Create the transformation inside the manager
        $converter->createTransformation( 'funny', $filters, $mimeTypes );

        // Assign singleton instance
        $GLOBALS['_ezcImageConverterInstance'] = $converter;
    }

    // Return singleton instance
    return $GLOBALS['_ezcImageConverterInstance'];
}

// ...

// Somewhere else in the code...

// Transform an image.
getImageConverterInstance()->transform( 'funny', dirname( __FILE__ ).'/jpeg.jpg', dirname( __FILE__ ). '/jpeg_singleton.jpg' );

echo 'Succesfully converted <'. dirname( __FILE__ ). '/jpeg.jpg> to <'. dirname( __FILE__ ). '/jpeg_singleton.jpg'.">\n";
?>
