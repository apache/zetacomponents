<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

// Open the gzipped TAR archive.
$archive = ezcArchive::open( "compress.zlib:///tmp/my_archive.tar.gz" );

while( $archive->valid() )
{
    // Returns the current entry (ezcArchiveEntry).
    $entry = $archive->current();

    // ezcArchiveEntry has an __toString() method.
    echo $entry, "\n";

    // Extract the current archive entry to /tmp/target_location/
    $archive->extractCurrent( "/tmp/target_location/" );

    $archive->next();
}

?>
