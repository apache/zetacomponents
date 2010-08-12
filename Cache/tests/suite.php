<?php
/**
 * ezcCacheSuite
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
 * @subpackage Tests
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'manager_test.php';

require_once 'storage_options_test.php';

require_once 'storage_file_test.php';
require_once 'storage_file_options_test.php';
require_once 'storage_file_array_test.php';
require_once 'storage_file_object_test.php';
require_once 'storage_file_evalarray_test.php';
require_once 'storage_file_plain_test.php';

require_once 'storage_apc_array_test.php';
require_once 'storage_apc_plain_test.php';

require_once 'backend_memcache_test.php';
require_once 'storage_memcache_plain_test.php';

require_once 'stack_options_test.php';
require_once 'stack_test.php';
require_once 'complex_stack_test.php';
require_once 'stack_storage_configuration_test.php';

require_once 'lru_meta_data_test.php';
require_once 'lfu_meta_data_test.php';

require_once 'replacement_strategy_lru_test.php';
require_once 'replacement_strategy_lfu_test.php';

/**
 * Test suite for Cache package. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Cache" );
        
        $this->addTest( ezcCacheStackTest::suite() );
        $this->addTest( ezcCacheComplexCacheTest::suite() );

        $this->addTest( ezcCacheStorageFileOptionsTest::suite() );

        $this->addTest( ezcCacheStorageOptionsTest::suite() );

        $this->addTest( ezcCacheStorageFileTest::suite() );
        $this->addTest( ezcCacheStorageFileArrayTest::suite() );
        $this->addTest( ezcCacheStorageFileObjectTest::suite() );
        $this->addTest( ezcCacheStorageFileEvalArrayTest::suite() );
        $this->addTest( ezcCacheStorageFilePlainTest::suite() );

        $this->addTest( ezcCacheStorageApcPlainTest::suite() );
        $this->addTest( ezcCacheStorageFileApcArrayTest::suite() );

        $this->addTest( ezcCacheMemcacheBackendTest::suite() );
        $this->addTest( ezcCacheStorageMemcachePlainTest::suite() );

        $this->addTest( ezcCacheManagerTest::suite() );

        $this->addTest( ezcCacheStackOptionsTest::suite() );
        $this->addTest( ezcCacheStackStorageConfigurationTest::suite() );

        $this->addTest( ezcCacheStackLruMetaDataTest::suite() );
        $this->addTest( ezcCacheStackLfuMetaDataTest::suite() );
        $this->addTest( ezcCacheStackLruReplacementStrategyTest::suite() );
        $this->addTest( ezcCacheStackLfuReplacementStrategyTest::suite() );
    }

    public static function suite()
    {
        return new ezcCacheSuite( "ezcCacheSuite" );
    }
}
?>
