<?php
/**
 * General example for the ImageConversion component.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package ImageConversion
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
