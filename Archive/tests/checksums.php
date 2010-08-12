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
class ezcArchiveChecksumTest extends ezcTestCase
{
    public $testString = "abcdefghijklmnopqrstuvwxyz";

    public function testTotalByteValueFromString()
    {
        $crc = ezcArchiveChecksums::getTotalByteValueFromString( $this->testString );
        $this->assertEquals( 2847, $crc );
    }

    public function testTotalByteValueFromFile()
    {
        $this->createTempDir("ezcArchive_" );
        $dir = $this->getTempDir();

        file_put_contents( "$dir/byte_value_file.txt", $this->testString );

        $byteValueExpected = ezcArchiveChecksums::getTotalByteValueFromString( file_get_contents( "$dir/byte_value_file.txt" ) );
        $byteValue = ezcArchiveChecksums::getTotalByteValueFromFile( "$dir/byte_value_file.txt" );

        $this->assertEquals( $byteValueExpected, $byteValue );
    }

    public function testCrc32FromString()
    {
        $crc = ezcArchiveChecksums::getCrc32FromString( $this->testString );
        $this->assertEquals( 1277644989, $crc );
    }

    public function testCrc32FromFile()
    {
        $this->createTempDir("ezcArchive_" );
        $dir = $this->getTempDir();

        file_put_contents( "$dir/crc32file.txt", $this->testString );

        $crcExpected = ezcArchiveChecksums::getCrc32FromString( file_get_contents( "$dir/crc32file.txt" ) );
        $crc = ezcArchiveChecksums::getCrc32FromFile( "$dir/crc32file.txt" );

        $this->assertEquals( $crcExpected, $crc);
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
