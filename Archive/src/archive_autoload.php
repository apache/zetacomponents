<?php
/**
 * Autoloader definition for the Archive component.
 *
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Archive
 */

return array(
    'ezcArchiveException'                 => 'Archive/exceptions/archive_exception.php',
    'ezcArchiveBlockSizeException'        => 'Archive/exceptions/archive_block_size.php',
    'ezcArchiveChecksumException'         => 'Archive/exceptions/archive_checksum.php',
    'ezcArchiveEmptyException'            => 'Archive/exceptions/archive_empty.php',
    'ezcArchiveEntryPrefixException'      => 'Archive/exceptions/archive_entry_prefix.php',
    'ezcArchiveInternalException'         => 'Archive/exceptions/archive_internal_exception.php',
    'ezcArchiveIoException'               => 'Archive/exceptions/archive_io.php',
    'ezcArchiveUnknownTypeException'      => 'Archive/exceptions/archive_unknown_type.php',
    'ezcArchiveValueException'            => 'Archive/exceptions/archive_value.php',
    'ezcArchive'                          => 'Archive/archive.php',
    'ezcArchiveV7Header'                  => 'Archive/tar/headers/tar_v7.php',
    'ezcArchiveV7Tar'                     => 'Archive/tar/v7_tar.php',
    'ezcArchiveFile'                      => 'Archive/file/file.php',
    'ezcArchiveLocalFileHeader'           => 'Archive/zip/headers/zip_local_file.php',
    'ezcArchiveUstarHeader'               => 'Archive/tar/headers/tar_ustar.php',
    'ezcArchiveUstarTar'                  => 'Archive/tar/ustar_tar.php',
    'ezcArchiveBlockFile'                 => 'Archive/file/block_file.php',
    'ezcArchiveCentralDirectoryEndHeader' => 'Archive/zip/headers/zip_central_directory_end.php',
    'ezcArchiveCentralDirectoryHeader'    => 'Archive/zip/headers/zip_central_directory.php',
    'ezcArchiveCharacterFile'             => 'Archive/file/character_file.php',
    'ezcArchiveChecksums'                 => 'Archive/utils/checksums.php',
    'ezcArchiveEntry'                     => 'Archive/entry.php',
    'ezcArchiveFileStructure'             => 'Archive/structs/file.php',
    'ezcArchiveFileType'                  => 'Archive/utils/file_type.php',
    'ezcArchiveGnuHeader'                 => 'Archive/tar/headers/tar_gnu.php',
    'ezcArchiveGnuTar'                    => 'Archive/tar/gnu_tar.php',
    'ezcArchiveOptions'                   => 'Archive/options/archive.php',
    'ezcArchivePaxHeader'                 => 'Archive/tar/headers/tar_pax.php',
    'ezcArchivePaxTar'                    => 'Archive/tar/pax_tar.php',
    'ezcArchiveStatMode'                  => 'Archive/utils/stat_mode.php',
    'ezcArchiveZip'                       => 'Archive/zip/zip.php',
);
?>
