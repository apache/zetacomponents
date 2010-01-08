<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveTestData
{
    protected $tempDir;
    protected $dataDir;
    protected $extension;
    protected $version;

    protected $usedFiles = array();
    public function __construct( $dataDir, $tempDir, $extension, $version )
    {
        $this->tempDir = $tempDir;
        $this->dataDir = $dataDir;
        $this->extension = $extension;
        $this->version = $version;
    }

    public function createTempFile( $file )
    {
        $original = dirname(__FILE__) . "/../data/$file";

        $tmpFile = $this->getTempDir() . "/$file";
        copy( $original, $tmpFile );

        return $tmpFile;
    }

    public function getFileName( $type )
    {
        $file = $this->version . "_$type." . $this->extension;

        if ( isset( $this->usedFiles[$file] ) )
        {
            return $file;
        }

        $this->usedFiles[$file] = true;
        copy( $this->dataDir . "/" . $file, $this->tempDir . "/" . $file );

        return $this->tempDir . "/" . $file;
    }

    public function getCharFile( $type )
    {
        return new ezcArchiveCharacterFile ( $this->getFileName ( $type ) );
    }

    public function getArchive( $type )
    {
        // FIXME, zip only.
        return new ezcArchiveZip( $this->getCharFile( $type ) );
    }

    public function getNewCharFile( $type )
    {
        return new ezcArchiveCharacterFile ( $type, true );
    }

    public function getNewArchive( $type )
    {
        return new ezcArchiveZip( $this->getNewCharFile( $type ) );
    }
}
?>
