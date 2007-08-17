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

// Setup the store and tree
$store = new ezcTreeDbExternalTableDataStore( $dbh, 'data', 'node_id' );
$tree = new ezcTreeDbNestedSet( $dbh, 'nested_set', $store );

// Insert data
$tree->setRootNode( $root = $tree->createNode( 'Metals', array() ) );
$root->addChild( $tree->createNode( 'Fe',  array( 'melting_temp_K' => 1811, 'boiling_temp_K' => 3134 ) ) );

// Fetch data
var_dump( $tree->fetchNodeById( 'Fe' )->data );
?>
