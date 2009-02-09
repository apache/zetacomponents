<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

/**
 * Test the XML definition reader.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchXmlDefinitionManager extends ezcTestCase
{
    public function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'testfiles' . DIRECTORY_SEPARATOR;
    }

    public function testCanNotFindDefinitionFile()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        try
        {
            $d = $m->fetchDefinition( 'doesNotExist' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionNotFoundException $e )
        {
            self::assertEquals( "Could not find the XML definition file for 'doesNotExist' at '{$this->testFilesDir}doesnotexist.xml'.", $e->getMessage() );
        }
    }

    public function testCanNotFindDefinitionFileWithoutDirSlash()
    {
        $m = new ezcSearchXmlManager( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'testfiles' );
        try
        {
            $d = $m->fetchDefinition( 'doesNotExist' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionNotFoundException $e )
        {
            self::assertEquals( "Could not find the XML definition file for 'doesNotExist' at '{$this->testFilesDir}doesnotexist.xml'.", $e->getMessage() );
        }
    }

    public function testBrokenXml()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        try
        {
            $d = $m->fetchDefinition( 'Invalid' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The XML definition file for 'Invalid' at '{$this->testFilesDir}invalid.xml' is invalid (Invalid XML).", $e->getMessage() );
        }
    }

    public function testMissingIdProperty()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        try
        {
            $d = $m->fetchDefinition( 'MissingID' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The XML definition file for 'MissingID' at '{$this->testFilesDir}missingid.xml' is invalid (Missing ID property).", $e->getMessage() );
        }
    }

    public function testDuplicateIdProperty()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        try
        {
            $d = $m->fetchDefinition( 'DuplicateID' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The XML definition file for 'DuplicateID' at '{$this->testFilesDir}duplicateid.xml' is invalid (Duplicate ID property).", $e->getMessage() );
        }
    }

    public function testUnknownType()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        try
        {
            $d = $m->fetchDefinition( 'UnknownType' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The XML definition file for 'UnknownType' at '{$this->testFilesDir}unknowntype.xml' is invalid (Unknown type: unknown).", $e->getMessage() );
        }
    }

    public function testReadDefinition()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        $d = $m->fetchDefinition( 'Article' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published', 'author' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( true, $d->fields['body']->highlight );
        self::assertEquals( false, $d->fields['summary']->highlight );

        self::assertEquals( true, $d->fields['author']->multi );
        self::assertEquals( false, $d->fields['summary']->multi );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );
    }

    public function testReadDefinitionFromCache()
    {
        $m = new ezcSearchXmlManager( $this->testFilesDir );
        $e = $m->fetchDefinition( 'Article' );
        $d = $m->fetchDefinition( 'Article' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published', 'author' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( true, $d->fields['body']->highlight );
        self::assertEquals( false, $d->fields['summary']->highlight );

        self::assertEquals( true, $d->fields['author']->multi );
        self::assertEquals( false, $d->fields['summary']->multi );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );

        self::assertSame( $e, $d );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchXmlDefinitionManager" );
    }
}
?>
