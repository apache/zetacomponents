<?php
/**
 * File containing the ezcArchiveUstarTar class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/** 
 * The ezcArchiveUstarTar class implements the Tar ustar archive format.
 *
 * ezcArchiveUstarTar is a subclass from {@link ezcArchive} that provides the common interface,
 * and {@link ezcArchiveV7Tar} that provides the basic Tar implementation.
 *
 * ezcArchiveUstarTar reads on creation only the first {@link ezcArchiveEntry entry} from the archive. 
 * When needed next entries are read.
 *
 * The Ustar Tar algorithm is an extension of V7 Tar. Ustar has the following extended features:
 * - Filenames up to 255 characters.
 * - Stores the owner and group by ID and Name.
 * - Can archive: regular files, symbolic links, hard links, fifo's, and devices. 
 *
 * @package Archive
 * @version //autogentag//
 */ 
class ezcArchiveUstarTar extends ezcArchiveV7Tar implements Iterator
{
    // Documentation is inherited.
    public function __construct( ezcArchiveBlockFile $blockFile, $blockFactor = 20 ) 
    {
        parent::__construct( $blockFile, $blockFactor );
    }

    // Documentation is inherited.
    public function getAlgorithm()
    {
        return self::TAR_USTAR;
    }

    // Documentation is inherited.
    public function algorithmCanWrite()
    {
        return true;
    }
 
    // Documentation is inherited.
    protected function createTarHeader( $file = null)
    {
        return new ezcArchiveUstarHeader( $file );
    }

    
}
?>
