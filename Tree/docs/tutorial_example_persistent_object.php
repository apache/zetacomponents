<?php
require_once 'tutorial_autoload.php';

// Setup the database tables
$dbh = ezcDbFactory::create( 'sqlite://:memory:' );
$dbh->exec( <<<ENDSQL
    CREATE TABLE nested_set (
        'id' varchar(255) NOT NULL,
        'parent_id' varchar(255),
        'lft' integer NOT NULL,
        'rgt' integer NOT NULL
    );
    CREATE UNIQUE INDEX 'nested_set_pri' on 'nested_set' ( 'id' );
    CREATE INDEX 'nested_set_left' on 'nested_set' ( 'lft' );
    CREATE INDEX 'nested_set_right' on 'nested_set' ( 'rgt' );

    CREATE TABLE data (
        'node_id' varchar(255) NOT NULL,
        'melting_temp_k' float,
        'boiling_temp_k' float
    );
    CREATE UNIQUE INDEX 'data_pri' on 'data' ( 'node_id' );
ENDSQL
);

// Create the example Persistent Object definition files and stub classes
$dbSchema = ezcDbSchema::createFromDb( $dbh );
$writer1 = new ezcDbSchemaPersistentWriter( true );
$writer2 = new ezcDbSchemaPersistentClassWriter( true );
$writer1->saveToFile( 'files/po_defs', $dbSchema );
$writer2->saveToFile( 'files/classes', $dbSchema );
require 'files/classes/data.php';

// Setup the store and tree
$session = new ezcPersistentSession( $dbh, new ezcPersistentCodeManager( "files/po_defs" ) );
$store = new ezcTreePersistentObjectDataStore( $session, 'data', 'node_id' );
$tree = new ezcTreeDbNestedSet( $dbh, 'nested_set', $store );

// Insert data
$metal = new data();
$tree->setRootNode( $root = $tree->createNode( 'Metals', $metal ) );
$iron = new data();
$iron->setState( array( 'melting_temp_k' => 1811, 'boiling_temp_k' => 3134 ) );
$root->addChild( $tree->createNode( 'Fe', $iron ) );

// Fetch data
$fe = $tree->fetchNodeById( 'Fe' )->data;
var_dump( $fe );
?>
