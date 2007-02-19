<?php
/**
 * Autoload map for ImageConversion package.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array (
    'ezcImageConverter'                             => 'ImageConversion/converter.php',
    'ezcImageConverterSettings'                     => 'ImageConversion/structs/converter_settings.php',

    'ezcImageTransformation'                        => 'ImageConversion/transformation.php',

    'ezcImageHandler'                               => 'ImageConversion/interfaces/handler.php',
    'ezcImageHandlerSettings'                       => 'ImageConversion/structs/handler_settings.php',
    'ezcImageMethodcallHandler'                     => 'ImageConversion/interfaces/methodcall_handler.php',

    'ezcImageFilter'                                => 'ImageConversion/structs/filter.php',

    'ezcImageGeometryFilters'                       => 'ImageConversion/interfaces/geometry.php',
    'ezcImageColorspaceFilters'                     => 'ImageConversion/interfaces/colorspace.php',
    'ezcImageEffectFilters'                         => 'ImageConversion/interfaces/effect.php',
    'ezcImageWatermarkFilters'                      => 'ImageConversion/interfaces/watermark.php',
    'ezcImageThumbnailFilters'                      => 'ImageConversion/interfaces/thumbnail.php',

    'ezcImageGdHandler'                             => 'ImageConversion/handlers/gd.php',
    'ezcImageGdBaseHandler'                         => 'ImageConversion/handlers/gd_base.php',

    'ezcImageImagemagickHandler'                    => 'ImageConversion/handlers/imagemagick.php',
    'ezcImageImagemagickBaseHandler'                => 'ImageConversion/handlers/imagemagick_base.php',
    
    'ezcImageException'                             => 'ImageConversion/exceptions/exception.php',
    'ezcImageMissingFilterParameterException'       => 'ImageConversion/exceptions/missing_filter_parameter.php',
    'ezcImageFileNotProcessableException'           => 'ImageConversion/exceptions/file_not_processable.php',
    'ezcImageFileNameInvalidException'              => 'ImageConversion/exceptions/file_name_invalid.php',
    'ezcImageFilterFailedException'                 => 'ImageConversion/exceptions/filter_failed.php',
    'ezcImageFilterNotAvailableException'           => 'ImageConversion/exceptions/filter_not_available.php',
    'ezcImageHandlerNotAvailableException'          => 'ImageConversion/exceptions/handler_not_available.php',
    'ezcImageHandlerSettingsInvalidException'       => 'ImageConversion/exceptions/handler_settings_invalid.php',
    'ezcImageInvalidFilterParameterException'       => 'ImageConversion/exceptions/invalid_filter_parameter.php',
    'ezcImageInvalidReferenceException'             => 'ImageConversion/exceptions/invalid_reference.php',
    'ezcImageMimeTypeUnsupportedException'          => 'ImageConversion/exceptions/mime_type_unsupported.php',
    'ezcImageTransformationException'               => 'ImageConversion/exceptions/transformation.php',
    'ezcImageTransformationAlreadyExistsException'  => 'ImageConversion/exceptions/transformation_already_exists.php',
    'ezcImageTransformationNotAvailableException'   => 'ImageConversion/exceptions/transformation_not_available.php',
);

?>
