<?php
require_once 'tutorial_autoload.php';

// copy so that we can play with the file
copy( dirname( __FILE__ ). '/translations/mod-example-nl_NL.xml', '/tmp/mod-example-nl_NL.xml' );

// setup the backend to read from /tmp
$backend = new ezcTranslationTsBackend( '/tmp' );
$backend->setOptions( array( 'format' => 'mod-example-[LOCALE].xml' ) );

// get the original context
$context = $backend->getContext( 'nl_NL', 'existing' );

// the modifications
$context[] = new ezcTranslationData( 'added', 'toegevoeg', 'comment', ezcTranslationData::TRANSLATED );
$context[] = new ezcTranslationData( 'update with new translation', 'ingevuld', NULL, ezcTranslationData::TRANSLATED );
$context[] = new ezcTranslationData( 'update translation', 'bijgewerkt', NULL, ezcTranslationData::TRANSLATED );
$context[] = new ezcTranslationData( 'to obsolete', 'markeren als ongebruikt', NULL, ezcTranslationData::OBSOLETE );

// init the writer, and write the modified context
$backend->initWriter( 'nl_NL' );
$backend->storeContext( 'existing', $context );

// create a new context and write it
$context = array();
$context[] = new ezcTranslationData( 'new string', 'nieuwe string', NULL, ezcTranslationData::TRANSLATED );
$backend->storeContext( 'new', $context );

// deinit the writer
$backend->deinitWriter();

// read the context again, while keeping obsolete strings
$backend->setOptions( array( 'keepObsolete' => true ) );
$context = $backend->getContext( 'nl_NL', 'existing' );

// re-format the written file and show it
`cat /tmp/mod-example-nl_NL.xml | xmllint --format - > /tmp/formatted.xml`;
echo file_get_contents( '/tmp/formatted.xml' );
?>
