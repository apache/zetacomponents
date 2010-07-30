<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcTestRegressionTest extends ezcTestCase
{
    /**
     * How to sort the test files: 'mtime' sorts by modification time, any other
     * value sorts by name.
     */
    const SORT_MODE = 'name';

    protected $files = array();
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

        if ( $path === false )
        {
            return;
        }

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

    public static function suite()
    {
        return new ezcMvcRegressionSuite( __CLASS__ );
    }
}
?>
