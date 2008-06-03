<?php
require_once 'tutorial_autoload.php';

// setup
$handler = new ezcSearchSolrHandler;
$manager = new ezcSearchEmbeddedManager;
$session = new ezcSearchSession( $handler, $manager );

// initialize a pre-configured query
$q = $session->createFindQuery( 'Article' );

$searchWord = 'test';

// where either body or title contains thr $searchWord
$q->where(
    $q->lOr(
        $q->eq( 'body', $searchWord ), 
        $q->eq( 'title', $searchWord ) 
    )
);

// limit the query and order
$q->limit( 10 );
$q->orderBy( 'title' );

// add a facet on url (not very useful)
$q->facet( 'url' );

// run the query and show titles for found documents
$r = $session->find();

foreach( $r->documents as $res )
{
    echo $res->document->title, "\n";
}
?>
