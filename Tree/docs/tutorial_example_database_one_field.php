<?php
require_once 'tutorial_autoload.php';

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
        'data_field' varchar(255) NOT NULL
    );
    CREATE UNIQUE INDEX 'data_pri' on 'data' ( 'node_id' );
ENDSQL
);

$store = new ezcTreeDbExternalTableDataStore( $dbh, 'data', 'node_id', 'data_field' );
$tree = new ezcTreeDbNestedSet( $dbh, 'nested_set', $store );

$tree->setRootNode( $rootNode = $tree->createNode( 'Elements', 'Elements' ) );
$rootNode->addChild( $nonMetal = $tree->createNode( 'NonMetals', 'Non-Metals' ) );
$rootNode->addChild( $nobleGasses = $tree->createNode( 'NobleGasses', 'Noble Gasses' ) );
$nonMetal->addChild( $tree->createNode( 'H',  'Hydrogen' ) );

echo $tree->fetchNodeById( 'H' )->data, "\n";
?>
