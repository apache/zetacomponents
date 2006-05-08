<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package UserInput
 * @subpackage Tests
 */

class ezcFileFindRecursiveTest extends ezcTestCase
{
	public function testRecursive1()
	{
		$expected = array (
			0 => 'File/CREDITS',
			1 => 'File/ChangeLog',
			2 => 'File/DESCRIPTION',
			3 => 'File/design/design.txt',
			4 => 'File/design/file.xml',
			5 => 'File/design/file_operations.png',
			6 => 'File/design/md5.png',
			7 => 'File/design/requirements.txt',
			8 => 'File/src/file.php',
			9 => 'File/src/file_autoload.php',
			10 => 'File/tests/file_find_recursive_test.php',
			11 => 'File/tests/file_remove_recursive_test.php',
			12 => 'File/tests/suite.php',
		);
		self::assertEquals( $expected, ezcFile::findRecursive( "File", array(), array( '@/docs/@', '@svn@', '@\.swp$@' ) ) );
	}

	public function testRecursive2()
	{
		$expected = array (
			0 => './File/CREDITS',
			1 => './File/ChangeLog',
			2 => './File/DESCRIPTION',
			3 => './File/design/design.txt',
			4 => './File/design/file.xml',
			5 => './File/design/file_operations.png',
			6 => './File/design/md5.png',
			7 => './File/design/requirements.txt',
			8 => './File/src/file.php',
			9 => './File/src/file_autoload.php',
			10 => './File/tests/file_find_recursive_test.php',
			11 => './File/tests/file_remove_recursive_test.php',
			12 => './File/tests/suite.php',
		);
		self::assertEquals( $expected, ezcFile::findRecursive( ".", array( '@^\./File/@' ), array( '@/docs/@', '@\.svn@', '@\.swp$@' ) ) );
	}

	public function testRecursive3()
	{
		$expected = array (
			0 => 'File/design/file_operations.png',
			1 => 'File/design/md5.png',
		);
		self::assertEquals( $expected, ezcFile::findRecursive( "File", array( '@\.png$@' ), array( '@\.svn@' ) ) );
	}

	public function testRecursive4()
	{
		$expected = array (
			0 => 'File/design/design.txt',
			1 => 'File/design/file.xml',
			2 => 'File/design/file_operations.png',
			3 => 'File/design/md5.png',
			4 => 'File/design/requirements.txt',
		);
		self::assertEquals( $expected, ezcFile::findRecursive( "File", array( '@/design/@' ), array( '@\.svn@' ) ) );
	}

	public function testRecursive5()
	{
		$expected = array (
			0 => 'File/design/design.txt',
			1 => 'File/design/requirements.txt',
			2 => 'File/src/file.php',
			3 => 'File/src/file_autoload.php',
			4 => 'File/tests/file_find_recursive_test.php',
			5 => 'File/tests/file_remove_recursive_test.php',
			6 => 'File/tests/suite.php',
		);
		self::assertEquals( $expected, ezcFile::findRecursive( "File", array( '@\.(php|txt)$@' ), array( '@/docs/@', '@\.svn@' ) ) );
	}

	public function testRecursive6()
	{
		$expected = array();
		self::assertEquals( $expected, ezcFile::findRecursive( "File", array( '@xxx@' ) ) );
	}

    public static function suite()
    {
         return new ezcTestSuite( "ezcFileFindRecursiveTest" );
    }
}
?>
