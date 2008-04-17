<?php
/**
 * Autoloader definition for the Cache component.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Cache
 */

return array(
    'ezcCacheException'                     => 'Cache/exceptions/exception.php',
    'ezcCacheApcException'                  => 'Cache/exceptions/apc_exception.php',
    'ezcCacheInvalidDataException'          => 'Cache/exceptions/invalid_data.php',
    'ezcCacheInvalidIdException'            => 'Cache/exceptions/invalid_id.php',
    'ezcCacheInvalidStorageClassException'  => 'Cache/exceptions/invalid_storage_class.php',
    'ezcCacheMemcacheException'             => 'Cache/exceptions/memcache_exception.php',
    'ezcCacheUsedLocationException'         => 'Cache/exceptions/used_location.php',
    'ezcCacheStorage'                       => 'Cache/storage.php',
    'ezcCacheStorageMemory'                 => 'Cache/storage/memory.php',
    'ezcCacheMemoryBackend'                 => 'Cache/backends/memory_backend.php',
    'ezcCacheStorageApc'                    => 'Cache/storage/apc.php',
    'ezcCacheStorageApcOptions'             => 'Cache/options/storage_apc.php',
    'ezcCacheStorageFile'                   => 'Cache/storage/file.php',
    'ezcCacheStorageMemcache'               => 'Cache/storage/memcache.php',
    'ezcCacheApcBackend'                    => 'Cache/backends/apc/apc_backend.php',
    'ezcCacheManager'                       => 'Cache/manager.php',
    'ezcCacheMemcacheBackend'               => 'Cache/backends/memcache/memcache_backend.php',
    'ezcCacheMemoryVarStruct'               => 'Cache/structs/memory_var.php',
    'ezcCacheStackConfigurator'             => 'Cache/interfaces/stack_configurator.php',
    'ezcCacheStackMetaDataStorage'          => 'Cache/interfaces/meta_data_storage.php',
    'ezcCacheStackReplacementStrategy'      => 'Cache/interfaces/replacement_strategy.php',
    'ezcCacheStackableStorage'              => 'Cache/interfaces/stackable_storage.php',
    'ezcCacheStorageApcPlain'               => 'Cache/storage/apc/plain.php',
    'ezcCacheStorageFileApcArray'           => 'Cache/storage/apc/apc_array.php',
    'ezcCacheStorageFileApcArrayDataStruct' => 'Cache/structs/file_apc_array_data.php',
    'ezcCacheStorageFileApcArrayOptions'    => 'Cache/options/storage_apc_array.php',
    'ezcCacheStorageFileArray'              => 'Cache/storage/file/array.php',
    'ezcCacheStorageFileEvalArray'          => 'Cache/storage/file/eval_array.php',
    'ezcCacheStorageFileOptions'            => 'Cache/options/storage_file.php',
    'ezcCacheStorageFilePlain'              => 'Cache/storage/file/plain.php',
    'ezcCacheStorageMemcacheOptions'        => 'Cache/options/storage_memcache.php',
    'ezcCacheStorageMemcachePlain'          => 'Cache/storage/memcache/plain.php',
    'ezcCacheStorageMemoryDataStruct'       => 'Cache/structs/memory_data.php',
    'ezcCacheStorageMemoryRegisterStruct'   => 'Cache/structs/memory_register.php',
    'ezcCacheStorageOptions'                => 'Cache/options/storage.php',
);
?>
