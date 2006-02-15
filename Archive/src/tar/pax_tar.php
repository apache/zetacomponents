<?php

/**
 * File containing the ezcArchiveTar class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/** 
 * The ezcArchivePaxTar class implements the Tar pax or posix archive format.
 *
 * ezcArchivePaxTar is a subclass from {@link ezcArchive} that provides the common interface,
 * and {@link ezcArchiveUstarTar} that provides the basic Tar implementation.
 *
 * ezcArchivePaxTar reads on creation only the first {@link ezcArchiveEntry entry} from the archive. 
 * When needed next entries are read.
 *
 * The Pax Tar algorithm is an extension of Ustar Tar. Pax has the following extended features compared to Ustar:
 * - Filenames of unlimited size.
 * - File size is unlimited.
 *
 * The current implementation allows only reading from a Pax archive.
 *
 * @package Archive
 * @version //autogentag//
 */ 
class ezcArchivePaxTar extends ezcArchiveUstarTar
{
    // Documentation is inherited.
    public function __construct( ezcArchiveBlockFile $blockFile, $blockFactor = 20 ) 
    {
        parent::__construct( $blockFile, $blockFactor );
    }

    // Documentation is inherited.
    public function getAlgorithm()
    {
        return self::TAR_PAX;
    }

    // Documentation is inherited.
    public function algorithmCanWrite()
    {
        return false;
    }
 
    // Documentation is inherited.
    protected function createTarHeader( $file = null )
    {
        return new ezcArchivePaxHeader( $file );
    }
}
?>
