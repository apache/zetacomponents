<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
        self::assertEquals( 'ezcDbSchemaOracleReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'oracle' ) );
        self::assertEquals( 'ezcDbSchemaPgsqlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'pgsql' ) );
        self::assertEquals( 'ezcDbSchemaSqliteReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'sqlite' ) );
        self::assertEquals( 'ezcDbSchemaXmlReader', ezcDbSchemaHandlerManager::getReaderByFormat( 'xml' ) );
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
            self::assertEquals( 'There is no <read> handler available for the <bogus> format.', $e->getMessage() );
        }
    }

    public function testSupportedFormats1()
    {
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml' ), $formats );
    }

    public function testSupportedFormats2()
    {
        ezcDbSchemaHandlerManager::addReader( 'test1', 'TestSchemaReaderImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1' ), $formats );
    }

    public function testSupportedFormats3()
    {
        ezcDbSchemaHandlerManager::addWriter( 'test1', 'TestSchemaWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1' ), $formats );
    }

    public function testSupportedFormats4()
    {
        ezcDbSchemaHandlerManager::addReader( 'test1', 'TestSchemaReaderImplementation' );
        ezcDbSchemaHandlerManager::addWriter( 'test1', 'TestSchemaWriterImplementation' );
        $formats = ezcDbSchemaHandlerManager::getSupportedFormats();
        self::assertEquals( array( 'array', 'mysql', 'oracle', 'pgsql', 'sqlite', 'xml', 'test1' ), $formats );
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
            $this->assertEquals( "Class <fooBar> does not exist, or does not implement the <ezcDbSchemaReader> interface.", $e->getMessage() );
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
            $this->assertEquals( "Class <stdClass> does not exist, or does not implement the <ezcDbSchemaReader> interface.", $e->getMessage() );
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
            $this->assertEquals( "Class <fooBar> does not exist, or does not implement the <ezcDbSchemaWriter> interface.", $e->getMessage() );
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
            $this->assertEquals( "Class <stdClass> does not exist, or does not implement the <ezcDbSchemaWriter> interface.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new ezcTestSuite( 'ezcDatabaseSchemaHandlerManagerTest' );
    }
}
?>
