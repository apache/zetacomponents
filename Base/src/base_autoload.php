<?php
/**
 * Autoloader definition for the Base component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Base
 */

return array(
    'ezcBaseException'                            => 'Base/exceptions/exception.php',
    'ezcBaseFileException'                        => 'Base/exceptions/file_exception.php',
    'ezcBaseAutoloadException'                    => 'Base/exceptions/autoload.php',
    'ezcBaseDoubleClassRepositoryPrefixException' => 'Base/exceptions/double_class_repository_prefix.php',
    'ezcBaseExtensionNotFoundException'           => 'Base/exceptions/extension_not_found.php',
    'ezcBaseFileIoException'                      => 'Base/exceptions/file_io.php',
    'ezcBaseFileNotFoundException'                => 'Base/exceptions/file_not_found.php',
    'ezcBaseFilePermissionException'              => 'Base/exceptions/file_permission.php',
    'ezcBaseInitCallbackConfiguredException'      => 'Base/exceptions/init_callback_configured.php',
    'ezcBaseInvalidParentClassException'          => 'Base/exceptions/invalid_parent_class.php',
    'ezcBasePropertyNotFoundException'            => 'Base/exceptions/property_not_found.php',
    'ezcBasePropertyPermissionException'          => 'Base/exceptions/property_permission.php',
    'ezcBaseSettingNotFoundException'             => 'Base/exceptions/setting_not_found.php',
    'ezcBaseSettingValueException'                => 'Base/exceptions/setting_value.php',
    'ezcBaseValueException'                       => 'Base/exceptions/value.php',
    'ezcBaseWhateverException'                    => 'Base/exceptions/whatever.php',
    'ezcBaseStruct'                               => 'Base/struct.php',
    'ezcBase'                                     => 'Base/base.php',
    'ezcBaseConfigurationInitializer'             => 'Base/interfaces/configuration_initializer.php',
    'ezcBaseFeatures'                             => 'Base/features.php',
    'ezcBaseInit'                                 => 'Base/init.php',
    'ezcBaseOptions'                              => 'Base/options.php',
    'ezcBaseRepositoryDirectory'                  => 'Base/structs/repository_directory.php',
);
?>
