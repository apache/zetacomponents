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
 * Test the query tokenizer and builder
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchBuildSearchQueryTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchBuildSearchQueryTest" );
    }

	public static function testOneWord()
	{
		$result = BuildQueryQuery::tokenize( 'word' );
		$expected = array( new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'word' ) );
		self::assertEquals( $expected, $result );
	}

	public static function testMoreWords()
	{
		$result = BuildQueryQuery::tokenize( "I'll be back" );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, "I'll" ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'be' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'back' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testAnd()
	{
		$result = BuildQueryQuery::tokenize( "me AND you" );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'me' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_AND, 'AND' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'you' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testOr()
	{
		$result = BuildQueryQuery::tokenize( "me OR you" );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'me' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_OR, 'OR' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'you' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testWordsInQuotes()
	{
		$result = BuildQueryQuery::tokenize( '"The world is not enough"' );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::QUOTE, '"' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'The' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'world' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'is' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'not' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'enough' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::QUOTE, '"' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testPlusMinus()
	{
		$result = BuildQueryQuery::tokenize( '+plus -minus' );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::PLUS, '+' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'plus' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::MINUS, '-' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'minus' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testBraces()
	{
		$result = BuildQueryQuery::tokenize( 'a OR (b AND c)' );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'a' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_OR, 'OR' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::BRACE_OPEN, '(' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'b' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_AND, 'AND' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'c' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::BRACE_CLOSE, ')' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testColon()
	{
		$result = BuildQueryQuery::tokenize( 'site:ezcomponents.org' );
		$expected = array(
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'site' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::COLON, ':' ),
			new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'ezcomponents.org' ),
		);
		self::assertEquals( $expected, $result );
	}

	public static function testAddOneWordOneField()
	{
		$h = new TestHandler;
		$d = new ezcSearchDocumentDefinition( 'DefinitionOneField' );
		$d->fields['fieldOne'] = new ezcSearchDefinitionDocumentField( 'fieldOne' );
		$q = new ezcSearchQuerySolr( $h, $d );
		ezcSearchQueryBuilder::buildSearchQuery( $q, 'word', array( 'fieldOne' ) );
		self::assertSame( array( "fieldOne_t:word" ), $q->whereClauses );
		echo $q->getQuery();
	}

}

class TestHandler extends ezcSearchSolrHandler
{
    public function __construct( $host = 'localhost', $port = 8983, $location = '/solr' )
	{
	}
}

class BuildQueryQuery extends ezcSearchQueryBuilder
{
	public static function tokenize( $string )
	{
		return parent::tokenize( $string );
	}
}

?>

