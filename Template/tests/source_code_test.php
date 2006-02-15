<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
class ezcTemplateSourceCodeTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateSourceCodeTest" );
    }

    public function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
        // remove temporarily stored file if possible
        if ( file_exists( $this->templateStorePath . "zhadum.tpl" ) )
            unlink( $this->templateStorePath . "zhadum.tpl" );
        if ( file_exists( $this->templateStorePath . "zhadum.tpl~" ) )
            unlink( $this->templateStorePath . "zhadum.tpl~" );
        if ( file_exists( $this->templateStorePath . "#zhadum.tpl#" ) )
            unlink( $this->templateStorePath . "#zhadum.tpl#" );
    }

    public function tearDown()
    {
        // remove temporarily stored file if possible
        if ( file_exists( $this->templateStorePath . "zhadum.tpl" ) )
            unlink( $this->templateStorePath . "zhadum.tpl" );
        if ( file_exists( $this->templateStorePath . "zhadum.tpl~" ) )
            unlink( $this->templateStorePath . "zhadum.tpl~" );
        if ( file_exists( $this->templateStorePath . "#zhadum.tpl#" ) )
            unlink( $this->templateStorePath . "#zhadum.tpl#" );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl" );

        self::assertSame( $this->templatePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( false, $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( false, $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "you are hereby warned" );

        self::assertSame( $this->templatePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "you are hereby warned", $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test hasCode() with code initialised
     */
    public function testHasCode()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "you are hereby warned" );

        self::assertSame( $this->templatePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "you are hereby warned", $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
        self::assertSame( true, $src->hasCode(), 'Method hasCode() does not return true.' );
    }

    /**
     * Test hasCode() with no code
     */
    public function testHasNoCode()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertSame( $this->templatePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( false, $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
        self::assertSame( false, $src->hasCode(), 'Method hasCode() does not return false.' );
    }

    /**
     * Test isAvailable()
     */
    public function testIsAvailable()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( file_exists( $this->templatePath . "zhadum.tpl" ), 'Template file does not exist on filesystem' );
        self::assertSame( true, $src->isAvailable(), 'Template file is not available while the file exists' );
    }

    /**
     * Test isAvailable()
     */
    public function testIsNotAvailable()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum_no_such_file.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( !file_exists( $this->templatePath . "zhadum_no_such_file.tpl" ), 'Template file exist on filesystem, should not be present' );
        self::assertSame( false, $src->isAvailable(), 'Template file is available while the file does not exists' );
    }

    /**
     * Test isReadable() with readable file
     */
    public function testIsReadable()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( file_exists( $this->templatePath . "zhadum.tpl" ), 'Template file does not exist on filesystem' );
        self::assertTrue( is_readable( $this->templatePath . "zhadum.tpl" ), 'Template file cannot be read' );
        self::assertSame( true, $src->isReadable(), 'Template file is not available while the file exists' );
    }

    /**
     * Test isReadable() with unreadable file
     */
    public function testIsNotReadable()
    {
        // If running as root you can always write, so this test should be
        // skipped when running as root.
        if ( posix_getuid() == 0 )
        {
            return;
        }
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );

        // This only works on Linux/Unix, what to do here on other platforms?
        $old = umask( 0 );
        chmod( $this->templateStorePath . "zhadum.tpl", 0222 );
        umask( $old );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Template file does not exist on filesystem' );
        self::assertTrue( !is_readable( $this->templateStorePath . "zhadum.tpl" ), 'Template file is still readable' );
        self::assertSame( false, $src->isReadable(), 'Unreadable template file is considered readable' );
    }

    /**
     * Test isWriteable() with writeable file
     */
    public function testIsWriteable()
    {
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Template file does not exist on filesystem' );
        self::assertTrue( is_writeable( $this->templateStorePath . "zhadum.tpl" ), 'Template file cannot be written to' );
        self::assertSame( true, $src->isWriteable(), 'Template file is not available while the file exists' );
    }

    /**
     * Test isWriteable() with unwriteable file
     */
    public function testIsNotWriteable()
    {
        // If running as root you can always write, so this test should be
        // skipped when running as root.
        if ( posix_getuid() == 0 )
        {
            return;
        }
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );

        // This only works on Linux/Unix, what to do here on other platforms?
        $old = umask( 0 );
        chmod( $this->templateStorePath . "zhadum.tpl", 0444 );
        umask( $old );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", false );

        self::assertTrue( file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Template file does not exist on filesystem' );
        self::assertTrue( !is_writeable( $this->templateStorePath . "zhadum.tpl" ), 'Template file is still writeable' );
        self::assertSame( false, $src->isWriteable(), 'Unwriteable template file is considered writeable' );
    }

    /**
     * Test loading code from template file
     */
    public function testLoad()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "definitely not the source from the file zhadum.tpl" );

        $src->load();

        self::assertSame( $this->templatePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "A planet far far away.\n{\$planet.name}\n", $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test loading code from template file which does not exist.
     * In this case an exception is expected to be thrown.
     */
    public function testLoadNonExistant()
    {
        $src = new ezcTemplateSourceCode( $this->templatePath . "zhadum_no_such_file.tpl",
                                          "planet:zhadum.tpl", "definitely not the source from the file zhadum.tpl" );

        try
        {
            $src->load();
            self::fail( "No exception thrown for non existant file" );
        }
        catch ( ezcTemplateFileNotFoundException $e )
        {
        }

        self::assertSame( $this->templatePath . "zhadum_no_such_file.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "definitely not the source from the file zhadum.tpl", $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test loading code from template file which does not exist.
     * In this case an exception is expected to be thrown.
     */
    public function testLoadNonReadable()
    {
        // If running as root you can always write, so this test should be
        // skipped when running as root.
        if ( posix_getuid() == 0 )
        {
            return;
        }
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );

        // This only works on Linux/Unix, what to do here on other platforms?
        $old = umask( 0 );
        chmod( $this->templateStorePath . "zhadum.tpl", 0222 );
        umask( $old );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "definitely not the source from the file zhadum.tpl" );

        try
        {
            $src->load();
            self::fail( "No exception thrown for non-readable file" );
        }
        catch ( ezcTemplateFileNotReadableException $e )
        {
        }

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "definitely not the source from the file zhadum.tpl", $src->code, 'Property <code> does not return correct value.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test saving code to template file
     */
    public function testSave()
    {
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "I would not go there if I were you.\nJust a friendly advice.\n" );

        self::assertTrue( !file_exists( $this->templateStorePath . "zhadum.tpl" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> already exists, cannot run test.' );

        $src->save();

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src->stream,
                          'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource,
                          'Property <resource> does not return correct value.' );
        self::assertSame( "I would not go there if I were you.\nJust a friendly advice.\n", $src->code,
                          'Property <code> does not return correct value.' );
        self::assertSame( false, file_exists( $this->templateStorePath . "#zhadum.tpl#" ),
                          'Temporary template file <' . $this->templateStorePath . '#zhadum.tpl#> still exist after save()' );
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( $src->code, file_get_contents( $this->templateStorePath . "zhadum.tpl" ),
                          'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the correct source code.' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );



        // Now try to overwrite the same file, a backup should be made
        $src2 = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                           "planet:zhadum.tpl", "Some new content for the template." );
        $src2->save();

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src2->stream,
                          'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src2->resource,
                          'Property <resource> does not return correct value.' );
        self::assertSame( "Some new content for the template.", $src2->code,
                          'Property <code> does not return correct value.' );

        // check contents
        self::assertSame( false, file_exists( $this->templateStorePath . "#zhadum.tpl#" ),
                          'Temporary template file <' . $this->templateStorePath . '#zhadum.tpl#> still exist after save()' );
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( $src2->code, file_get_contents( $this->templateStorePath . "zhadum.tpl" ),
                          'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the correct source code.' );

        // check contents of backup
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl~" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( $src->code, file_get_contents( $this->templateStorePath . "zhadum.tpl~" ),
                          'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the correct source code.' );


        // Now try to overwrite the same file again, a backup should be made and the old backup removed
        $src3 = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                           "planet:zhadum.tpl", "Some updated content for the template." );
        $src3->save();

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src3->stream,
                          'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src3->resource,
                          'Property <resource> does not return correct value.' );
        self::assertSame( "Some updated content for the template.", $src3->code,
                          'Property <code> does not return correct value.' );

        // check contents
        self::assertSame( false, file_exists( $this->templateStorePath . "#zhadum.tpl#" ),
                          'Temporary template file <' . $this->templateStorePath . '#zhadum.tpl#> still exist after save()' );
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( $src3->code, file_get_contents( $this->templateStorePath . "zhadum.tpl" ),
                          'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the correct source code.' );

        // check contents of backup
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl~" ),
                          'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( $src2->code, file_get_contents( $this->templateStorePath . "zhadum.tpl~" ),
                          'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the correct source code.' );

