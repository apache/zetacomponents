<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */

class ezcTemplateFileExceptionTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateFileExceptionTest" );
    }

    /**
     * Test 'file not found' constructor values
     */
    public function testFileNotFound()
    {
        $e = new ezcTemplateFileNotFoundException( 'packages/templates/pagelayout.tpl' );

        self::assertSame( "The requested template file 'packages/templates/pagelayout.tpl' does not exist.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file not readable' constructor values
     */
    public function testFileNotReadable()
    {
        $e = new ezcTemplateFileNotReadableException( '/dev/nvram' );

        self::assertSame( "The requested template file '/dev/nvram' is not readable.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file not writeable' constructor values
     */
    public function testFileNotWriteable()
    {
        $e = new ezcTemplateFileNotWriteableException( '/dev/cdrom' );

        self::assertSame( "The requested template file '/dev/cdrom' is not writeable.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file failed unlink' constructor values
     */
    public function testFileFailedUnlink()
    {
        $e = new ezcTemplateFileFailedUnlinkException( 'index.php' );

        self::assertSame( "Unlinking template file 'index.php' failed.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file failed rename' constructor values
     */
    public function testFileFailedRename()
    {
        $e = new ezcTemplateFileFailedRenameException( 'index.php~', 'index.php' );

        self::assertSame( "Renaming template file from 'index.php~' to 'index.php' failed.", $e->getMessage(),
                          'Exception message is not correct' );
    }
}

?>
