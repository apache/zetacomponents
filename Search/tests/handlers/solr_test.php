<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 * @subpackage Tests
 */

require_once 'Search/tests/testfiles/test-classes.php';

/**
 * Test the handler classes.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchHandlerSolrTest extends ezcTestCase
{
    public static function suite()
    {
        stream_filter_register( 'ignoreWriteFilter', 'ezcTestIgnoreWriteStreamFilter' );
        return new PHPUnit_Framework_TestSuite( "ezcSearchHandlerSolrTest" );
    }

    function setUp()
    {
        try
        {
            $this->solr = new ezcSearchSolrHandler;
        }
        catch ( ezcSearchCanNotConnectException $e )
        {
            self::markTestSkipped( 'Solr is not running.' );
        }
        $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ),
                '<delete><query>timestamp:[* TO *]</query></delete>' );
        $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ),
                '<commit/>' );
    }

    function testUnableToConnect()
    {
        try
        {
            $s = new ezcSearchSolrHandler( 'localhost', 58983 );
            $r = $s->sendRawGetCommand( 'admin/ping' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchCanNotConnectException $e )
        {
            self::assertEquals( "Could not connect to 'solr' at 'http://localhost:58983/solr'.", $e->getMessage() );
        }
    }

    function testConnectAndPing()
    {
        $r = $this->solr->sendRawGetCommand( 'admin/ping' );
        self::assertContains( "<ping", $r );
    }

    function testSearchEmptyResultsSimple()
    {
        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );
    }

    function testSearchEmptyResults()
    {
        $r = $this->solr->search( 'solr', 'name_s' );
        self::assertType( 'stdClass', $r );
        self::assertEquals( 0, $r->response->numFound );
        self::assertEquals( 0, $r->response->start );
        self::assertEquals( 0, $r->responseHeader->status );
    }

    function testSimpleIndex()
    {
        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );
        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 1, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<delete><id>cfe5cc06-9b07-4e4b-930e-7e99f5202570</id></delete>' );
        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );
    }

    function testCommit()
    {
        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 1, $r->response->numFound );
    }

    function testTransaction()
    {
        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->beginTransaction();

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->commit();

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 1, $r->response->numFound );
    }

    function testNestedTransaction()
    {
        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->beginTransaction();
        $r = $this->solr->beginTransaction();

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->commit();

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->commit();

        $r = $this->solr->sendRawGetCommand( 'select', array( 'q' => 'solr', 'wt' => 'json', 'df' => 'name_s' ) );
        $r = json_decode( $r );
        self::assertEquals( 1, $r->response->numFound );
    }

    function testCommitWithoutBegin()
    {
        try
        {
            $r = $this->solr->commit();
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcSearchTransactionException $e )
        {
            self::assertEquals( 'Cannot commit without a transaction.', $e->getMessage() );
        }
    }

    function testSimpleIndexWithSearch()
    {
        $r = $this->solr->search( 'solr', 'name_s' );
        self::assertEquals( 0, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );
        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->solr->search( 'solr', 'name_s', array( 'id', 'name_s' ), array( 'id', 'name_s', 'score' ) );
        self::assertEquals( 1, $r->response->numFound );

        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<delete><id>cfe5cc06-9b07-4e4b-930e-7e99f5202570</id></delete>' );
        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<commit/>' );

        $r = $this->solr->search( 'solr', 'name_s' );
        self::assertEquals( 0, $r->response->numFound );
    }

    function testSolrHttpStatusCodeOk()
    {
        $this->solr = new testSolrFileWrapper( dirname( __FILE__ ) . '/../testfiles/solr-http-status.txt' );
        $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );
    }

    function testSolrHttpStatusCodeFail()
    {
        $this->solr = new testSolrFileWrapper( dirname( __FILE__ ) . '/../testfiles/solr-http-status-fail.txt' );
        try
        {
            $r = $this->solr->sendRawPostCommand( 'update', array( 'wt' => 'json' ), '<add><doc><field name="id">cfe5cc06-9b07-4e4b-930e-7e99f5202570</field><field name="name_s">solr</field></doc></add>' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchNetworkException $e )
        {
            self::assertEquals( 'A network issue occurred: The HTTP server reported: HTTP/1.1 500 Internal Server Error', $e->getMessage() );
        }
        fclose( $this->solr->connection );
    }
}

?>
