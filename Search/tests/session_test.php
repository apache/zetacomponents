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
        $this->backend = new ezcSearchSolrHandler();
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
        $d = file_get_contents( '/tmp/ezcomponents-2007.2.1/WorkflowEventLogTiein/ezcWorkflowEventLogListener.html' );
        $a = new Article( null, 'Test Article', 'This is an article to test', $d, time() );

        $session = new ezcSearchSession( $this->backend, new ezcSearchXmlManager( $this->testFilesDir ) );
        $session->index( $a );
        $this->backend->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->backend->search( 'Article', 'title_t' );
        self::assertEquals( 1, $r->resultCount );
    }
}

?>
