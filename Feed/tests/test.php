<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Feed
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Feed
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcFeedTestCase extends ezcTestCase
{
    /**
     * Tests assigning an invalid value to a property.
     *
     * Expects that an ezcBaseValueException is raised by the invalid value.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param mixed $value The value to try to assign to $property
     * @param string $allowedValue The values which are allowed for $property
     */
    protected function invalidPropertyTest( $properties, $property, $value, $allowedValue )
    {
        try
        {
            $properties->$property = $value;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $value = is_array( $value ) ? serialize( $value ) : $value;
            $this->assertEquals( "The value '{$value}' that you were trying to assign to setting '{$property}' is invalid. Allowed values are: {$allowedValue}.", $e->getMessage() );
        }
    }

    /**
     * Tests assigning a read-only property.
     *
     * Expects that an ezcBasePropertyPermissionException is raised.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     */
    protected function readonlyPropertyTest( $properties, $property )
    {
        try
        {
            $properties->$property = null;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            $this->assertEquals( "The property '{$property}' is read-only.", $e->getMessage() );
        }
    }

    /**
     * Tests assigning a value to a missing property.
     *
     * Expects that an ezcBasePropertyNotFoundException is raised by the missing
     * property.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     */
    protected function missingPropertyTest( $properties, $property )
    {
        try
        {
            $properties->$property = null;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name '{$property}'.", $e->getMessage() );
        }

        // workaround around a bug (?) - __isset() in ezcBaseOptions complains and warns
        // that the second parameter for array_exists() must be an array or an object
        if ( !$properties instanceof ezcBaseOptions )
        {
            try
            {
                $value = $properties->$property;
                $this->fail( "Expected exception was not thrown." );
            }
            catch ( ezcBasePropertyNotFoundException $e )
            {
                $this->assertEquals( "No such property name '{$property}'.", $e->getMessage() );
            }
        }
    }

    /**
     * Tests if a property is set.
     *
     * Compares the result of isset() with $value.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param bool $value True if expecting that $property is set, false otherwise
     */
    protected function issetPropertyTest( $properties, $property, $value )
    {
        $this->assertEquals( $value, isset( $properties->$property ) );
    }

    /**
     * Tests assigning a non-existent path to a property.
     *
     * Expects that an ezcBaseFileNotFoundException is raised by the missing
     * path.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A path which does not exist
     */
    protected function missingFileTest( $properties, $property, $value )
    {
        try
        {
            $properties->$property = $value;
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file '{$value}' could not be found.", $e->getMessage() );
        }
    }

    /**
     * Tests assigning an unreadable path to a property.
     *
     * Expects that an ezcBaseFilePermissionException is raised by the unreadable
     * path.
     *
     * This function creates a temporary file and makes it unreadable.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A filename without paths or slashes
     */
    protected function unreadableFileTest( $properties, $property, $value )
    {
        $tempDir = $this->createTempDir( get_class( $this ) );
        $path = $tempDir . DIRECTORY_SEPARATOR . $value;
        $fh = fopen( $path, "wb" );
        fwrite( $fh, "some values" );
        fclose( $fh );
        chmod( $path, 0 );

        try
        {
            $properties->$property = $path;
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for reading.", $e->getMessage() );
        }

        $this->removeTempDir();
    }

    /**
     * Tests assigning an unwritable path to a property.
     *
     * Expects that an ezcBaseFilePermissionException is raised by the unwritable
     * path.
     *
     * This function creates a temporary file and makes it unwritable.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A filename without paths or slashes
     */
    protected function unwritableFileTest( $properties, $property, $value )
    {
        $tempDir = $this->createTempDir( get_class( $this ) );
        $path = $tempDir . DIRECTORY_SEPARATOR . $value;
        $fh = fopen( $path, "wb" );
        fwrite( $fh, "some values" );
        fclose( $fh );
        chmod( $path, 0 );

        try
        {
            $properties->$property = $path;
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for writing.", $e->getMessage() );
        }

        $this->removeTempDir();
    }

    /**
     * Tests assigning a non-existent directory to a property.
     *
     * Expects that an ezcBaseFileNotFoundException is raised by the missing
     * directory.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A directory which does not exist
     */
    protected function missingDirTest( $properties, $property, $value )
    {
        try
        {
            $properties->$property = $value;
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file '{$value}' could not be found.", $e->getMessage() );
        }
    }

    /**
     * Tests assigning an unreadable directory to a property.
     *
     * Expects that an ezcBaseFilePermissionException is raised by the unreadable
     * path.
     *
     * This function creates a temporary directory and makes it unreadable.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A directory name without paths or slashes
     */
    protected function unreadableDirTest( $properties, $property, $value )
    {
        $tempDir = $this->createTempDir( get_class( $this ) );
        $path = $tempDir . DIRECTORY_SEPARATOR . $value;
        mkdir( $path );
        chmod( $path, 0 );

        try
        {
            $properties->$property = $path;
            chmod( $path, 0777 );
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for reading.", $e->getMessage() );
        }

        chmod( $path, 0777 );
        $this->removeTempDir();
    }

    /**
     * Tests assigning an unwritable directory to a property.
     *
     * Expects that an ezcBaseFilePermissionException is raised by the unwritable
     * path.
     *
     * This function creates a temporary directory and makes it unwritable.
     *
     * @param object $properties An object which implements properties access
     * @param string $property The property of the $properties object to test
     * @param string $value A directory name without paths or slashes
     */
    protected function unwritableDirTest( $properties, $property, $value )
    {
        $tempDir = $this->createTempDir( get_class( $this ) );
        $path = $tempDir . DIRECTORY_SEPARATOR . $value;
        mkdir( $path );
        chmod( $path, 0444 );

        try
        {
            $properties->$property = $path;
            chmod( $path, 0777 );
            $this->removeTempDir();
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$path}' can not be opened for writing.", $e->getMessage() );
        }

        chmod( $path, 0777 );
        $this->removeTempDir();
    }
}
?>
