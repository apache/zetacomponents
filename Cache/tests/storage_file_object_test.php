<?php
/**
 * ezcCacheStorageFileObjectTest 
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

/**
 * Require parent test class. 
 */
require_once 'storage_test.php';
require_once 'classes/exportable.php';

/**
 * Test suite for ezcStorageFileObject class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileObjectTest extends ezcCacheStorageTest
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testStoreObjectSuccess()
    {
        $originalObj = new ezcCacheTestExportable( 'foo', 23, 42.23 );
        $this->storage->store( 23, $originalObj );
        $restoredObj = $this->storage->restore( 23 );

        $this->assertEquals( $originalObj, $restoredObj );
    }

    public function testStoreObjectFailure()
    {
        $originalObj = new stdClass();
        try
        {
            $this->storage->store( 23, $originalObj );
            $this->fail( "ezcCacheInvalidDataException not thrown on attempt to store stdClass." );
        }
        catch ( ezcCacheInvalidDataException $e ) {}
    }
}
?>
