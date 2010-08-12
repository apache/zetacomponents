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
abstract class ezcArchiveTestCase extends ezcTestCase
{
    public function compareDirectories( $expectedDir, $testDir )
    {
        clearstatcache();

        $expectedFileList = $this->scandirRecursive( $expectedDir, "" );
        $testFileList = $this->scandirRecursive( $testDir, "" );

        $this->assertEquals( count( $expectedFileList ), count( $testFileList ), "The amount of files in the archive are different.");

        for ( $i = 0; $i < sizeof( $expectedFileList ); $i++)
        {
            $expFile = $expectedFileList[$i];
            $testFile = $testFileList[$i];

            $this->assertEquals( $expFile, $testFile );

            $expPath = $expectedDir . DIRECTORY_SEPARATOR . $expFile;
            $testPath = $testDir . DIRECTORY_SEPARATOR . $testFile;

            $expStat = stat( $expPath );
            $testStat = stat( $testPath );

            if ( !( is_link( $testFile ) && is_link( $expFile ) ) )
            {
                $this->assertEquals( $expStat["uid"], $testStat["uid"], "Expected same uid: $expPath and $testPath" );
                $this->assertEquals( $expStat["gid"], $testStat["gid"], "Expected same gid: $expPath and $testPath" );
                $this->assertEquals( $expStat["mtime"], $testStat["mtime"], "Expected same mtime: $expPath and $testPath" );
            }

            $this->assertEquals( $expStat["size"], $testStat["size"], "Expected same size: $expPath and $testPath" );
            $this->assertEquals( $expStat["blocks"], $testStat["blocks"], "Expected same blocks: $expPath and $testPath" );
            $this->assertEquals( $expStat["nlink"], $testStat["nlink"], "Expected same links: $expPath and $testPath" );

        }
    }

    public function scandirRecursive($directory, $subDirectory)
    {
        $folderContents = array();
        $directory = realpath($directory). DIRECTORY_SEPARATOR;
        $subDirectory = $subDirectory . DIRECTORY_SEPARATOR;

        foreach (scandir($directory . $subDirectory) as $folderItem)
        {
            if ($folderItem != "." && $folderItem != "..")
            {
                if (is_dir($directory.$subDirectory.$folderItem.DIRECTORY_SEPARATOR))
                {
                    $folderContents = array_merge ($folderContents, $this->scandirRecursive( $directory, $subDirectory.$folderItem) );
                }
                else
                {
                    $folderContents[] = $subDirectory . $folderItem;
                }
            }
        }

        return $folderContents;
    }
}
?>
