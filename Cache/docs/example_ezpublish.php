<?php
/**
 * General example for the Cache component.
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
 * @package Cache
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
