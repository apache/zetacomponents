<?php
require_once 'tutorial_autoload.php';

// setup
$handler = new ezcSearchSolrHandler;
$manager = new ezcSearchEmbeddedManager;
$session = new ezcSearchSession( $handler, $manager );

// instantiate article
$article = new Article();
$article->title = "A test article to show indexing."
$article->body  = <<<ENDBODY
This is the body of the text, nothing interesting now
as this is just an example.
ENDBODY;
$article->published = time();
$article->url       = "/article/1";
$article->type      = "article";

// index
$session->index( $article );
?>
