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

    public static function datatypes()
    {
        return array(
            array( 'test', '<b>test</b>', true, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
            array( 'test', '<b>test</b>', false, 42, 0.42, "2008-04-23 16:35 Europe/Oslo", 'id', 'testId' ),
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
}

class DataTypeTest implements ezcSearchDefinitionProvider
{
    public function __construct( $id = null, $string = null, $html = null, $bool = null, $int = null, $float = null, $date = null )
    {
        $this->id = $id; $this->string = $string; $this->html = $html;
        $this->bool = $bool; $this->int = $int; $this->float = $float;
        $this->date = $date;
    }

    function getState()
    {
        return array(
            'id' => $this->id, 'string' => $this->string, 'html' =>
            $this->html, 'bool' => $this->bool, 'int' => $this->int, 'float' =>
            $this->float, 'date' => $this->date,
        );
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    static public function getDefinition()
    {
        $def = new ezcSearchDocumentDefinition( 'DataTypeTest' );
        $def->idProperty = 'id';
        $def->fields['id'] =     new ezcSearchDefinitionDocumentField( 'id',     ezcSearchDocumentDefinition::STRING );
        $def->fields['string'] = new ezcSearchDefinitionDocumentField( 'string', ezcSearchDocumentDefinition::STRING );
        $def->fields['html'] =   new ezcSearchDefinitionDocumentField( 'html',   ezcSearchDocumentDefinition::HTML );
        $def->fields['bool'] =   new ezcSearchDefinitionDocumentField( 'bool',   ezcSearchDocumentDefinition::BOOLEAN );
        $def->fields['int'] =    new ezcSearchDefinitionDocumentField( 'int',    ezcSearchDocumentDefinition::INT );
        $def->fields['float'] =  new ezcSearchDefinitionDocumentField( 'float',  ezcSearchDocumentDefinition::FLOAT );
        $def->fields['date'] =   new ezcSearchDefinitionDocumentField( 'date',   ezcSearchDocumentDefinition::DATE );

        return $def;
    }
}

class DataTypeTestMulti implements ezcSearchDefinitionProvider
{
    public function __construct( $id = null, $string = null, $html = null, $bool = null, $int = null, $float = null, $date = null )
    {
        $this->id = $id; $this->string = $string; $this->html = $html;
        $this->bool = $bool; $this->int = $int; $this->float = $float;
        $this->date = $date;
    }

    function getState()
    {
        return array(
            'id' => $this->id, 'string' => $this->string, 'html' =>
            $this->html, 'bool' => $this->bool, 'int' => $this->int, 'float' =>
            $this->float, 'date' => $this->date,
        );
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    static public function getDefinition()
    {
        $def = new ezcSearchDocumentDefinition( 'DataTypeTestMulti' );
        $def->idProperty = 'id';
        $def->fields['id'] =     new ezcSearchDefinitionDocumentField( 'id',     ezcSearchDocumentDefinition::STRING );
        $def->fields['string'] = new ezcSearchDefinitionDocumentField( 'string', ezcSearchDocumentDefinition::STRING,  1, true, true );
        $def->fields['html'] =   new ezcSearchDefinitionDocumentField( 'html',   ezcSearchDocumentDefinition::HTML,    1, true, true );
        $def->fields['bool'] =   new ezcSearchDefinitionDocumentField( 'bool',   ezcSearchDocumentDefinition::BOOLEAN, 1, true, true );
        $def->fields['int'] =    new ezcSearchDefinitionDocumentField( 'int',    ezcSearchDocumentDefinition::INT,     1, true, true );
        $def->fields['float'] =  new ezcSearchDefinitionDocumentField( 'float',  ezcSearchDocumentDefinition::FLOAT,   1, true, true );
        $def->fields['date'] =   new ezcSearchDefinitionDocumentField( 'date',   ezcSearchDocumentDefinition::DATE,    1, true, true );

        return $def;
    }
}

?>
