<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

$archive = ezcArchive::open( "/tmp/my_archive.zip" );
$archive->truncate();

$filesToAppend[] = "/tmp/directory/";
$filesToAppend[] = "/tmp/file.txt";

// The second parameter specifies prefix. The prefix is normally not included 
// in the archive.
$archive->appendToCurrent( $filesToAppend, "/tmp/" );

?>
