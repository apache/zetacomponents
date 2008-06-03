<?php
require_once 'tutorial_autoload.php';

// setup
$handler = new ezcSearchSolrHandler;
$manager = new ezcSearchEmbeddedManager;
$session = new ezcSearchSession( $handler, $manager );

// initialize a pre-configured query
$q = $session->createFindQuery( 'Article' );

// where either body or title contains test but not article
$searchWord = 'test -article';

// run the query builder to search for the $searchWord in body and title
$qb = new ezcSearchQueryBuilder();
$qb->parseSearchQuery( $q, $searchWord, array( 'body', 'title' ) );

// run the query and show titles for found documents, and it's score
$r = $session->find();

foreach( $r->documents as $res )
{
    echo $res->document->score, ", ", $res->document->title, "\n";
}
?>
