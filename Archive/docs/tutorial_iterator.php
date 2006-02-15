<?php

include( "tutorial_autoload.php" );
date_default_timezone_set( "UTC" );

$archive = ezcArchive::open( "compress.zlib:///tmp/my_archive.tar.gz" );

// The foreach method calls internally the iterator methods.
foreach( $archive as $entry )
{
    echo $entry, "\n";

    $archive->extractCurrent( "/tmp/target_location/" );
}

?>
