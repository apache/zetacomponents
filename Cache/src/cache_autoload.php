<?php
/**
 * Autoloader definition for the Cache component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Cache
 */

return array(
    'ezcCacheException'                    => 'Cache/exceptions/exception.php',
    'ezcCacheInvalidDataException'         => 'Cache/exceptions/invalid_data.php',
    'ezcCacheInvalidIdException'           => 'Cache/exceptions/invalid_id.php',
    'ezcCacheInvalidStorageClassException' => 'Cache/exceptions/invalid_storage_class.php',
    'ezcCacheUsedLocationException'        => 'Cache/exceptions/used_location.php',
    'ezcCacheStorage'                      => 'Cache/storage.php',
    'ezcCacheStorageFile'                  => 'Cache/storage/file.php',
    'ezcCacheManager'                      => 'Cache/manager.php',
    'ezcCacheStorageFileArray'             => 'Cache/storage/file/array.php',
    'ezcCacheStorageFileEvalArray'         => 'Cache/storage/file/eval_array.php',
    'ezcCacheStorageFileOptions'           => 'Cache/options/storage_file.php',
    'ezcCacheStorageFilePlain'             => 'Cache/storage/file/plain.php',
    'ezcCacheStorageOptions'               => 'Cache/options/storage.php',
);
?>
