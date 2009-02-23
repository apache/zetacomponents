<?php
/**
 * ezcImageConversionTestCase
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for ImageConversion tests.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @subpackage Tests
 */
class ezcImageConversionTestCase extends ezcTestImageCase
{
    // To regenerate all test files, set this to true
    const REGENERATION_MODE = false;

    // Set this to false to keep the temporary test dirs
    const REMOVE_TEMP_DIRS = true;

    const DEFAULT_SIMILARITY_GAP = 10;

    protected static $tempDirs = array();

    protected $testFiles = array();

    protected $referencePath;

    public function __construct()
    {
        parent::__construct();
        $dataDir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data';
        foreach ( glob( $dataDir . DIRECTORY_SEPARATOR . '*' ) as $testFile )
        {
            if ( !is_file( $testFile ) )
            {
                continue;
            }
            $pathInfo = pathinfo( $testFile );
            $this->testFiles[basename( $pathInfo["basename"], "." . $pathInfo["extension"] )] = realpath( $testFile );
        }
        $this->testFiles["nonexistent"] = "nonexistent.jpg";
        $this->referencePath = $dataDir . DIRECTORY_SEPARATOR . 'compare';
    }

    public function __destruct()
    {
        if ( ezcImageConversionTestCase::REMOVE_TEMP_DIRS === true )
        {
            $this->removeTempDir();
            unset( ezcImageConversionTestCase::$tempDirs[get_class( $this )] );
        }
    }

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gd' ) )
        {
            $this->markTestSkipped( 'ext/gd is required to run this test.' );
        }
    }

    protected function getTempPath( $index = "" )
    {
        return ezcImageConversionTestCase::REGENERATION_MODE === true
            ? $this->referencePath . DIRECTORY_SEPARATOR . $this->getTestName( $index )
            : $this->getTempBasePath() . DIRECTORY_SEPARATOR . $this->getTestName( $index );
    }

    protected function getReferencePath( $index = "" )
    {
        return $this->referencePath . DIRECTORY_SEPARATOR . $this->getTestName( $index );
    }

    private function getTestName ( $index )
    {
        $trace = debug_backtrace();
        if ( !isset( $trace[2]["class"] ) || !isset( $trace[2]["function"] ) )
        {
            $this->fail( "BROKEN TEST CASE. MISSING OBJECT OR FUNCTION IN BACKTRACE" );
        }
        return $trace[2]["class"] . "_" . $trace[2]["function"] . $index;
    }

    private function getTempBasePath()
    {
        if ( !isset( ezcImageConversionTestCase::$tempDirs[get_class( $this )] ) )
        {
            ezcImageConversionTestCase::$tempDirs[get_class( $this )] = $this->createTempDir( get_class( $this ) );
        }
        return ezcImageConversionTestCase::$tempDirs[get_class( $this )];
    }
}

?>
