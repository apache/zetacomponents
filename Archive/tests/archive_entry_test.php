<?php
/**
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveEntryTest extends ezcTestCase
{
    public function testEntry()
    {
        date_default_timezone_set( "UTC" );

        $tar = ezcArchiveTar::getInstance( dirname( __FILE__) . "/data/tar_ustar_complex.tar" );
        $entry = $tar->getEntry();

        $this->assertEquals("files/bla/", $entry->getPath() );
        $this->assertEquals(1129810752, $entry->getModificationTime() );
        $this->assertEquals("rb", $entry->getUserId() );
        $this->assertEquals("users", $entry->getGroupId() );
        $this->assertEquals(0, $entry->getSize() );
        $this->assertEquals("0000755", $entry->getPermissions() );
        $this->assertEquals("rwxr-xr-x", $entry->getPermissionsString() );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
