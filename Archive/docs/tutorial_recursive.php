<?php

require_once 'tutorial_autoload.php';
date_default_timezone_set( "UTC" );

class ArchiveContext extends ezcBaseFileFindContext
{
    public $archive;
    public $prefix;
}

function findRecursiveCallback( ezcBaseFileFindContext $context, $sourceDir, $fileName, $fileInfo )
{
    $path = "{$sourceDir}/{$fileName}";
    if ( is_dir( $path ) )
    {
        $path .= '/';
    }
    $context->archive->append( array( $path ), $context->prefix );
}

function appendRecursive( $archive, $sourceDir, $prefix )
{
    $context = new ArchiveContext();
    $context->archive = $archive;
    $context->prefix = $prefix;
    ezcBaseFile::walkRecursive( $sourceDir, array(), array(), 'findRecursiveCallback', $context );
}

$archive = ezcArchive::open( "my_archive.zip", ezcArchive::ZIP );
$archive->truncate();

// the 2nd parameter is the directory, the 3rd parameter is the prefix
appendRecursive( $archive, '/tmp/directory/', '/tmp/directory/' );

?>
