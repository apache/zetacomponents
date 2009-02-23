<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TreePersistentObjectTiein
 * @subpackage Tests
 */

require_once 'Tree/tests/tree.php';
require_once 'files/classes/fileentry.php';

/**
 * @package TreePersistentObjectTiein
 * @subpackage Tests
 */
class ezcTreePersistentObjectStore extends ezcTestCase
{
    private $tempDir;

    protected $tables  = array( 'nested_set', 'fileentry' );
    protected $schemaName = 'persistent_store.dba';

    private $session;

    protected function setUpEmptyTestTree()
    {
        $store = new ezcTreePersistentObjectDataStore( $this->session, 'FileEntry', 'id' );
        $tree = ezcTreeDbNestedSet::create(
            $this->dbh,
            'nested_set',
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree()
    {
        $store = new ezcTreePersistentObjectDataStore( $this->session, 'FileEntry', 'id' );
        $tree = new ezcTreeDbNestedSet(
            $this->dbh,
            'nested_set',
            $store
        );
        return $tree;
    }

    protected $dbh;

    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( __CLASS__ ) . '/';

        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCacheManager( new ezcPersistentCodeManager( dirname( __FILE__ ) . '/files/defs' ) )
        );
        try
        {
            $this->dbh = ezcDbInstance::get();
            $this->removeTables();
            $this->loadSchema();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
    }

    public function teardown()
    {
        $this->removeTempDir();
    }

    private function loadSchema()
    {
        // create the parent_child table
        $schema = ezcDbSchema::createFromFile(
            'array',
            dirname( __FILE__ ) . '/files/' . $this->schemaName
        );
        $schema->writeToDb( $this->dbh );
    }

    protected function emptyTables()
    {
        $db = $this->dbh;

        foreach ( $this->tables as $table )
        {
            $q = $db->createDeleteQuery();
            $q->deleteFrom( $table );
            $s = $q->prepare();
            $s->execute();
        }
    }

    protected function removeTables()
    {
        try
        {
            foreach ( $this->tables as $table )
            {
                $this->dbh->exec( "DROP TABLE $table" );
            }
        }
        catch ( Exception $e )
        {
            // ignore
        }
    }

    private function addStandardData( $tree )
    {
        $entry = new FileEntry( ':root:', FileEntry::ROOT, 60639255 );
        $node = $tree->createNode( 1, $entry );
        $tree->setRootNode( $node );

        $entry = new FileEntry( '/', FileEntry::PARTITION, 8385596, '/dev/sda6' );
        $node2 = $tree->createNode( 2, $entry );
        $node->addChild( $node2 );

        $entry = new FileEntry( '/boot', FileEntry::PARTITION, 124443, '/dev/sda3' );
        $node->addChild( $node3 = $tree->createNode( 3, $entry ) );
        $entry = new FileEntry( '/boot/grub', FileEntry::DIR, 172 );
        $node3->addChild( $node4 = $tree->createNode( 'grubby', $entry ) );
        $entry = new FileEntry( '/boot/grub/stage1', FileEntry::FILE, 1 );
        $node4->addChild( $tree->createNode( 5, $entry ) );
        $entry = new FileEntry( '/boot/grub/stage2', FileEntry::FILE, 107 );
        $node4->addChild( $tree->createNode( 6, $entry ) );

        $entry = new FileEntry( '/home', FileEntry::PARTITION, 43743620, '/dev/sda7' );
        $node->addChild( $node7 = $tree->createNode( 7, $entry ) );
        $entry = new FileEntry( '/home/httpd', FileEntry::DIR, 652577 );
        $node7->addChild( $node8 = $tree->createNode( 8, $entry ) );
        $entry = new FileEntry( '/boot/httpd/pw-admin', FileEntry::FILE, 1 );
        $node8->addChild( $tree->createNode( 9, $entry ) );
    }

    public function testCreateDbTree()
    {
        $tree = $this->setUpEmptyTestTree();

        self::assertSame( false, $tree->nodeExists( '1' ) );
        self::assertSame( false, $tree->nodeExists( '3' ) );

        $entry = new FileEntry( ':root:', FileEntry::ROOT, 60639255 );
        $node = $tree->createNode( 1, $entry );
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        $tree->setRootNode( $node );
        self::assertSame( true, $tree->nodeExists( '1' ) );

        $entry = new FileEntry( '/', FileEntry::PARTITION, 8385596, '/dev/sda6' );
        $node2 = $tree->createNode( 2, $entry );
        $node->addChild( $node2 );
        self::assertSame( true, $tree->nodeExists( '2' ) );

        $entry = new FileEntry( '/boot', FileEntry::PARTITION, 124443, '/dev/sda3' );
        $node->addChild( $node3 = $tree->createNode( 3, $entry ) );
        $entry = new FileEntry( '/boot/grub', FileEntry::DIR, 172 );
        $node3->addChild( $tree->createNode( 4, $entry ) );
        self::assertSame( true, $tree->nodeExists( '3' ) );
        self::assertSame( true, $tree->nodeExists( '4' ) );
    }

    public function testFetchData()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addStandardData( $tree );

        // start over
        $tree = $this->setUpTestTree();

        $node = $tree->fetchNodeById( '3' );
        self::assertSame( 3, (int) $node->data->id );
        self::assertSame( FileEntry::PARTITION, (int) $node->data->type );

        $node = $tree->fetchNodeById( 'grubby' );
        self::assertSame( 'grubby', $node->data->id );
        self::assertSame( 172, (int) $node->data->size );
    }

    public function testFetchDataXmlTree()
    {
        $store = new ezcTreePersistentObjectDataStore( $this->session, 'FileEntry', 'id' );
        $tree = ezcTreeXml::create( $this->tempDir . 'test-xml.xml', $store, 'ezc' );
        $this->emptyTables();
        $this->addStandardData( $tree );

        // start over
        $tree = new ezcTreeXml( $this->tempDir . 'test-xml.xml', $store, 'ezc' );

        $node = $tree->fetchNodeById( '3' );
        self::assertSame( 3, (int) $node->data->id );
        self::assertSame( FileEntry::PARTITION, (int) $node->data->type );

        $node = $tree->fetchNodeById( 'grubby' );
        self::assertSame( 'grubby', $node->data->id );
        self::assertSame( 172, (int) $node->data->size );
    }

    public function testFetchMissingData()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addStandardData( $tree );
        $node = $tree->fetchNodeById( '9' );
        $data = $node->data;
        $this->session->delete( $data );

        // start over
        $tree = $this->setUpTestTree();

        try
        {
            $node = $tree->fetchNodeById( '9' );
            $data = $node->data;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcTreeDataStoreMissingDataException $e )
        {
            self::assertSame( "The data store does not have data stored for the node with ID '9'.", $e->getMessage() );
        }
    }

    public function testFetchDataMultipleNodes()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addStandardData( $tree );

        // start over
        $tree = $this->setUpTestTree();

        $list = $tree->fetchSubtree( '1' );
        foreach ( new ezcTreeNodeListIterator( $tree, $list, $tree ) as $elem )
        {
        }
        self::assertSame( '/boot/httpd/pw-admin', $elem->name );
    }

    public function testDeleteData()
    {
        $tree = $this->setUpEmptyTestTree();
        $this->addStandardData( $tree );

        $node = $tree->delete( '3' );

        // start over
        $tree = $this->setUpTestTree();
        $list = $tree->fetchSubtree( '1' );
        self::assertSame( 5, $list->size );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreePersistentObjectStore" );
    }
}

?>
