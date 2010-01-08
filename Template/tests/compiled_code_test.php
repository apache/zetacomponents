<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcTemplateCompiledCodeTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateCompiledCodeTest" );
    }

    protected function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';

        // the compiled file should exist
        self::assertTrue( file_exists( $this->templateCompiledPath . "full-14862b79ceaf01443626bd5d564c53e2.php" ),
                          "Compiled file <" . $this->templateCompiledPath . "full-14862b79ceaf01443626bd5d564c53e2.php> is missing." );

        // remove temporarily stored file if possible
        if ( file_exists( $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php" ) )
            unlink( $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php" );
    }

    protected function tearDown()
    {
        // remove temporarily stored file if possible
        if ( file_exists( $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php" ) )
            unlink( $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php" );
    }

    public function testDefault()
    {
        $conf = new ezcTemplateCompiledCode( '8efb', $this->templateCompiledPath . '8efb.php' );
        $this->assertEquals( '8efb',  $conf->identifier );
        $this->assertEquals( $this->templateCompiledPath . '8efb.php', $conf->path );
        $this->assertSame( null, $conf->context );
        $this->assertSame( null, $conf->template);
    }

    /**
     * Check if the path to the compiled file is correct with findCompiled().
     * It runs tests for multiple template files which the path is known beforehand.
     */
    public function testFindCompiled()
    {
        $templates = array( array( 'zhadum.ezt',
                                    $this->templateCompiledPath ."/compiled_templates" . '/xhtml-updqr0/zhadum-d282602de179f8e7b6a24c6d96eb525d.php' ),
                            array( 'pagelayout.ezt',
                                   $this->templateCompiledPath . "/compiled_templates" . '/xhtml-updqr0/pagelayout-ab7f51e3c7e7dab104986ad939256599.php' ) );

        foreach ( $templates as $templateData )
        {
            $template = $templateData[0];
            $path = $templateData[1];

            $context = new ezcTemplateXhtmlContext();
            $t = new ezcTemplate();
            $t->configuration = new ezcTemplateConfiguration( $this->templatePath, $this->templateCompiledPath );
            $code = ezcTemplateCompiledCode::findCompiled( $template,
                                                           $context,
                                                           $t );
            self::assertSame( $path,
                              $code->path,
                              "Total path element does not match expected value." );
        }
    }

    public function testExecuteNoExists()
    {
        $conf = new ezcTemplateCompiledCode( '8efb', $this->templateCompiledPath . '8efb.php' );
        self::assertTrue( !file_exists( $conf->path ), "Compiled file <" . $conf->path . "> should not exist." );
        self::assertSame( false, $conf->isAvailable(), "isAvailable() should return false." );
    }

    public function testExecuteNotReadable()
    {
        // If running as root you can always write, so this test should be
        // skipped when running as root.
        if ( !ezcBaseFeatures::hasFunction("posix_getuid") || posix_getuid() == 0 )
        {
            return;
        }
        copy( $this->templateCompiledPath . "full-14862b79ceaf01443626bd5d564c53e2.php",
              $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php" );

        // This only works on Linux/Unix, what to do here on other platforms?
        $old = umask( 0 );
        chmod( $this->templateStorePath . "full-14862b79ceaf01443626bd5d564c53e2.php", 0222 );
        umask( $old );
        $conf = new ezcTemplateCompiledCode( '14862b79ceaf01443626bd5d564c53e2',
                                             $this->templateStorePath . 'full-14862b79ceaf01443626bd5d564c53e2.php' );
        self::assertTrue( file_exists( $conf->path ), "Compiled file <" . $conf->path . "> should exist." );
        self::assertSame( false, $conf->isValid(), "isValid() should return false." );
    }

    public function testExecuteNoManager()
    {
        $conf = new ezcTemplateCompiledCode( '8efb', $this->templateCompiledPath . '8efb.php' );

        try
        {
            $conf->execute();
            self::fail( "No exception thrown when template is missing" );
        }
        catch ( ezcTemplateNoManagerException $e )
        {
        }
    }

    public function testExecuteNoContext()
    {
        $conf = new ezcTemplateCompiledCode( '8efb', $this->templateCompiledPath . '8efb.php' );
        $conf->template = new ezcTemplate();

        try
        {
            $conf->execute( );
            self::fail( "No exception thrown when context is missing" );
        }
        catch ( ezcTemplateNoOutputContextException $e )
        {
        }
    }

    public function testExecuteInvalidCompiled()
    {
        $conf = new ezcTemplateCompiledCode( '8efb', $this->templateCompiledPath . '8efb.php' );
        $conf->template = new ezcTemplate();
        $conf->context = new ezcTemplateXhtmlContext();

        try
        {
            $conf->execute( );
            self::fail( "No exception thrown when context is missing" );
        }
        catch ( ezcTemplateInvalidCompiledFileException $e )
        {
        }
    }

    public function testCannotReadCompiled()
    {
        if ( ezcBaseFeatures::os() === 'Windows' )
        {
            self::markTestSkipped( 'Test is for non-Windows only - permission system is not the same on Windows.' );
        }

        $temp = $this->createTempDir( "ezcTemplate" );
        file_put_contents( $temp . "/myFile" , "bla" );

        chmod( $temp . "/myFile", 0200 ); // Write only for the owner of the file.

        $conf = new ezcTemplateCompiledCode( '8efb', $temp . "/myFile" ); 
        $conf->template = new ezcTemplate();
        $conf->context = new ezcTemplateXhtmlContext();

        try
        {
            $conf->execute( );
            self::fail( "No exception thrown" );
        }
        catch ( ezcTemplateInvalidCompiledFileException $e )
        {
        }

        $this->removeTempDir();
    }


    public function testExecute()
    {
        $conf = new ezcTemplateCompiledCode( '14862b79ceaf01443626bd5d564c53e2',
                                             $this->templateCompiledPath . 'full-14862b79ceaf01443626bd5d564c53e2.php' );
        $conf->template = new ezcTemplate();
        $conf->context = new ezcTemplateXhtmlContext();

        $conf->execute();
    }
}

?>