//        self::assertSame( null, $src2->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test saving code to template file
     */
    public function testSaveNonWriteable()
    {
        // If running as root you can always write, so this test should be
        // skipped when running as root.
        if ( posix_getuid() == 0 )
        {
            return;
        }
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );

        // This only works on Linux/Unix, what to do here on other platforms?
        $old = umask( 0 );
        chmod( $this->templateStorePath . "zhadum.tpl", 0444 );
        umask( $old );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "I would not go there if I were you.\nJust a friendly advice.\n" );

        self::assertTrue( file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist, cannot run save test.' );
        self::assertTrue( !is_writeable( $this->templateStorePath . "zhadum.tpl" ), 'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> should not be writable, cannot run save test.' );

        try
        {
            $src->save();
            self::fail( "No exception thrown for non-writeable file" );
        }
        catch ( ezcTemplateFileNotWriteableException $e )
        {
        }

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "I would not go there if I were you.\nJust a friendly advice.\n", $src->code, 'Property <code> does not return correct value.' );
        self::assertSame( "A planet far far away.\n{\$planet.name}\n", file_get_contents( $src->stream ), 'Original file does no longer contain the correct value.' );
        self::assertSame( true, file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Stored template file <' . $this->templateStorePath . 'zhadum.tpl> does not exist after save()' );
        self::assertSame( "A planet far far away.\n{\$planet.name}\n", file_get_contents( $this->templateStorePath . "zhadum.tpl" ), 'File <' . $this->templateStorePath . 'zhadum.tpl> does not contain the original source code, file was probably written to (which should not happen).' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }

    /**
     * Test deleting a temporary template file
     */
    public function testDelete()
    {
        copy( $this->templatePath . "zhadum.tpl",
              $this->templateStorePath . "zhadum.tpl" );
        $src = new ezcTemplateSourceCode( $this->templateStorePath . "zhadum.tpl",
                                          "planet:zhadum.tpl", "The abyss." );

        self::assertTrue( file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Temporary template file <' . $this->templateStorePath . 'zhadum.tpl> does not exists, copy failed.' );

        $src->delete();

        self::assertSame( $this->templateStorePath . "zhadum.tpl", $src->stream, 'Property <stream> does not return correct value.' );
        self::assertSame( "planet:zhadum.tpl", $src->resource, 'Property <resource> does not return correct value.' );
        self::assertSame( "The abyss.", $src->code, 'Property <code> does not return correct value.' );
        self::assertSame( false, file_exists( $this->templateStorePath . "zhadum.tpl" ), 'Temporary template file <' . $this->templateStorePath . 'zhadum.tpl> still exist, was supposed to be unlinked.' );
        self::assertSame( false, $src->isAvailable(), 'Temporary template file <' . $this->templateStorePath . 'zhadum.tpl> does not return false in isAvailable().' );
//        self::assertSame( null, $src->context, 'Property <context> does not return correct value.' );
    }
}

?>
