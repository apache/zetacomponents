<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

require_once 'Search/tests/testfiles/test-classes.php';

/**
 * Test the XML definition reader.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchEmbeddedDefinitionManager extends ezcTestCase
{
    public function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
    }

    public function testMissingIdProperty()
    {
        $m = new ezcSearchEmbeddedManager();
        try
        {
            $d = $m->fetchDefinition( 'MissingID' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The embedded definition file for 'MissingID' is invalid (Missing ID property).", $e->getMessage() );
        }
    }

    public function testDefinitionProviderNotImplemented()
    {
        $m = new ezcSearchEmbeddedManager();
        try
        {
            $d = $m->fetchDefinition( 'UnknownType' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDoesNotProvideDefinitionException $e )
        {
            self::assertEquals( "The class 'UnknownType' does not implement the ezcSearchDefinitionProvider interface.", $e->getMessage() );
        }
    }

    public function testReadDefinition()
    {
        $m = new ezcSearchEmbeddedManager();
        $d = $m->fetchDefinition( 'EmbeddedArticle' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );
    }

    public function testReadDefinitionFromCache()
    {
        $m = new ezcSearchEmbeddedManager();
        $e = $m->fetchDefinition( 'EmbeddedArticle' );
        $d = $m->fetchDefinition( 'EmbeddedArticle' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );

        self::assertSame( $e, $d );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchEmbeddedDefinitionManager" );
    }
}
?>
