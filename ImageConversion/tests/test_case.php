<?php
require_once 'PHPUnit/Util/Filter.php';
PHPUnit_Util_Filter::addFileToFilter(__FILE__);

class ezcImageConversionTestCase extends ezcImageTestCase
{

    const DEFAULT_SIMILARITY_GAP = 10;

    protected static $tempDirs = array();

    protected $testFiles = array();

    protected $tempPath;

    protected $referencePath;

    public function __construct( $string = "" )
    {
        parent::__construct( $string );
        $dataDir = dirname( __FILE__ ) . "/data";
        foreach ( glob( "$dataDir/*" ) as $testFile )
        {
            if ( !is_file( $testFile ) )
            {
                continue;
            }
            $pathInfo = pathinfo( $testFile );
            $this->testFiles[basename( $pathInfo["basename"], "." . $pathInfo["extension"] )] = realpath( $testFile );
        }
        $this->testFiles["nonexistent"] = "nonexistent.jpg";
        $this->referencePath = "$dataDir/compare";
    }

    public function __destruct()
    {
        if ( sizeof( glob( "{$this->tempPath}/*" ) ) === 0 )
        {
            $this->removeTempDir();
        }
    }

    protected function getTempPath( $index = "" )
    {
        return "{$this->getTempBasePath()}/{$this->getTestName( $index )}";
    }

    protected function getReferencePath( $index = "" )
    {
        return "{$this->referencePath}/{$this->getTestName( $index )}";
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
