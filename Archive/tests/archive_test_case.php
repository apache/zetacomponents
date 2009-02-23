<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
