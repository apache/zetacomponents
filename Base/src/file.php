<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Base
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
 * @package Base
 * @version //autogentag//
 * @mainclass
 */
class ezcBaseFile
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
     *
     * @throws ezcBaseFileNotFoundException if the $sourceDir directory is not
     *         a directory or does not exist.
     * @throws ezcBaseFilePermissionException if the $sourceDir directory could
     *         not be opened for reading.
     * @return array
     */
    static public function findRecursive( $sourceDir, array $includeFilters = array(), array $excludeFilters = array() )
    {
        if ( !is_dir( $sourceDir ) )
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
        $d->close();
        rmdir( $sourceDir );
    }

    /**
     * Calculates the relative path of the file/directory '$path' to a given
     * $base path.
     * This method does not touch the filesystem.
     *
     * @param string $path
     * @param string $base
     * @return string
     */
    static public function calculateRelativePath( $path, $base )
    {
        // Sanitize the paths to use the correct directory separator for the platform
        $path = strtr( $path, '\\/', DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR );
        $base = strtr( $base, '\\/', DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR );

        $base = explode( DIRECTORY_SEPARATOR, $base );
        $path = explode( DIRECTORY_SEPARATOR, $path );

        $result = '';

        $pathPart = array_shift( $path );
        $basePart = array_shift( $base );
        while ( $pathPart == $basePart )
        {
            $pathPart = array_shift( $path );
            $basePart = array_shift( $base );
        }

        if ( $pathPart != null )
        {
            array_unshift( $path, $pathPart );
        }
        if ( $basePart != null ) 
        {
            array_unshift( $base, $basePart );
        }

        $result = str_repeat( '..' . DIRECTORY_SEPARATOR, count( $base ) );
        $result .= join( DIRECTORY_SEPARATOR, $path );

        return $result;
    }

    /**
     * Returns whether the passed $path is an absolute path, giving the current $os.
     *
     * With the $os parameter you can tell this function to use the semantics
     * for a different operating system to determine whether a path is
     * absolute. The $os argument defaults to the OS that the script is running
     * on.
     *
     * @param string $path
     * @param string $os
     * @return bool
     */
    public static function isAbsolutePath( $path, $os = null )
    {
        if ( $os === null )
        {
            $os = ezcBaseFeatures::os();
        }

        switch ( $os )
        {
            case 'Windows':
                // Sanitize the paths to use the correct directory separator for the platform
                $path = strtr( $path, '\\/', '\\\\' );

                // Absolute paths with drive letter: X:\
                if ( preg_match( '@^[A-Z]:\\\\@i', $path ) )
                {
                    return true;
                }
 
                // Absolute paths with network paths: \\server\share\
                if ( preg_match( '@^\\\\\\\\[A-Z]+\\\\[^\\\\]@i', $path ) )
                {
                    return true;
                }
                break;
            case 'Mac':
            case 'Linux':
            case 'FreeBSD':
            default:
                // Sanitize the paths to use the correct directory separator for the platform
                $path = strtr( $path, '\\/', '//' );

                if ( $path[0] == '/' )
                {
                    return true;
                }
        }
        return false;
    }
}
?>
