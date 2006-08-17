<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package File
 */
/**
 * Provides a selection of static independent methods to provide functionality
 * for file and file system handling.
 *
 * This example shows how to use the findRecursive method:
 * <code>
 * <?php
 * // lists all the files under /etc (including subdirectories) that end in 
 * // .conf
 * $confFiles = ezcFile::findRecursive( "/etc", array( '@\.conf$@' ) );
 *
 * // lists all autoload files in the components source tree and excludes the
 * // ones in the autoload subdirectory.
 * $files = ezcFile::findRecursive(
 *     "/dat/dev/ezcomponents",
 *     array( '@src/.*_autoload.php$@' ),
 *     array( '@/autoload/@' )
 * );
 *
 * // lists all binaries in /bin except the ones starting with a "g"
 * $data = ezcFile::findRecursive( "/bin", array(), array( '@^/bin/g@' ) );
 * ?>
 * </code>
 *
 * @package File
 * @version //autogentag//
 * @mainclass
 */
class ezcFile
{
    /**
     * Finds files recursively on a file system
     *
     * With this method you can scan the file system for files. You can use
     * $includeFilters to include only specific files, and $excludeFilters to
     * exclude certain files from being returned. The function will always go
     * into subdirectories even if the entry would not have passed the filters.
     *
     * @param string $sourceDir
     * @param array(string) $includeFilters
     * @param array(string) $excludeFilters
     * @return array
     */
    static public function findRecursive( $sourceDir, array $includeFilters = array(), array $excludeFilters = array() )
    {
        if ( !$sourceDir )
        {
            throw new ezcBaseFileNotFoundException( $sourceDir, 'directory' );
        }
        $elements = array();
        $d = @dir( $sourceDir );
        if ( !$d )
        {
            throw new ezcBaseFilePermissionException( $sourceDir, ezcBaseFileException::READ );
        }
        
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry == '.' || $entry == '..' )
            {
                continue;
            }

            if ( is_dir( $sourceDir . '/' . $entry ) )
            {
                // We need to ignore the Permission exceptions here as it can
                // be normal that a directory can not be accessed. We only need
                // the exception if the top directory could not be read.
                try
                {
                    $subList = self::findRecursive( $sourceDir . '/' . $entry, $includeFilters, $excludeFilters );
                    $elements = array_merge( $elements, $subList );
                }
                catch ( ezcBaseFilePermissionException $e )
                {
                }
            }
            else
            {
                // By default a file is included in the return list
                $ok = true;
                // Iterate over the $includeFilters and prohibit the file from
                // being returned when atleast one of them does not match
                foreach ( $includeFilters as $filter )
                {
                    if ( !preg_match( $filter, $sourceDir . '/' . $entry ) )
                    {
                        $ok = false;
                        break;
                    }
                }
                // Iterate over the $excludeFilters and prohibit the file from
                // being returns when atleast one of them matches
                foreach ( $excludeFilters as $filter )
                {
                    if ( preg_match( $filter, $sourceDir . '/' . $entry ) )
                    {
                        $ok = false;
                        break;
                    }
                }

                if ( $ok )
                {
                    $elements[] = $sourceDir . '/' . $entry;
                }
            }
        }
        sort( $elements );
        return $elements;
    }

    /**
     * Removes files and directories recursively from a file system
     *
     * This method recursively removes the $directory and all its contents.
     * You should be <b>extremely</b> careful with this method as it has the
     * potential to erase everything that the current user has access to.
     *
     * @param string $directory
     */
    static public function removeRecursive( $directory )
    {
        $sourceDir = realpath( $directory );
        if ( !$sourceDir )
        {
            throw new ezcBaseFileNotFoundException( $directory, 'directory' );
        }
        $d = @dir( $sourceDir );
        if ( !$d )
        {
            throw new ezcBaseFilePermissionException( $directory, ezcBaseFileException::READ );
        }
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry == '.' || $entry == '..' )
            {
                continue;
            }

            if ( is_dir( $sourceDir . '/' . $entry ) )
            {
                self::removeRecursive( $sourceDir . '/' . $entry );
            }
            else
            {
                if ( @unlink( $sourceDir . '/' . $entry ) === false )
                {
                    throw new ezcBaseFilePermissionException( $directory . '/' . $entry, ezcBaseFileException::REMOVE );
                }
            }
        }
        rmdir( $sourceDir );
    }
}
?>
