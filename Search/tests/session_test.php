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

/**
 * Test the handler classes.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchSessionTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchSessionTest" );
    }

    public function setUp()
    {
        try
        {
            $this->backend = new ezcSearchSolrHandler;
        }
        catch ( ezcSearchCanNotConnectException $e )
        {
            self::markTestSkipped( 'Solr is not running.' );
        }
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ),
                '<delete><query>timestamp:[* TO *]</query></delete>' );
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ),
                '<commit/>' );
    }

    public function testCreateSession()
    {
        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
    }

    public function testIndexDocument1()
    {
        $a = new Article( null, 'Test Article', 'This is an article to test', 'the body of the article', time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testIndexDocument2()
    {
        $a = new Article( null, 'Test Article', 'This is an article to test', 'the body of the article', time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->beginTransaction();
        for ( $i = 0; $i < 100; $i++ )
        {
            $session->index( $a );
        }
        $session->commit();

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'title', 'Article' ) );
        $r = $session->find( $q );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testIndexDocument3()
    {
        $d = file_get_contents( dirname( __FILE__ ) . '/../../../docs/guidelines/implementation.txt' );
        $a = new Article( null, 'Test Article', 'This is Rethans an article to test', $d, time(), array( 'Derick Rethans', 'Legolas Rethans' ) );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $q = $session->createFindQuery( 'Article' );
        $q->where( $q->eq( 'author', 'Rethans' ) );
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
        self::assertEquals( true, isset( $r->documents[0]['meta'] ) );
        self::assertEquals( true, isset( $r->documents[0]['meta']['score'] ) );
        self::assertEquals( true, isset( $r->documents[0]['document'] ) );
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
}

?>
