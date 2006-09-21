<?php
/**
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseTest extends ezcTestCase
{
    /*
     * For use with the method testInvalidClass().
     */
    private $errorMessage = null;

    public function testConfigExceptionUnknownSetting()
    {
        try
        {
            throw new ezcBaseSettingNotFoundException( 'broken' );
        }
        catch ( ezcBaseSettingNotFoundException $e )
        {
            $this->assertEquals( "The setting <broken> is not a valid configuration setting.", $e->getMessage() );
        }
    }

    public function testConfigExceptionOutOfRange1()
    {
        try
        {
            throw new ezcBaseSettingValueException( 'broken', 42 );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            $this->assertEquals( "The value <42> that you were trying to assign to setting <broken> is invalid.", $e->getMessage() );
        }
    }

    public function testConfigExceptionOutOfRange2()
    {
        try
        {
            throw new ezcBaseSettingValueException( 'broken', 42, "int, 40 - 48" );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            $this->assertEquals( "The value <42> that you were trying to assign to setting <broken> is invalid. Allowed values are: int, 40 - 48", $e->getMessage() );
        }
    }

    public function testFileIoException1()
    {
        try
        {
            throw new ezcBaseFileIoException( 'testfile.php', ezcBaseFileException::READ );
        }
        catch ( ezcBaseFileIoException $e )
        {
            $this->assertEquals( "An error occurred while reading from <testfile.php>.", $e->getMessage() );
        }
    }

    public function testFileIoException2()
    {
        try
        {
            throw new ezcBaseFileIoException( 'testfile.php', ezcBaseFileException::WRITE );
        }
        catch ( ezcBaseFileIoException $e )
        {
            $this->assertEquals( "An error occurred while writing to <testfile.php>.", $e->getMessage() );
        }
    }

    public function testFileIoException3()
    {
        try
        {
            throw new ezcBaseFileIoException( 'testfile.php', ezcBaseFileException::WRITE, "Extra extra" );
        }
        catch ( ezcBaseFileIoException $e )
        {
            $this->assertEquals( "An error occurred while writing to <testfile.php>. (Extra extra)", $e->getMessage() );
        }
    }

    public function testFileNotFoundException1()
    {
        try
        {
            throw new ezcBaseFileNotFoundException( 'testfile.php' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file <testfile.php> could not be found.", $e->getMessage() );
        }
    }

    public function testFileNotFoundException2()
    {
        try
        {
            throw new ezcBaseFileNotFoundException( 'testfile.php', 'INI' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The INI file <testfile.php> could not be found.", $e->getMessage() );
        }
    }

    public function testFileNotFoundException3()
    {
        try
        {
            throw new ezcBaseFileNotFoundException( 'testfile.php', 'INI', "Extra extra" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The INI file <testfile.php> could not be found. (Extra extra)", $e->getMessage() );
        }
    }

    public function testFilePermissionException1()
    {
        try
        {
            throw new ezcBaseFilePermissionException( 'testfile.php', ezcBaseFileException::READ );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file <testfile.php> can not be opened for reading.", $e->getMessage() );
        }
    }

    public function testFilePermissionException2()
    {
        try
        {
            throw new ezcBaseFilePermissionException( 'testfile.php', ezcBaseFileException::WRITE );
        }
        catch ( ezcBaseFileException $e )
        {
            $this->assertEquals( "The file <testfile.php> can not be opened for writing.", $e->getMessage() );
        }
    }

    public function testFilePermissionException3()
    {
        try
        {
            throw new ezcBaseFilePermissionException( 'testfile.php', ezcBaseFileException::EXECUTE );
        }
        catch ( ezcBaseException $e )
        {
            $this->assertEquals( "The file <testfile.php> can not be executed.", $e->getMessage() );
        }
    }

    public function testFilePermissionException4()
    {
        try
        {
            throw new ezcBaseFilePermissionException( 'testfile.php', ezcBaseFilePermissionException::CHANGE, "Extra extra" );
        }
        catch ( ezcBaseException $e )
        {
            $this->assertEquals( "The permissions for <testfile.php> can not be changed. (Extra extra)", $e->getMessage() );
        }
    }

    public function testFilePermissionException5()
    {
        try
        {
            throw new ezcBaseFilePermissionException( 'testfile.php', ezcBaseFilePermissionException::READ | ezcBaseFilePermissionException::WRITE, "Extra extra" );
        }
        catch ( ezcBaseException $e )
        {
            $this->assertEquals( "The file <testfile.php> can not be opened for reading and writing. (Extra extra)", $e->getMessage() );
        }
    }

    public function testPropertyNotFoundException()
    {
        try
        {
            throw new ezcBasePropertyNotFoundException( 'broken' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name <broken>.", $e->getMessage() );
        }
    }

    public function testPropertyPermissionException1()
    {
        try
        {
            throw new ezcBasePropertyPermissionException( 'broken', ezcBasePropertyPermissionException::READ );
        }
        catch ( ezcBaseException $e )
        {
            $this->assertEquals( "The property <broken> is read-only.", $e->getMessage() );
        }
    }

    public function testPropertyPermissionException2()
    {
        try
        {
            throw new ezcBasePropertyPermissionException( 'broken', ezcBasePropertyPermissionException::WRITE );
        }
        catch ( ezcBaseException $e )
        {
            $this->assertEquals( "The property <broken> is write-only.", $e->getMessage() );
        }
    }

    public function testBaseValue1()
    {
        try
        {
            throw new ezcBaseValueException( 'broken', array( 42 ) );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value <a:1:{i:0;i:42;}> that you were trying to assign to setting <broken> is invalid.", $e->getMessage() );
        }
    }

    public function testBaseValue2()
    {
        try
        {
            throw new ezcBaseValueException( 'broken', "string", "strings" );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value <string> that you were trying to assign to setting <broken> is invalid. Allowed values are: strings.", $e->getMessage() );
            $this->assertEquals( "The value <string> that you were trying to assign to setting <broken> is invalid. Allowed values are: strings.", $e->originalMessage );
        }
    }

    public function testExtraDirNotFoundException()
    {
        try
        {
            ezcBase::addClassRepository( 'wrongDir' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The base directory file <wrongDir> could not be found.", $e->getMessage() );
        }
    }

    public function testExtraDirBaseNotFoundException()
    {
        try
        {
            ezcBase::addClassRepository( '.', './wrongAutoloadDir' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The autoload directory file <./wrongAutoloadDir> could not be found.", $e->getMessage() );
        }
    }
    
    public function testBaseAddAndGetAutoloadDirs1()
    {
        ezcBase::addClassRepository( '.' );
        $resultArray = ezcBase::getRepositoryDirectories();

        if ( count( $resultArray ) != 2 ) 
        {
            $this->fail( "Duplicating or missing extra autoload dirs while adding." );
        }

        $packageDir = realpath( dirname( __FILE__ ) . '/../..' );
        if ( !isset( $resultArray[$packageDir] ) ) 
        {
           $this->fail( "No packageDir found in result of getRepositoryDirectories()" );
        }

        if ( !isset( $resultArray['.'] ) || $resultArray['.'][1] != './autoload' )
        {
            $this->fail( "Extra autoload dir <{$resultArray['.'][1]}> is added incorrectly" );
        }
    }

    public function testBaseAddAndGetAutoloadDirs2()
    {
        ezcBase::addClassRepository( '.', './autoload' );
        ezcBase::addClassRepository( './Base/tests/test_repository', './Base/tests/test_repository/autoload_files' );
        ezcBase::addClassRepository( './Base/tests/test_repository', './Base/tests/test_repository/autoload_files' );
        $resultArray = ezcBase::getRepositoryDirectories();

        if ( count( $resultArray ) != 3 ) 
        {
            $this->fail( "Duplicating or missing extra autoload dirs while adding." );
        }

        $packageDir = realpath( dirname( __FILE__ ) . '/../..' );
        if ( !isset( $resultArray[$packageDir] ) ) 
        {
           $this->fail( "No packageDir found in result of getRepositoryDirectories()" );
        }

        if ( !isset( $resultArray['./Base/tests/test_repository'] ) || $resultArray['./Base/tests/test_repository'][1] != './Base/tests/test_repository/autoload_files' )
        {
            $this->fail( "Extra autoload dir <{$resultArray['./Base/tests/test_repository'][1]}> is added incorrectly" );
        }

        self::assertEquals( true, class_exists( 'trBasetestClass', true ) );
        self::assertEquals( true, class_exists( 'trBasetestClass2', true ) );
        self::assertEquals( false, @class_exists( 'trBasetestClass3', true ) );
    }

    public function testNoPrefixAutoload()
    {
        ezcBase::addClassRepository( './Base/tests/test_repository', './Base/tests/test_repository/autoload_files' );
        __autoload( 'Object' );
        if( !class_exists( 'Object' ) )
        {
            $this->fail( "Autoload does not handle classes with no prefix" );
        }
    }

    public function testInvalidClass()
    {
        set_error_handler( array( $this, "ErrorHandlerTest" ) );
        self::assertEquals( false, @class_exists( 'ezcNoSuchClass', true ) );
        $dirs = ezcBase::getRepositoryDirectories();
        $paths = array();
        foreach ( $dirs as $dir )
        {
            $paths[] = realpath( $dir[1] );
        }
        $expectedErrorMessage = "Could not find a 'ezcNoSuchClass' class to file mapping. Searched for no_such_autoload.php and no_autoload.php in: ";
        $expectedErrorMessage .= implode( ', ', $paths );
        self::assertEquals( $expectedErrorMessage, $this->errorMessage );
        restore_error_handler();
    }

    // For trigger_error test from testInvalidClass().
    public function ErrorHandlerTest( $errno, $errstr, $errfile, $errline )
    {
        $this->errorMessage = $errstr;
    }
    
    public static function suite()
    {
        return new ezcTestSuite("ezcBaseTest");
    }
}
?>
