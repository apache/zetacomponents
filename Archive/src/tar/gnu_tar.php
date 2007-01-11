<?php
/**
 * File contains the ezcArchiveGnuTar class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/** 
 * The ezcArchiveGnuTar class implements the GNU Tar archive format.
 *
 * ezcArchiveGnuTar is a subclass from {@link ezcArchive} that provides the common interface,
 * and {@link ezcArchiveUstarTar} that provides the basic Tar implementation.
 *
 * ezcArchiveGnuTar reads on creation only the first {@link ezcArchiveEntry entry} from the archive. 
 * When needed next entries are read.
 *
 * The Gnu Tar algorithm is an extension of Ustar Tar. Gnu has the following extended features compared to Ustar:
 * - Filenames of unlimited size.
 * - File size is unlimited.
 *
 * The current implementation allows only reading from a Gnu archive.
 *
 * The features of Gnu Tar and Pax Tar are quite similar, although their approach is different.
 *
 * @package Archive
 * @version //autogentag//
 */ 
class ezcArchiveGnuTar extends ezcArchiveUstarTar
{

    public function __construct( ezcArchiveBlockFile $file, $blockFactor = 20 ) 
    {
        parent::__construct( $file, $blockFactor );
    }

    public function getAlgorithm()
    {
        return self::TAR_GNU;
    }

    public function algorithmCanWrite()
    {
        return false;
    }

    protected function createTarHeader( $file = null)
    {
        return new ezcArchiveGnuHeader( $file );
    }
}
?>
