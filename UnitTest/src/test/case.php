<?php

require_once 'PHPUnit2/Framework/TestCase.php';

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter( __FILE__ );

abstract class ezcTestCase extends PHPUnit2_Framework_TestCase
{
    /**
     * Do not mess with the temp dir, otherwise the removeTempDirectory might
     * remove the wrong directory.
     */
    private $tempDir;

    public function __construct( $string = "" )
    {
        parent::__construct( $string );
    }

    public function setUp()
    {
        return parent::setUp();
    }

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
                        $this->removeRecursively( $this->tempDir . "/" . $file );
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
                        $this->removeRecursively( $entry . "/" . $file );
                    }
                }

                closedir( $dh );
                rmdir( $entry );
            }
        }
    }

    /**
     * Checks if the property $propertyName in object $object contains the correct value $expectedValue.
     * Before fetching the value it checks that $object is an object and that the property exists.
     *
     * @param $object The object containing the property $propertyName
     * @param $propertyName The name of the property to access.
     * @param $expectedValue The value the property is expected to have.
     *
     * @see assertSame(), assertPrivatePropertySame(), assertProtectedPropertySame()
     */
    public function assertPropertySame( $object, $propertyName, $expectedValue )
    {
        self::assertTrue( is_object( $object ),
                          "Parameter <\$object> must be an object, got: <" . gettype( $object ) . ">" );
        self::assertSame( true, isset( $object->$propertyName ),
                          "Property <$propertyName> does not exist on object <" . get_class( $object ) . ">." );
        self::assertSame( $expectedValue, $object->$propertyName,
                          "Property <$propertyName> does not return correct value from object <" . get_class( $object ) . ">." );
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
                return;
            }
            $this->fail( "Setting property $propertyName to $value did not fail." );
        }
    }

    /**
     * Asserts that the compared images are similar
     *
     * Uses the compare binary of the imagemagick package to compare to images
     * and will fail if the difference between two images is higher then the
     * defined value.
     *
     * See http://www.imagemagick.org/script/compare.php for details. The 
     * difference is logarithmical scaled.
     * 
     * @param string $image New image
     * @param string $expectedImage Image to compare with
     * @param string $message Message to append to the fail message
     * @param int $maxDifference Maximum difference between images
     * @access public
     * @return void
     */
    public function assertImageSimilar( $image, $expectedImage, $message = '', $maxDifference = 0 )
    {
        $constraint = new ezcTestConstraintSimilarImage( $expectedImage, $maxDifference );

        if ( ! $constraint->evaluate( $image ) ) {
            self::failConstraint( $constraint, $image, $message );
        }
    }

    /*
     * @todo recheck this later, as this might change again.
     */
    // public static abstract function suite();
}
?>
