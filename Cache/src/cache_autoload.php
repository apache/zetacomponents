<?php
/**
 * Autoload map for Cache package.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array (
    'ezcCacheManager'                       => 'Cache/manager.php',
    'ezcCacheStorage'                       => 'Cache/storage.php',
    'ezcCacheStorageOptions'                => 'Cache/options/storage.php',
    'ezcCacheStorageFile'                   => 'Cache/storage/file.php',
    'ezcCacheStorageFileArray'              => 'Cache/storage/file/array.php',
    'ezcCacheStorageFileEvalArray'          => 'Cache/storage/file/eval_array.php',
    'ezcCacheStorageFilePlain'              => 'Cache/storage/file/plain.php',
    'ezcCacheException'                     => 'Cache/exceptions/exception.php',
    'ezcCacheInvalidDataException'          => 'Cache/exceptions/invalid_data.php',
    'ezcCacheInvalidIdException'            => 'Cache/exceptions/invalid_id.php',
    'ezcCacheInvalidLocationException'      => 'Cache/exceptions/invalid_location.php',
    'ezcCacheInvalidStorageClassException'  => 'Cache/exceptions/invalid_storage_class.php',
    'ezcCacheUsedLocationException'         => 'Cache/exceptions/used_location.php',
);
?>
