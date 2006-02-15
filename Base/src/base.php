<?php
/**
 * File containing the ezcBase class.
 *
 * @package Base
 * @version 1.0beta1
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class implements the methods needed to use the ezComponents.
 *
 * @package Base
 */
class ezcBase
{
    /**
     * Used for dependency checking, to check for a PHP extension.
     */
    const DEP_PHP_EXTENSION = "extension";

    /**
     * Used for dependency checking, to check for a PHP version.
     */
    const DEP_PHP_VERSION = "version";
    
    /**
     * Indirectly it determines the path where the autoloads are stored.
     */
    const libraryMode = "devel";

    /**
     * @var string  The full path to the autoload directory.
     */
    protected static $packageDir;

    /**
     * @var array  This variable stores all the elements from the autoload
     *             arrays. When a new autoload file is loaded, their files
     *             are added to this array.
     */
    protected static $autoloadArray = array();

    /**
     * Tries to autoload the given className. If the className could be found
     * this method returns true, otherwise false.
     *
     * This class caches the requested class names (including the ones who
     * failed to load).
     *
     *
     * @param string $className  The name of the class that should be loaded.
     *
     * @return bool
     */
    public static function autoload( $className )
    {
        ezcBase::setPackageDir();

        // Check whether the classname is already in the cached autoloadArray.
        if ( array_key_exists( $className, ezcBase::$autoloadArray ) )
        {
            // Is it registered as 'unloadable'?
            if ( ezcBase::$autoloadArray[$className] == false )
            {
                return false;
            }

            ezcBase::loadFile( ezcBase::$autoloadArray[$className] );

            return true;
        }

        // Not cached, so load the autoload from the package.
        // Matches the first and optionally the second 'word' from the classname.
        if ( preg_match( "/^ezc([A-Z][a-z]*)([A-Z][a-z]*)?/", $className, $matches ) !== false )
        {
            $autoloadFile = "";
            // Try to match with both names, if available.
            switch ( sizeof( $matches ) )
            {
                case 3:
                    $autoloadFile = strtolower( "{$matches[1]}_{$matches[2]}_autoload.php" );
                    if ( ezcBase::requireFile( $autoloadFile, $className ) )
                    {
                        return true;
                    }
                    // break intentionally missing.

                case 2:
                    $autoloadFile = strtolower( "{$matches[1]}_autoload.php" );
                    if ( ezcBase::requireFile( $autoloadFile, $className ) )
                    {
                        return true;
                    }
                    break;
            }

            // Maybe there is another autoload available.
            // Register this classname as false.
            ezcBase::$autoloadArray[$className] = false;
        }

        $path = ezcBase::$packageDir . 'autoload/';
        $realPath = realpath( $path );
        if ( $realPath == '' )
        {
            trigger_error( "Couldn't find autoload directory '$path'", E_USER_ERROR );
        }
        /* FIXME: this should go away - only for development */
        if ( self::libraryMode == 'devel' )
        {
            trigger_error( "Couldn't find autoload file for '$className' in '$realPath'", E_USER_WARNING );
        }
        return false;
    }

    /**
     * Returns the path to the autoload directory. The path depends on
     * the installation of the ezComponents. The SVN version has different
     * paths than the PEAR installed version. (For now).
     *
     * @return string
     */
    protected static function setPackageDir()
    {
        // Get the path to the components.
        $baseDir = dirname( __FILE__ );

		switch ( ezcBase::libraryMode )
		{
			case "devel":
		        ezcBase::$packageDir = $baseDir. "/../../../";
				break;
			case "tarball":
		        ezcBase::$packageDir = $baseDir. "/../../";
				break;
			case "pear";
		        ezcBase::$packageDir = $baseDir. "/../";
				break;
		}
    }

    /**
     * Tries to load the autoload array and, if loaded correctly, includes the class.
     *
     * @param string $fileName    Name of the autoload file.
     * @param string $className   Name of the class that should be autoloaded.
     *
     * @return bool  True is returned when the file is correctly loaded.
     *                   Otherwise false is returned.
     */
    protected static function requireFile( $fileName, $className )
    {
        $autoloadDir = ezcBase::$packageDir . "autoload/";

        // We need the full path to the fileName. The method file_exists() doesn't
        // automatically check the (php.ini) library paths. Therefore:
        // file_exists( "ezc/autoload/$fileName" ) doesn't work.
        if ( file_exists( "$autoloadDir$fileName" ) )
        {
            $array = require( "$autoloadDir$fileName" );

            if ( is_array( $array) && array_key_exists( $className, $array ) )
            {
                // Add the array to the cache, and include the requested file.
                ezcBase::$autoloadArray = array_merge( ezcBase::$autoloadArray, $array );
                ezcBase::loadFile( ezcBase::$autoloadArray[$className] );

                return true;
            }
        }

        // It is still not here :-(.
        return false;
    }

    /**
     * Loads, require(), the given file name. If we are in development mode,
     * "/trunk/src/" is inserted into the path.
     *
     * @param string $file  The name of the file that should be loaded.
     */
    protected static function loadFile( $file )
    {
        list( $first, $second ) = explode( '/', $file, 2 );
        switch ( ezcBase::libraryMode )
		{
			case "devel":
	            // Add the "trunk/src/" after the package name.
    	        $file = $first . "/trunk/src/" . $second;
				break;

			case "tarball":
	            // Add the "src/" after the package name.
	            $file = $first . "/src/" . $second;
				break;

			case "pear":
				$file = $first . '/'. $second;
				break;
        }

        require( ezcBase::$packageDir . $file );
    }

    public static function checkDependency( $component, $type, $value )
    {
        switch ( $type )
        {
            case self::DEP_PHP_EXTENSION:
                if ( extension_loaded( $value ) )
                {
                    return;
                }
                else
                {
                    die( "\nThe {$component} component depends on the PHP extension '{$value}', which is not loaded.\n" );
                }
                break;

            case self::DEP_PHP_VERSION:
                $phpVersion = phpversion();
                if ( version_compare( $phpVersion, $value, '>=' ) )
                {
                    return;
                }
                else
                {
                    die( "\nThe {$component} component depends on the PHP version '{$value}', but the current version is '{$phpVersion}'.\n" );
                }
                break;
        }
    }
}
?>
