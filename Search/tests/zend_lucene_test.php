<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

require 'testfiles/article.php';
require_once 'testfiles/test-classes.php';

/**
 * Test the handler classes.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchSessionZendLuceneTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchSessionZendLuceneTest" );
    }

    public function setUp()
    {
        try
        {
            if ( file_exists( '/tmp/lucene' ) )
            {
                ezcBaseFile::removeRecursive( '/tmp/lucene' );
            }
            mkdir( '/tmp/lucene' );
            $this->backend = new ezcSearchZendLuceneHandler( "/tmp/lucene" );
        }
        catch ( ezcSearchCanNotConnectException $e )
        {
            self::markTestSkipped( 'Couldn\'t open Zend Lucene.' );
        }
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
    }

    public function tearDown()
    {
        $this->backend = null;
    }

    public function testCreateSession()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
    }

    public function testSetProperties()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        self::assertSetPropertyFails( $session, 'definitionManager', array( 'foo' ) );
        self::assertSetPropertyFails( $session, 'handler', array( 'foo' ) );
        self::assertSetPropertyFails( $session, 'doesNotExist', array( 'foo' ) );
    }

    public function testGetProperties()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        self::assertEquals( 'ezcSearchZendLuceneHandler', get_class( $session->handler ) );
        self::assertEquals( 'ezcSearchXmlManager', get_class( $session->definitionManager ) );
        try
        {
            $session->doesNotExist;
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertEquals( "No such property name 'doesNotExist'.", $e->getMessage() );
        }
    }

    public function testBrokenState()
    {
        $a = new Article( null, 'Test Article', 'This is an article to test', 'the body of the article', time() );
        $a->omitStateElement( 'title' );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        try
        {
            $session->index( $a );
            self::fail( 'Expected exeption not thrown.' );
        }
        catch ( ezcSearchIncompleteStateException $e )
        {
            self::assertEquals( "The getState() method did not return any value for the field 'title'.", $e->getMessage() );
        }
    }

    public function testIndexDocument1()
    {
        $a = new Article( null, 'Test Article', 'This is an article to test', 'the body of the article', time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testIndexDocument2()
    {
        $content = file_get_contents( '/home/derick/dev/ezcomponents-web/files/parsed_rst/coding_standards.xml' );
        $a = new Article( null, 'Test Article', 'This is an article to test', $content, time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->beginTransaction();
        for ( $i = 0; $i < 5; $i++ )
        {
            $session->index( $a );
        }
        $session->commit();

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $r = $session->find( $q );
        self::assertEquals( 5, $r->resultCount );
    }

    public function testIndexDocument3()
    {
        $d = file_get_contents( dirname( __FILE__ ) . '/../../../docs/guidelines/implementation.txt' );
        $a = new Article( null, 'Test Article', 'This is Rethans an article to test', $d, time(), array( 'Derick Rethans', 'Legolas Rethans' ) );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'author', 'Legolas Rethans' ) );

        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQuery1()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'body', 'Article' ) )->where( $q->eq( 'title', 'Test' ) );

        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 2, count( $r->documents ) );
        self::assertEquals( true, isset( $r->documents[$a->id]['meta'] ) );
        self::assertEquals( true, isset( $r->documents[$a->id]['meta']['score'] ) );
        self::assertEquals( true, isset( $r->documents[$a->id]['document'] ) );
    }

    public function testCreateFindQueryWithAccent()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is article Eén to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is article twee to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'summary', 'Eén' ) );

        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryJapanese()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'マリコ', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'ソウシ', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'summary', 'ソウ*' ) );

        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryOr()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lOr( $q->eq( 'title', 'Nul' ), $q->eq( 'title', 'Drie' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 0, $r->resultCount );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lOr( $q->eq( 'title', 'Eén' ), $q->eq( 'title', 'Drie' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lOr( $q->eq( 'title', 'Twee' ), $q->eq( 'title', 'Drie' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lOr( $q->eq( 'title', 'Eén' ), $q->eq( 'title', 'Twee' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
    }

    public function testCreateFindQueryOneOr()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lOr( $q->eq( 'title', 'Twee' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryEmptyOr()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        try
        {
            $q->where( $q->lOr() );
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcSearchQueryVariableParameterException $e )
        {
            self::assertEquals( "The method 'lOr' expected at least 1 parameter but none were provided.", $e->getMessage() );
        }
    }

    public function testCreateFindQueryOneAnd()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lAnd( $q->eq( 'title', 'Twee' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryAnd()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->lAnd( $q->eq( 'title', 'Twee' ), $q->eq( 'summary', 'second' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryEmptyAnd()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        try
        {
            $q->where( $q->lAnd() );
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcSearchQueryVariableParameterException $e )
        {
            self::assertEquals( "The method 'lAnd' expected at least 1 parameter but none were provided.", $e->getMessage() );
        }
    }

    public function testCreateFindQueryNot()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->not( $q->eq( 'title', 'Twee' ) ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryImportant()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->important( $q->eq( 'title', 'Twee' ) ) );
        self::assertEquals( "ezcsearch_type:Article AND +title:Twee^2", $q->getQuery() );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
    }

    public function testCreateFindQueryBoost()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->boost( $q->eq( 'title', 'Twee' ), 2.5 ) );
        self::assertEquals( "ezcsearch_type:Article AND title:Twee^2.5",  $q->getQuery() );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryFuzz()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->fuzz( $q->eq( 'title', 'Twee' ) ) );
        self::assertEquals( "ezcsearch_type:Article AND title:Twee^2~", $q->getQuery() );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryFuzzWithFactor()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->fuzz( $q->eq( 'title', 'Twee' ), 0.8 ) );
        self::assertEquals( "ezcsearch_type:Article AND title:Twee^2~0.8", $q->getQuery() );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testCreateFindQueryLimit()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( '4822deec4153d-two', 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $q->limit( 1 );

        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 1, count( $r->documents ) );
        self::assertEquals( '4822deec4153d-one', $r->documents['4822deec4153d-one']['document']->id );
    }

    public function testCreateFindQueryLimitOffset()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( '4822deec4153d-two', 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $q->limit( 1, 1 );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 1, count( $r->documents ) );
        self::assertEquals( '4822deec4153d-two', $r->documents['4822deec4153d-two']['document']->id );
    }

    public function testCreateFindQueryOrderByDefault()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( '4822deec4153d-two', 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $q->limit( 1 );
        $q->orderBy( 'id' );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 1, count( $r->documents ) );
        self::assertEquals( 'Test Article Eén', $r->documents['4822deec4153d-one']['document']->title );
    }

    public function testCreateFindQueryOrderByAsc()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( '4822deec4153d-two', 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $q->limit( 1 );
        $q->orderBy( 'id' );

        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 1, count( $r->documents ) );
        self::assertEquals( 'Test Article Eén', $r->documents['4822deec4153d-one']['document']->title );
    }

    public function testCreateFindQueryOrderByDesc()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );
        $a = new Article( '4822deec4153d-two', 'Test Article Twee', 'This is the second article to test', 'the body of the article', time() );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $q->limit( 1 );
        $q->orderBy( 'title', ezcSearchQueryTools::DESC );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 1, count( $r->documents ) );
        self::assertEquals( 'Test Article Twee', $r->documents['4822deec4153d-two']['document']->title );
    }

    public function testCreateFindQueryWrongField()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( '4822deec4153d-one', 'Test Article Eén', 'This is the first article to test', 'the body of the article', time() - 86400 );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        try
        {
            $q->where( $q->eq( 'wrong-field', 'Article' ) );
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcSearchFieldNotDefinedException $e )
        {
            self::assertEquals( "The document type 'Article' does not define the field 'wrong-field'.", $e->getMessage() );
        }
    }

    public function testCreateFindQueryBetween()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $time1 = 1234714201;
        $time2 = 1234800601;
        $time3 = 1234804201;
        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', $time1, "derick" );
        $session->index( $a );
        $a = new Article( null, 'Test Article Twee', 'This is the second article to test', 'the body of the article', $time2, "alexandru" );
        $session->index( $a );
        $a = new Article( null, 'Test Article Drie', 'This is the third article to test', 'the body of the article', $time3, "derick" );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $timeb1 = 1234800581;
        $timeb2 = 1234807801;
        $q->where( $q->between( 'published', $timeb1, $timeb2 ) );
        $r = $session->find( $q );
        self::assertEquals( 2, $r->resultCount );
        self::assertEquals( 2, count( $r->documents ) );
        self::assertEquals( "q=ezcsearch_type_s%3AArticle+AND+published_l%3A%5B$timeb1+TO+$timeb2%5D&wt=json&df=&fl=score+id_s+title_t+summary_t+published_l+author_s+ezcsearch_type_s+score&start=0&rows=10", $q->getQuery() );
    }

    public function testCreateFindWithPhrase()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );

        $a = new Article( null, 'Test Article Eén', 'This is the first article to test', 'the body of the article', time(), array( "Me", "You", "Everybody" ) );
        $session->index( $a );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Test Article' ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public static function datatypes()
    {
        return array(
            array( 'testId', '<b>test</b>', true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
            array( 'testId', '<b>test</b>', false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
            array( 'test', '<b>test</b>', true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'string', 'test' ),
            array( 'test', '<b>test</b>', false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', 'test' ),
            array( 'test', '<b>test</b>', true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'string', 'tes*' ),
            array( 'test', '<b>test</b>', false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', 'tes*' ),
            array( 'test', '<b>test</b>', false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', '<b>test</b>' ),
            array( 'test', '<b>test</b>', true, -42, -12831e4, "2008-04-23 16:35 Europe/Oslo", 'bool', true ),
            array( 'test', '<b>test</b>', false, -42, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'bool', false ),
            array( 'test', '<b>test</b>', true, -51, -12831e4, "2008-04-23 16:35 Europe/Oslo", 'int', -51 ),
            array( 'test', '<b>test</b>', false, 0, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'int', 0 ),
            array( 'test', '<b>test</b>', false, 913123, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'int', 913123 ),
            array( 'test', '<b>test</b>', true, -51, -12831e4, "2008-04-23 16:35 Europe/Oslo", 'float', -12831e4 ),
            array( 'test', '<b>test</b>', false, 0, 0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'float', 0.42e-9 ),
            array( 'test', '<b>test</b>', false, 913123, 0, "2008-04-23 16:35 Europe/Oslo", 'float', 0 ),
            array( 'test', '<b>test</b>', false, 913123, 0, "2008-04-23 16:35 Europe/Oslo", 'date', "2008-04-23 14:35 GMT" ),
            array( 'test', '<b>test</b>', false, 913123, 0, "2008-04-23 16:35 Europe/Oslo", 'date', "2008-04-23 16:35 Europe/Oslo" ),
        );
    }

    /**
     * @dataProvider datatypes
     */
    public function testDataTypes1( $string, $html, $bool, $int, $float, $date, $findField, $findValue )
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchEmbeddedManager() );

        $a = new DataTypeTest( 'testId', $string, $html, $bool, $int, $float, $date );
        $session->index( $a );
        $q = $session->createFindQuery( 'DataTypeTest' );
        $q->where( $q->eq( $findField, $findValue ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
        self::assertEquals( $string, $r->documents['testId']['document']->string );
        self::assertEquals( $html, $r->documents['testId']['document']->html );
        self::assertEquals( $bool, $r->documents['testId']['document']->bool );
        self::assertEquals( $int, $r->documents['testId']['document']->int );
        self::assertEquals( $float, $r->documents['testId']['document']->float );
        self::assertEquals( date_create( "$date" )->format( '\sU' ), $r->documents['testId']['document']->date->format( '\sU' ) );
    }

    /**
     * @dataProvider datatypes
     */
    /*
    public function testDataTypes2( $string, $html, $bool, $int, $float, $date, $findField, $findValue )
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchEmbeddedManager() );

        $a = new DataTypeTestMulti( 'testId', $string, $html, $bool, $int, $float, $date );
        $session->index( $a );
        $q = $session->createFindQuery( 'DataTypeTestMulti' );
        $q->where( $q->eq( $findField, $findValue ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
        self::assertEquals( array( $string ), $r->documents['testId']['document']->string );
        self::assertEquals( array( $html ), $r->documents['testId']['document']->html );
        self::assertEquals( array( $bool ), $r->documents['testId']['document']->bool );
        self::assertEquals( array( $int ), $r->documents['testId']['document']->int );
        self::assertEquals( array( $float ), $r->documents['testId']['document']->float );

        self::assertEquals( $string, $r->documents['testId']['document']->string[0] );
        self::assertEquals( $html, $r->documents['testId']['document']->html[0] );
        self::assertEquals( $bool, $r->documents['testId']['document']->bool[0] );
        self::assertEquals( $int, $r->documents['testId']['document']->int[0] );
        self::assertEquals( $float, $r->documents['testId']['document']->float[0] );
        self::assertEquals( date_create( "$date" )->format( '\sU' ), $r->documents['testId']['document']->date[0]->format( '\sU' ) );
    }

    public static function datatypesMulti()
    {
        return array(
            array( array( 'test', 'to' ),       array( '<b>test</b>', '<i>and</i>' ),       true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
            array( array( 'test', 'be' ),       array( '<b>test</b>', '<i>human</i>' ),     false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
            array( array( 'test', 'or' ),       array( '<b>test</b>', '<i>stupidity</i>' ), true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'string', 'or' ),
            array( array( 'test', 'or' ),       array( '<b>test</b>', '<i>And</i>' ),       true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'string', 'test' ),
            array( array( 'test', 'not' ),      array( '<b>test</b>', '<i>I</i>' ),         true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'string', 'tes*' ),
            array( array( 'test', 'to' ),       array( '<b>test</b>', '<i>am</i>' ),        false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', 'test' ),
            array( array( 'test', 'be' ),       array( '<b>test</b>', '<i>not</i>' ),       false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', 'not' ),
            array( array( 'test', 'that' ),     array( '<b>test</b>', '<i>sure</i>' ),      false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', '<b>test</b>' ),
            array( array( 'test', 'that' ),     array( '<b>test</b>', '<i>about</i>' ),     false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'html', '<i>about</i>' ),
            array( array( 'test', 'is' ),       array( '<b>test</b>', '<i>the</i>' ),       true, -42, -12831e4, "2008-04-23 16:35 Europe/Oslo", 'bool', true ),
            array( array( 'test', 'the' ),      array( '<b>test</b>', '<i>former</i>' ),    false, -42, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'bool', false ),
            array( array( 'test', 'question' ), array( '<b>test</b>', ), true, array( 1, 1, 2, 3, 5, 8 ), -12831e4, "2008-04-23 16:35 Europe/Oslo", 'int', 5 ),
            array( array( 'test' ),             array( '<b>test</b>', ), array( true, false ), 0, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'bool', true ),
            array( array( 'test', 'Only' ),     array( '<b>test</b>', ), array( true, false ), 913123, -0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'bool', false ),
            array( array( 'test', 'two' ),      array( '<b>test</b>', ), true, -51, array( 3.1415926 ), "2008-04-23 16:35 Europe/Oslo", 'float', 3.1415926 ),
            array( array( 'test', 'things' ),   array( '<b>test</b>', ), false, 0, 0.42e-9, "2008-04-23 16:35 Europe/Oslo", 'float', 0.42e-9 ),
            array( array( 'test', 'are' ),      array( '<b>test</b>', ), false, 913123, 0, array( "2008-04-23 16:35 Europe/Oslo" ), 'date', "2008-04-23 14:35 GMT" ),
            array( array( 'test', 'infinite' ), array( '<b>test</b>', ), false, 913123, 0, array( "2008-04-23 16:35 Europe/Oslo", "2008-04-23 15:35 BST" ), 'date', "2008-04-23 14:35 GMT" ),
            array( array( 'test', 'universe' ), array( '<b>test</b>', ), false, 913123, 0, "2008-04-23 16:35 Europe/Oslo", 'date', "2008-04-23 16:35 Europe/Oslo" ),
        );
    }

    /**
     * @dataProvider datatypesMulti
     */
    /*
    public function testDataTypes3( $string, $html, $bool, $int, $float, $date, $findField, $findValue )
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchEmbeddedManager() );

        $string = is_array( $string ) ? $string : array( $string );
        $html   = is_array( $html   ) ? $html   : array( $html   );
        $bool   = is_array( $bool   ) ? $bool   : array( $bool   );
        $int    = is_array( $int    ) ? $int    : array( $int    );
        $float  = is_array( $float  ) ? $float  : array( $float  );
        $date   = is_array( $date   ) ? $date   : array( $date   );

        $a = new DataTypeTestMulti( 'testId', $string, $html, $bool, $int, $float, $date );
        $session->index( $a );
        $q = $session->createFindQuery( 'DataTypeTestMulti' );
        $q->where( $q->eq( $findField, $findValue ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
        self::assertEquals( $string, $r->documents['testId']['document']->string );
        self::assertEquals( $html, $r->documents['testId']['document']->html );
        self::assertEquals( $bool, $r->documents['testId']['document']->bool );
        self::assertEquals( $int, $r->documents['testId']['document']->int );
        self::assertEquals( $float, $r->documents['testId']['document']->float );

        self::assertEquals( date_create( $date[0] )->format( '\sU' ), $r->documents['testId']['document']->date[0]->format( '\sU' ) );
    }
    */
}
?>
