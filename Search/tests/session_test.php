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

        $r = $this->backend->search( 'Article', 'title_t' );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testIndexDocument2()
    {
        $a = new Article( null, 'Test Article', 'This is an article to test', 'the body of the article', time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        for ( $i = 0; $i < 100; $i++ )
        {
            $session->index( $a );
        }
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->backend->search( 'Article', 'title_t' );
        self::assertEquals( 1, $r->resultCount );
    }

    public function testIndexDocument3()
    {
        $d = file_get_contents( dirname( __FILE__ ) . '/../../../docs/guidelines/implementation.txt' );
        $a = new Article( null, 'Test Article', 'This is Rethans an article to test', $d, time(), array( 'Derick Rethans', 'Legolas Rethans' ) );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->backend->search( 'Rethans', 'author_t', array( 'summary_t', 'title_t', 'body_t' ), array( 'author_t', 'title_t', 'score', 'summary_t', 'published_dt' ), array( 'author_t', 'title_t', 'score', 'summary_t', 'published_dt' ) );
        self::assertEquals( 1, $r->resultCount );
    }
}

?>
