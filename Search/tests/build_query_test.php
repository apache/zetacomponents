<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

require_once 'testfiles/test-classes.php';

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

    public static function testAnd1()
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
    
    public static function testAnd2()
    {
        $result = BuildQueryQuery::tokenize( "me and you" );
        $expected = array(
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'me' ),
            new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
            new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_AND, 'and' ),
            new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'you' ),
        );
        self::assertEquals( $expected, $result );
    }

    public static function testOr1()
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

    public static function testOr2()
    {
        $result = BuildQueryQuery::tokenize( "me or you" );
        $expected = array(
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'me' ),
            new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
            new ezcSearchQueryToken( ezcSearchQueryToken::LOGICAL_OR, 'or' ),
            new ezcSearchQueryToken( ezcSearchQueryToken::SPACE, " " ),
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'you' ),
        );
        self::assertEquals( $expected, $result );
    }

    public static function testInternalAnd()
    {
        $result = BuildQueryQuery::tokenize( "meANDyou" );
        $expected = array(
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'meANDyou' ),
        );
        self::assertEquals( $expected, $result );
    }

    public static function testInternalOr()
    {
        $result = BuildQueryQuery::tokenize( "meORyou" );
        $expected = array(
            new ezcSearchQueryToken( ezcSearchQueryToken::STRING, 'meORyou' ),
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
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'goldfinger', array( 'fieldOne' ) );
        self::assertSame( array( "fieldOne_t:goldfinger" ), $q->whereClauses );
    }

    public static function testAddOneWordTwoField()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'thunderball', array( 'fieldOne', 'fieldTwo' ) );
        self::assertSame( array( "( fieldOne_t:thunderball OR fieldTwo_t:thunderball )" ), $q->whereClauses );
    }

    public static function testAddMoreWordsOneField()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'from russia with love', array( 'fieldOne' ) );
        self::assertSame( array( "fieldOne_t:from", "fieldOne_t:russia", "fieldOne_t:with", "fieldOne_t:love" ), $q->whereClauses );
    }

    public static function testAddMoreWordsTwoField()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'you only live twice', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            "( fieldOne_t:you OR fieldTwo_t:you )",
            "( fieldOne_t:only OR fieldTwo_t:only )",
            "( fieldOne_t:live OR fieldTwo_t:live )",
            "( fieldOne_t:twice OR fieldTwo_t:twice )",
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testAddOnePhraseOneField()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"diamonds are forever"', array( 'fieldOne' ) );
        self::assertSame( array( 'fieldOne_t:"diamonds are forever"' ), $q->whereClauses );
    }

    public static function testAddOnePhraseTwoField()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"live and let die"', array( 'fieldOne', 'fieldTwo' ) );
        self::assertSame( array( '( fieldOne_t:"live and let die" OR fieldTwo_t:"live and let die" )' ), $q->whereClauses );
    }

    public static function testAddOnePhraseOneFieldMissingQuotes()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        try
        {
            $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"for your eyes only', array( 'fieldOne' ) );
            self::fail( 'Expected exception not-thrown.' );
        }
        catch ( ezcSearchBuildQueryException $e )
        {
            self::assertSame( "Unterminated quotes in query string.", $e->getMessage() );
        }
    }

    public static function testAddMorePhrasesTwoField()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"the man with the golden gun" "the spy who loved me"', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            '( fieldOne_t:"the man with the golden gun" OR fieldTwo_t:"the man with the golden gun" )',
            '( fieldOne_t:"the spy who loved me" OR fieldTwo_t:"the spy who loved me" )',
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testOrMoreWordsOneField()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'cake OR death', array( 'fieldOne' ) );
        self::assertSame( array( '( fieldOne_t:cake OR fieldOne_t:death )' ), $q->whereClauses );
    }

    public static function testOrMoreWordsTwoField()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'cake OR death', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            '( ( fieldOne_t:cake OR fieldTwo_t:cake ) OR ( fieldOne_t:death OR fieldTwo_t:death ) )',
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testMixedAndAndOrWithoutBraces()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        try
        {
            $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'god OR does AND not OR play AND with OR dices', array( 'fieldOne' ) );
            self::fail( 'Expected exception not-thrown.' );
        }
        catch ( ezcSearchBuildQueryException $e )
        {
            self::assertSame( 'You can not mix OR and AND without using "(" and ")".', $e->getMessage() );
        }
    }

    public static function testMixedOrAndAndWithoutBraces()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        try
        {
            $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'I AND don\'t OR believe AND in OR mathematics', array( 'fieldOne' ) );
            self::fail( 'Expected exception not-thrown.' );
        }
        catch ( ezcSearchBuildQueryException $e )
        {
            self::assertSame( 'You can not mix AND and OR without using "(" and ")".', $e->getMessage() );
        }
    }

    public static function testOrMoreWordsTwoFieldWithBraces()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '(cake OR death)', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            '( ( fieldOne_t:cake OR fieldTwo_t:cake ) OR ( fieldOne_t:death OR fieldTwo_t:death ) )',
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testMixedAndAndOrMoreWordsOneFieldWithBraces()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'cake OR (cookies AND death)', array( 'fieldOne' ) );
        $expected = array(
            '( fieldOne_t:cake OR ( fieldOne_t:cookies AND fieldOne_t:death ) )',
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testMixedAndAndOrMoreWordsTwoFieldWithBraces()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'cake OR (cookies AND death)', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            '( ( fieldOne_t:cake OR fieldTwo_t:cake ) OR ( ( fieldOne_t:cookies OR fieldTwo_t:cookies ) AND ( fieldOne_t:death OR fieldTwo_t:death ) ) )',
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testAddMoreWordsOneFieldWithPlus()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'from +russia with love', array( 'fieldOne' ) );
        self::assertSame( array( "fieldOne_t:from", "+fieldOne_t:russia", "fieldOne_t:with", "fieldOne_t:love" ), $q->whereClauses );
    }

    public static function testAddMoreWordsTwoFieldWithMinus()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '-you only live -twice', array( 'fieldOne', 'fieldTwo' ) );
        $expected = array(
            "( !fieldOne_t:you AND !fieldTwo_t:you )",
            "( fieldOne_t:only OR fieldTwo_t:only )",
            "( fieldOne_t:live OR fieldTwo_t:live )",
            "( !fieldOne_t:twice AND !fieldTwo_t:twice )",
        );
        self::assertSame( $expected, $q->whereClauses );
    }

    public static function testSpecialCharsInQuotes()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"Testing+more-less is (good):	not! "', array( 'fieldOne', 'fieldTwo' ) );
        self::assertSame( array( '( fieldOne_t:"Testing+more-less is (good):	not!" OR fieldTwo_t:"Testing+more-less is (good):	not!" )' ), $q->whereClauses );
    }

    // test for issue #14159
    public static function testWithColon1()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"http://blahblah"', array( 'fieldOne' ) );
        self::assertSame( array( 'fieldOne_t:"http://blahblah"' ), $q->whereClauses );
    }

    public static function testWithColon2()
    {
        $q = self::setupQuery( 'DefinitionTwoFields' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, '"http://blahblah"', array( 'fieldOne', 'fieldTwo' ) );
        self::assertSame( array( '( fieldOne_t:"http://blahblah" OR fieldTwo_t:"http://blahblah" )' ), $q->whereClauses );
    }

    // tests for issue #15298
    public static function testAndOnlyWithDelimiters()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'cakeANDdeath', array( 'fieldOne' ) );
        self::assertSame( array( 'fieldOne_t:cakeANDdeath' ), $q->whereClauses );
    }

    public static function testOrdOnlyWithDelimiters()
    {
        $q = self::setupQuery( 'DefinitionOneField' );
        $qb = new ezcSearchQueryBuilder();
        $qb->parseSearchQuery( $q, 'INTERSPORT', array( 'fieldOne' ) );
        self::assertSame( array( 'fieldOne_t:INTERSPORT' ), $q->whereClauses );
    }

    public static function setupQuery( $definition )
    {
        $h = new TestHandler;
        $d = new ezcSearchDocumentDefinition( $definition );
        $d->fields['fieldOne'] = new ezcSearchDefinitionDocumentField( 'fieldOne' );
        if ( $definition == 'DefinitionTwoFields' )
        {
            $d->fields['fieldTwo'] = new ezcSearchDefinitionDocumentField( 'fieldTwo' );
        }
        $d->fields['ezcsearch_type'] = new ezcSearchDefinitionDocumentField( 'type' );
        $q = $h->createFindQuery( 'DefinitionOneField', $d );
        $q->whereClauses = array();
        return $q;
    }
}
?>
