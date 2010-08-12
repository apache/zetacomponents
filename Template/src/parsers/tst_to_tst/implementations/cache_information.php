<?php
/**
 * File containing the ezcTemplateFetchCacheInformation class
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
 * @package Template
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */
/**
 * Checks if the templates uses some sort of caching.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateFetchCacheInformation extends ezcTemplateTstWalker
{
    public $cacheTst = null;

    public $cacheTemplate = false;
    public $cacheKeys = array();
    public $hasTTL = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function visitCacheTstNode( ezcTemplateCacheTstNode $node )
    {
        $this->cacheTemplate = true;
        $this->cacheTst = $node;

        foreach ( $node->keys as $key )
        {
            $this->cacheKeys[] = $key;
        }

        // And translate the ttl.
        if ( $node->ttl != null ) 
        {
            $this->hasTTL = true;
        }
    }
}
?>
