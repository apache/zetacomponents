<?php
/**
 * File contaning the abstract ezcTestCase class.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Abstract base class for all eZ Components test cases.
 *
 * @package UnitTest
 * @version //autogentag//
 */
abstract class ezcTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Do not mess with the temp dir, otherwise the removeTempDirectory might
     * remove the wrong directory.
     */
    private $tempDir;

    /**
     * Creates and returns the temporary directory.
     *
     * @param string $prefix  Set the prefix of the temporary directory.
     *
     * @param string $path    Set the location of the temporary directory. If
     *                        set to false, the temporary directory will
     *                        probably placed in the /tmp directory.
     */
    protected function createTempDir( $prefix, $path = 'run-tests-tmp' )
    {
        if ( !is_dir( $path ) )
        {
            mkdir( $path );
        }
        if ( $tempname = tempnam( $path, $prefix ))
        {
            unlink( $tempname );
            if ( mkdir( $tempname ) )
            {
                $this->tempDir = $tempname;
                return $tempname;
            }
        }

        return false;
    }

    /**
     * Get the name of the temporary directory.
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * Remove the temp directory.
     */
    public function removeTempDir()
    {
        if ( file_exists( $this->tempDir ) )
        {
            $this->removeRecursively( $this->tempDir );
        }
    }

    public function cleanTempDir()
    {
        if ( is_dir( $this->tempDir ) )
        {
            if ( $dh = opendir( $this->tempDir ) ) 
            {
                while ( ( $file = readdir( $dh ) ) !== false ) 
                {
                    if ( $file[0] != "." )
                    {
                        $this->removeRecursively( $this->tempDir . DIRECTORY_SEPARATOR . $file );
                    }
                }
            }
        }
    }


    private function removeRecursively( $entry )
    {
        if ( is_file( $entry ) || is_link( $entry ) )
        {
            // Some extra security that you're not erasing your harddisk :-).
            if ( strncmp( $this->tempDir, $entry, strlen( $this->tempDir ) ) == 0 )
            {
                return unlink( $entry );
            }
        }

        if ( is_dir( $entry ) )
        {
            if ( $dh = opendir( $entry ) )
            {
                while ( ( $file = readdir( $dh ) ) !== false )
                {
                    if ( $file != "." && $file != '..' )
                    {
                        $this->removeRecursively( $entry . DIRECTORY_SEPARATOR . $file );
                    }
                }

                closedir( $dh );
                rmdir( $entry );
            }
        }
    }

    /**
     * Checks if $expectedValues are properly set on $propertyName in $object.
     */
    public function assertSetProperty( $object, $propertyName, $expectedValues )
    {
        if ( is_array( $expectedValues ) )
        {
            foreach ( $expectedValues as $value )
            {
                $object->$propertyName = $value;
                $this->assertEquals( $value, $object->$propertyName );
            }
        }
        else
        {
            $this->fail( "Invalid test: expectedValues is not an array." );
        }
    }

    /**
     * Checks if $setValues fail when set on $propertyName in $object.
     * Setting the property must result in an exception.
     */
    public function assertSetPropertyFails( $object, $propertyName, $setValues )
    {
        foreach ( $setValues as $value )
        {
            try
            {
                $object->$propertyName = $value;
            }
            catch ( Exception $e )
            {
                continue;
            }

            $this->fail( "Setting property $propertyName to $value did not fail." );
        }
    }
}
?>
