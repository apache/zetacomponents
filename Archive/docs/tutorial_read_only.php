<?php
require_once 'tutorial_autoload.php';

$options = new ezcArchiveOptions( array( 'readOnly' => true ) );
$archive = ezcArchive::open(
    "compress.zlib:///tmp/my_archive.tar.gz", null, $options );

// The foreach method calls internally the iterator methods.
foreach( $archive as $entry )
{
    echo $entry, "\n";

    $archive->extractCurrent( "/tmp/target_location/" );
}
?>
