<?php
/**
 * Autoloader definition for the Cache/ component.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Cache/
 */

return array(
    'ezcCacheException'                     => 'Cache/src/exceptions/exception.php',
    'ezcCacheApcException'                  => 'Cache/src/exceptions/apc_exception.php',
    'ezcCacheInvalidDataException'          => 'Cache/src/exceptions/invalid_data.php',
    'ezcCacheInvalidIdException'            => 'Cache/src/exceptions/invalid_id.php',
    'ezcCacheInvalidMetaDataException'      => 'Cache/src/exceptions/invalid_meta_data.php',
    'ezcCacheInvalidStorageClassException'  => 'Cache/src/exceptions/invalid_storage_class.php',
    'ezcCacheMemcacheException'             => 'Cache/src/exceptions/memcache_exception.php',
    'ezcCacheUsedLocationException'         => 'Cache/src/exceptions/used_location.php',
    'ezcCacheStackMetaDataStorage'          => 'Cache/src/interfaces/meta_data_storage.php',
    'ezcCacheStackableStorage'              => 'Cache/src/interfaces/stackable_storage.php',
    'ezcCacheStorage'                       => 'Cache/src/storage.php',
    'ezcCacheStorageMemory'                 => 'Cache/src/storage/memory.php',
    'ezcCacheMemoryBackend'                 => 'Cache/src/backends/memory_backend.php',
    'ezcCacheStackReplacementStrategy'      => 'Cache/src/interfaces/replacement_strategy.php',
    'ezcCacheStorageApc'                    => 'Cache/src/storage/apc.php',
    'ezcCacheStorageApcOptions'             => 'Cache/src/options/storage_apc.php',
    'ezcCacheStorageFile'                   => 'Cache/src/storage/file.php',
    'ezcCacheStorageMemcache'               => 'Cache/src/storage/memcache.php',
    'ezcCacheApcBackend'                    => 'Cache/src/backends/apc/apc_backend.php',
    'ezcCacheManager'                       => 'Cache/src/manager.php',
    'ezcCacheMemcacheBackend'               => 'Cache/src/backends/memcache/memcache_backend.php',
    'ezcCacheMemoryVarStruct'               => 'Cache/src/structs/memory_var.php',
    'ezcCacheStack'                         => 'Cache/src/stack.php',
    'ezcCacheStackConfigurator'             => 'Cache/src/interfaces/stack_configurator.php',
    'ezcCacheStackLfuReplacementStrategy'   => 'Cache/src/replacement_strategies/lfu.php',
    'ezcCacheStackLruReplacementStrategy'   => 'Cache/src/replacement_strategies/lru.php',
    'ezcCacheStackMetaData'                 => 'Cache/src/structs/meta_data.php',
    'ezcCacheStackOptions'                  => 'Cache/src/options/stack.php',
    'ezcCacheStackStorageConfiguration'     => 'Cache/src/stack/storage_configuration.php',
    'ezcCacheStorageApcPlain'               => 'Cache/src/storage/apc/plain.php',
    'ezcCacheStorageFileApcArray'           => 'Cache/src/storage/apc/apc_array.php',
    'ezcCacheStorageFileApcArrayDataStruct' => 'Cache/src/structs/file_apc_array_data.php',
    'ezcCacheStorageFileApcArrayOptions'    => 'Cache/src/options/storage_apc_array.php',
    'ezcCacheStorageFileArray'              => 'Cache/src/storage/file/array.php',
    'ezcCacheStorageFileEvalArray'          => 'Cache/src/storage/file/eval_array.php',
    'ezcCacheStorageFileOptions'            => 'Cache/src/options/storage_file.php',
    'ezcCacheStorageFilePlain'              => 'Cache/src/storage/file/plain.php',
    'ezcCacheStorageMemcacheOptions'        => 'Cache/src/options/storage_memcache.php',
    'ezcCacheStorageMemcachePlain'          => 'Cache/src/storage/memcache/plain.php',
    'ezcCacheStorageMemoryDataStruct'       => 'Cache/src/structs/memory_data.php',
    'ezcCacheStorageMemoryRegisterStruct'   => 'Cache/src/structs/memory_register.php',
    'ezcCacheStorageOptions'                => 'Cache/src/options/storage.php',
);
?>
