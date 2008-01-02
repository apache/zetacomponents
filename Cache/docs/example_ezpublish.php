<?php
/**
 * General example for the Cache component.
 *
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Content view
 */

// Assuming that the ContentView cache has been initialized correctly in the
// index.php:

// First retreive tha cache you want to access from the manager.
$cache = CacheManager::getCache( 'ContentView' );

// Prepare your data identification, use some attributes and a unique ID
$attributes = array(
    'user'      => $user,
    'nodeid'    => $NodeID,
    'offset'    => $Offset,
    'layout'    => $layout,
    'lang'      => $LanguageCode,
    'vmode'     => $ViewMode,
);
$id = getUniqueId( $attributes, $viewParameters );

// Initialize data and try to grep from cache
$data = '';
if ( ( $data = $cache->restore( $id, $attributes ) ) === false ) 
{
    // No data in cache or data has expired. Generate new data...
    // What ever exactly happens to create it in eZp.
    $data = generateMyData();   
    // ... and store it inside the cache
    $cache->store( $id, $attributes, $data );
}
// And that's all! : )
?>
