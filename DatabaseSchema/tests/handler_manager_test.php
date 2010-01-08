<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

/**
 * Require schema reader/writer implementation for tests
 */
require 'testfiles/schema-handler-implementations.php';

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaHandlerManagerTest extends ezcTestCase
{
    public function testGetReaderByFormat1()
    {
        self::assertEquals( 'ezcDbSchemaPhpArrayReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'array' ) );
        self::assertEquals( 'ezcDbSchemaMysqlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'mysql' ) );
        self::assertEquals( 'ezcDbSchemaPgsqlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'pgsql' ) );
        self::assertEquals( 'ezcDbSchemaSqliteReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'sqlite' ) );
        self::assertEquals( 'ezcDbSchemaOracleReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'oracle' ) );
        self::assertEquals( 'ezcDbSchemaXmlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'xml' ) );
    }

    public function testGetWriterByFormat1()
    {
        self::assertEquals( 'ezcDbSchemaPhpArrayWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'array' ) );
        self::assertEquals( 'ezcDbSchemaMysqlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'mysql' ) );
        self::assertEquals( 'ezcDbSchemaPgsqlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'pgsql' ) );
        self::assertEquals( 'ezcDbSchemaSqliteWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'sqlite' ) );
        self::assertEquals( 'ezcDbSchemaOracleWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'oracle' ) );
        self::assertEquals( 'ezcDbSchemaXmlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'xml' ) );
    }

    public function testGetDiffReaderByFormat1()
    {
        self::assertEquals( 'ezcDbSchemaPhpArrayReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'array' ) );
        self::assertEquals( 'ezcDbSchemaMysqlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'mysql' ) );
        self::assertEquals( 'ezcDbSchemaPgsqlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'pgsql' ) );        
        self::assertEquals( 'ezcDbSchemaSqliteReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'sqlite' ) );
        self::assertEquals( 'ezcDbSchemaOracleReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'oracle' ) );
        self::assertEquals( 'ezcDbSchemaXmlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'xml' ) );
    }

    public function testGetDiffWriterByFormat1()
    {
        self::assertEquals( 'ezcDbSchemaPhpArrayWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'array' ) );
        self::assertEquals( 'ezcDbSchemaMysqlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'mysql' ) );
        self::assertEquals( 'ezcDbSchemaPgsqlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'pgsql' ) );
        self::assertEquals( 'ezcDbSchemaSqliteWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'sqlite' ) );        
        self::assertEquals( 'ezcDbSchemaOracleWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'oracle' ) );
        self::assertEquals( 'ezcDbSchemaXmlWriter', ezcDbSchemaHandlerManager::getWriterByFormat( 'xml' ) );
    }

    public function testGetReaderByFormatException()
    {
        try
        {
            $name = ezcDbSchemaHandlerManager::getReaderByFormat( 'bogus' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'read' handler available for the 'bogus' format.", $e->getMessage() );
        }
    }

    public function testGetWriterByFormatException()
    {
        try
        {
            $name = ezcDbSchemaHandlerManager::getWriterByFormat( 'bogus' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'write' handler available for the 'bogus' format.", $e->getMessage() );
        }
    }

    public function testGetDiffReaderByFormatException()
    {
        try
        {
            $name = ezcDbSchemaHandlerManager::getDiffReaderByFormat( 'bogus' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference read' handler available for the 'bogus' format.", $e->getMessage() );
        }
    }

    public function testGetDiffWriterByFormatException()
    {
        try
        {
            $name = ezcDbSchemaHandlerManager::getDiffWriterByFormat( 'bogus' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference write' handler available for the 'bogus' format.", $e->getMessage() );
        }
    }

    public function testSupportedFormats1()
    {
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'persistent' ), $formats );
    }

    public function testSupportedFormats2()
    {
        ezcDbSchemaHandlerManager::addReader( 'test1', 'TestSchemaReaderImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1', 'persistent' ), $formats );
    }

    public function testSupportedFormats3()
    {
        ezcDbSchemaHandlerManager::addWriter( 'test1', 'TestSchemaWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1', 'persistent' ), $formats );
    }

    public function testSupportedFormats4()
    {
        ezcDbSchemaHandlerManager::addReader( 'test1', 'TestSchemaReaderImplementation' );
        ezcDbSchemaHandlerManager::addWriter( 'test1', 'TestSchemaWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1', 'persistent' ), $formats );
    }

    public function testSupportedDiffFormats1()
    {
        $formats = ezcDbSchemaHandlerManager::getSupportedDiffFormats();
        self::assertEquals( array( 'array', 'xml', 'mysql', 'oracle', 'pgsql', 'sqlite' ), $formats );
    }

    public function testSupportedDiffFormats2()
    {
        ezcDbSchemaHandlerManager::addDiffReader( 'test1', 'TestSchemaDiffReaderImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedDiffFormats();
        self::assertEquals( array( 'array', 'xml', 'test1', 'mysql', 'oracle', 'pgsql', 'sqlite' ), $formats );
    }

    public function testSupportedDiffFormats3()
    {
        ezcDbSchemaHandlerManager::addDiffWriter( 'test1', 'TestSchemaDiffWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedDiffFormats();
        self::assertEquals( array( 'array', 'xml', 'test1', 'mysql', 'oracle', 'pgsql', 'sqlite' ), $formats );
    }

    public function testSupportedDiffFormats4()
    {
        ezcDbSchemaHandlerManager::addDiffReader( 'test1', 'TestSchemaDiffReaderImplementation' );
        ezcDbSchemaHandlerManager::addDiffWriter( 'test1', 'TestSchemaDiffWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedDiffFormats();
        self::assertEquals( array( 'array', 'xml', 'test1', 'mysql', 'oracle', 'pgsql', 'sqlite' ), $formats );
    }

    public function testWrongReaderClass1()
    {
        try
        {
            @ezcDbSchemaHandlerManager::addReader( 'dummy', 'fooBar' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidReaderClassException $e )
        {
            $this->assertEquals( "Class 'fooBar' does not exist, or does not implement the 'ezcDbSchemaReader' interface.", $e->getMessage() );
        }
    }

    public function testWrongReaderClass2()
    {
        try
        {
            ezcDbSchemaHandlerManager::addReader( 'dummy', 'stdClass' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidReaderClassException $e )
        {
            $this->assertEquals( "Class 'stdClass' does not exist, or does not implement the 'ezcDbSchemaReader' interface.", $e->getMessage() );
        }
    }

    public function testWrongWriterClass1()
    {
        try
        {
            @ezcDbSchemaHandlerManager::addWriter( 'dummy', 'fooBar' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidWriterClassException $e )
        {
            $this->assertEquals( "Class 'fooBar' does not exist, or does not implement the 'ezcDbSchemaWriter' interface.", $e->getMessage() );
        }
    }

    public function testWrongWriterClass2()
    {
        try
        {
            ezcDbSchemaHandlerManager::addWriter( 'dummy', 'stdClass' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidWriterClassException $e )
        {
            $this->assertEquals( "Class 'stdClass' does not exist, or does not implement the 'ezcDbSchemaWriter' interface.", $e->getMessage() );
        }
    }

    public function testWrongDiffReaderClass1()
    {
        try
        {
            @ezcDbSchemaHandlerManager::addDiffReader( 'dummy', 'fooBar' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidDiffReaderClassException $e )
        {
            $this->assertEquals( "Class 'fooBar' does not exist, or does not implement the 'ezcDbSchemaDiffReader' interface.", $e->getMessage() );
        }
    }

    public function testWrongDiffReaderClass2()
    {
        try
        {
            ezcDbSchemaHandlerManager::addDiffReader( 'dummy', 'stdClass' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidDiffReaderClassException $e )
        {
            $this->assertEquals( "Class 'stdClass' does not exist, or does not implement the 'ezcDbSchemaDiffReader' interface.", $e->getMessage() );
        }
    }

    public function testWrongDiffWriterClass1()
    {
        try
        {
            @ezcDbSchemaHandlerManager::addDiffWriter( 'dummy', 'fooBar' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidDiffWriterClassException $e )
        {
            $this->assertEquals( "Class 'fooBar' does not exist, or does not implement the 'ezcDbSchemaDiffWriter' interface.", $e->getMessage() );
        }
    }

    public function testWrongDiffWriterClass2()
    {
        try
        {
            ezcDbSchemaHandlerManager::addDiffWriter( 'dummy', 'stdClass' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcDbSchemaInvalidDiffWriterClassException $e )
        {
            $this->assertEquals( "Class 'stdClass' does not exist, or does not implement the 'ezcDbSchemaDiffWriter' interface.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaHandlerManagerTest' );
    }
}
?>
