<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
 * $confFiles = ezcBaseFile::findRecursive( "/etc", array( '@\.conf$@' ) );
 *
 * // lists all autoload files in the components source tree and excludes the
 * // ones in the autoload subdirectory. Statistics are returned in the $stats
 * // variable which is passed by reference.
 * $files = ezcBaseFile::findRecursive(
 *     "/dat/dev/ezcomponents",
 *     array( '@src/.*_autoload.php$@' ),
 *     array( '@/autoload/@' ),
 *     $stats
 * );
 *
 * // lists all binaries in /bin except the ones starting with a "g"
 * $data = ezcBaseFile::findRecursive( "/bin", array(), array( '@^/bin/g@' ) );
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
     * Filters are regular expressions and are therefore required to have
     * starting and ending delimiters. The Perl Compatible syntax is used as
     * regular expression language.
     *
     * If you pass an empty array to the $statistics argument, the function
     * will in details about the number of files found into the 'count' array
     * element, and the total filesize in the 'size' array element. Because this 
     * argument is passed by reference, you *have* to pass a variable and you
     * can not pass a constant value such as "array()".
     *
     * @param string         $sourceDir
     * @param array(string)  $includeFilters
     * @param array(string)  $excludeFilters
     * @param array()        $statistics
     *
     * @throws ezcBaseFileNotFoundException if the $sourceDir directory is not
     *         a directory or does not exist.
     * @throws ezcBaseFilePermissionException if the $sourceDir directory could
     *         not be opened for reading.
     * @return array
     */
    static public function findRecursive( $sourceDir, array $includeFilters = array(), array $excludeFilters = array(), &$statistics = null )
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

        // init statistics array
        if ( !is_array( $statistics ) || !array_key_exists( 'size', $statistics ) || !array_key_exists( 'count', $statistics ) )
        {
            $statistics['size']  = 0;
            $statistics['count'] = 0;
        }

        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry == '.' || $entry == '..' )
            {
                continue;
            }

            $fileInfo = @stat( $sourceDir . DIRECTORY_SEPARATOR . $entry );
            if ( !$fileInfo )
            {
                $fileInfo = array( 'size' => 0, 'mode' => 0 );
            }

            if ( $fileInfo['mode'] & 0x4000 )
            {
                // We need to ignore the Permission exceptions here as it can
                // be normal that a directory can not be accessed. We only need
                // the exception if the top directory could not be read.
                try
                {
                    $subList = self::findRecursive( $sourceDir . DIRECTORY_SEPARATOR . $entry, $includeFilters, $excludeFilters, $statistics );
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
                    if ( !preg_match( $filter, $sourceDir . DIRECTORY_SEPARATOR . $entry ) )
                    {
                        $ok = false;
                        break;
                    }
                }
                // Iterate over the $excludeFilters and prohibit the file from
                // being returns when atleast one of them matches
                foreach ( $excludeFilters as $filter )
                {
                    if ( preg_match( $filter, $sourceDir . DIRECTORY_SEPARATOR . $entry ) )
                    {
                        $ok = false;
                        break;
                    }
                }

                if ( $ok )
                {
                    $elements[] = $sourceDir . DIRECTORY_SEPARATOR . $entry;
                    $statistics['count']++;
                    $statistics['size'] += $fileInfo['size'];
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

            if ( is_dir( $sourceDir . DIRECTORY_SEPARATOR . $entry ) )
            {
                self::removeRecursive( $sourceDir . DIRECTORY_SEPARATOR . $entry );
            }
            else
            {
                if ( @unlink( $sourceDir . DIRECTORY_SEPARATOR . $entry ) === false )
                {
                    throw new ezcBaseFilePermissionException( $directory . DIRECTORY_SEPARATOR . $entry, ezcBaseFileException::REMOVE );
                }
            }
        }
        $d->close();
        rmdir( $sourceDir );
    }

    /**
    * Recursively copy a file or directory.
    *
    * Recursively copy a file or directory in $source to the given
    * destination. If a depth is given, the operation will stop, if the given
    * recursion depth is reached. A depth of -1 means no limit, while a depth
    * of 0 means, that only the current file or directory will be copied,
    * without any recursion.
    *
    * You may optionally define modes used to create files and directories.
    *
    * @throws ezcBaseFileNotFoundException
    *      If the $sourceDir directory is not a directory or does not exist.
    * @throws ezcBaseFilePermissionException
    *      If the $sourceDir directory could not be opened for reading, or the
    *      destination is not writeable.
    *
    * @param string $source
    * @param string $destination
    * @param int $depth
    * @param int $dirMode
    * @param int $fileMode
    * @return void
    */
    static public function copyRecursive( $source, $destination, $depth = -1, $dirMode = 0775, $fileMode = 0664 )
    {
        // Check if source file exists at all.
        if ( !is_file( $source ) && !is_dir( $source ) )
        {
            throw new ezcBaseFileNotFoundException( $source );
        }

        // Destination file should NOT exist
        if ( is_file( $destination ) || is_dir( $destination ) )
        {
            throw new ezcBaseFilePermissionException( $destination, ezcBaseFileException::WRITE );
        }

        // Skip non readable files in source directory
        if ( !is_readable( $source ) )
        {
            return;
        }

        // Copy
        if ( is_dir( $source ) )
        {
            mkdir( $destination );
            // To ignore umask, umask() should not be changed with
            // multithreaded servers...
            chmod( $destination, $dirMode );
        }
        elseif ( is_file( $source ) )
        {
            copy( $source, $destination );
            chmod( $destination, $fileMode );
        }

        if ( ( $depth === 0 ) ||
            ( !is_dir( $source ) ) )
        {
            // Do not recurse (any more)
            return;
        }

        // Recurse
        $dh = opendir( $source );
        while( $file = readdir( $dh ) )
        {
            if ( ( $file === '.' ) ||
                ( $file === '..' ) )
            {
                continue;
            }

            self::copyRecursive(
                $source . '/' . $file,
                $destination . '/' . $file,
                $depth - 1, $dirMode, $fileMode
            );
        }
    }

    /**
     * Calculates the relative path of the file/directory '$path' to a given
     * $base path.
     *
     * $path and $base should be fully absolute paths. This function returns the
     * answer of "How do I go from $base to $path". If the $path and $base are
     * the same path, the function returns '.'. This method does not touch the
     * filesystem.
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

        // If the paths are the same we return
        if ( $base === $path )
        {
            return '.';
        }

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
        // prevent a trailing DIRECTORY_SEPARATOR in case there is only a ..
        if ( count( $path ) == 0 )
        {
            $result = substr( $result, 0, -strlen( DIRECTORY_SEPARATOR ) );
        }
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
