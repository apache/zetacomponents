<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

include_once( 'test.php' );

include_once( 'regression_suite.php' );

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRegressionTest extends ezcFeedTestCase
{
    /**
     * How to sort the test files: 'mtime' sorts by modification time, any other
     * value sorts by name.
     */
    const SORT_MODE = 'name';

    protected $files;
    protected $currentFile;

    public function __construct()
    {
        if ( self::SORT_MODE === 'mtime' )
        {
            // Sort by modification time to get updated tests first
            usort( $this->files,
                   array( $this, 'sortTestsByMtime' ) );
        }
        else
        {
            // Sort it, then the file a.in will be processed first. Handy for development.
            usort( $this->files,
                   array( $this, 'sortTestsByName' ) );
        }

        parent::__construct();
    }

    public function getName( $withDataSet = TRUE )
    {
        return $this->currentFile;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function setCurrentFile( $file )
    {
        $this->currentFile = $file;
    }

    protected function readDirRecursively( $dir, &$total, $onlyWithExtension = false )
    {
        $extensionLength = strlen( $onlyWithExtension );
        $path = opendir( $dir );

        while ( false !== ( $file = readdir( $path ) ) )
        {
            if ( $file !== "." && $file !== ".." )
            {
                $new = $dir . DIRECTORY_SEPARATOR . $file;

                if ( is_file( $new ) )
                {
                    if ( !$onlyWithExtension ||
                         substr( $file,  -$extensionLength - 1 ) === ".{$onlyWithExtension}" )
                    {
                        $total[] = array( 'file' => $new,
                                          'mtime' => filemtime( $new ) );
                    }
                }
                elseif ( is_dir( $new ) )
                {
                    $this->readDirRecursively( $new, $total, $onlyWithExtension );
                }
            }
        }
    }

    protected function sortTestsByMtime( $a, $b )
    {
        if ( $a['mtime'] != $b['mtime'] )
        {
            return $a['mtime'] < $b['mtime'] ? 1 : -1;
        }
        return strnatcmp( $a['file'], $b['file'] );
    }

    protected function sortTestsByName( $a, $b )
    {
        return strnatcmp( $a['file'], $b['file'] );
    }

    protected function outFileName( $file, $inExtension, $outExtension = '.out' )
    {
        $baseFile = substr( $file, 0, strlen( $file ) - strlen( $inExtension ) );
        return $baseFile . $outExtension;
    }

    protected function createFeed( $type, $data )
    {
        $feed = new ezcFeed( $type );
        $supportedModules = ezcFeed::getSupportedModules();
        if ( is_array( $data ) )
        {
            foreach ( $data as $property => $value )
            {
                if ( is_array( $value ) )
                {
                    foreach ( $value as $val )
                    {
                        if ( isset( $supportedModules[$property] ) )
                        {
                            $element = $feed->addModule( $property );
                        }
                        else
                        {
                            $element = $feed->add( $property );
                        }
                        if ( is_array( $val ) )
                        {
                            foreach ( $val as $subKey => $subValue )
                            {
                                if ( $subKey === '#' )
                                {
                                    $element->set( $subValue );
                                }
                                else if ( $subKey === 'MULTI' )
                                {
                                    foreach ( $subValue as $multi )
                                    {
                                        foreach ( $multi as $subSubKey => $subSubValue )
                                        {
                                            if ( isset( $supportedModules[$subSubKey] ) )
                                            {
                                                $subElement = $element->addModule( $subSubKey );
                                            }
                                            else
                                            {
                                                $subElement = $element->add( $subSubKey );
                                            }

                                            $subElement->set( $subSubValue );
                                        }
                                    }
                                }
                                else
                                {
                                    if ( is_array( $subValue ) )
                                    {
                                        if ( count( $subValue ) === 0 || !isset( $subValue[0] ) )
                                        {
                                            if ( isset( $supportedModules[$subKey] ) )
                                            {
                                                $subElement = $element->addModule( $subKey );
                                            }
                                            else
                                            {
                                                $subElement = $element->add( $subKey );
                                            }
                                        }

                                        foreach ( $subValue as $subSubKey => $subSubValue )
                                        {
                                            if ( $subSubKey === '#' )
                                            {
                                                $subElement->set( $subSubValue );
                                            }
                                            else
                                            {
                                                if ( is_array( $subSubValue ) )
                                                {
                                                    if ( isset( $supportedModules[$subKey] ) )
                                                    {
                                                        $subElement = $element->addModule( $subKey );
                                                    }
                                                    else
                                                    {
                                                        $subElement = $element->add( $subKey );
                                                    }
                                                    foreach ( $subSubValue as $subSubSubKey => $subSubSubValue )
                                                    {
                                                        if ( $subSubSubKey === '#' )
                                                        {
                                                            $subElement->set( $subSubSubValue );
                                                        }
                                                        else
                                                        {
                                                            if ( is_array( $subSubSubValue ) )
                                                            {
                                                                foreach ( $subSubSubValue as $subSubSubSubKey => $subSubSubSubValue )
                                                                {
                                                                    $subSubElement = $subElement->add( $subSubSubKey );
                                                                    foreach ( $subSubSubSubValue as $subSubSubSubSubKey => $subSubSubSubSubValue )
                                                                    {
                                                                        if ( $subSubSubSubSubKey === '#' )
                                                                        {
                                                                            $subSubElement->set( $subSubSubSubSubValue );
                                                                        }
                                                                        else
                                                                        {
                                                                            $subSubElement->$subSubSubSubSubKey = $subSubSubSubSubValue;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $subElement->$subSubSubKey = $subSubSubValue;
                                                            }
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $subElement->$subSubKey = $subSubValue;
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $element->$subKey = $subValue;
                                    }
                                }
                            }
                        }
                        else
                        {
                            $element->set( $val );
                        }
                    }
                }
                else
                {
                    $feed->$property = $value;
                }
            }
        }

        return $feed;
    }

    public function runTest()
    {
        if ( $this->currentFile === false )
        {
            throw new PHPUnit_Framework_ExpectationFailedException( "No currentFile set for test " . __CLASS__ );
        }

        $exception = null;
        $this->retryTest = true;
        while ( $this->retryTest )
        {
            try
            {
                $this->retryTest = false;
                $this->testRunRegression( $this->currentFile );
            }
            catch ( Exception $e )
            {
                $exception = $e;
            }
        }

        if ( $exception !== null )
        {
            throw $exception;
        }
    }
}
?>
