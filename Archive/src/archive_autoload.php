<?php
/**
 * Autoload map for Archive package. 
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array( "ezcArchive"               =>  "Archive/archive.php",
              "ezcArchiveEntry"          =>  "Archive/archive_entry.php",

              "ezcArchiveFile"           =>  "Archive/file/file.php",
              "ezcArchiveBlockFile"      =>  "Archive/file/block_file.php",
              "ezcArchiveCharacterFile"  =>  "Archive/file/character_file.php",
 
              "ezcArchiveFileStructure"  =>  "Archive/file_structure.php",
 
              "ezcArchiveV7Tar"          =>  "Archive/tar/v7_tar.php",
              "ezcArchiveUstarTar"       =>  "Archive/tar/ustar_tar.php",
              "ezcArchivePaxTar"         =>  "Archive/tar/pax_tar.php",
              "ezcArchiveGnuTar"         =>  "Archive/tar/gnu_tar.php",
 
              "ezcArchiveZip"            =>  "Archive/zip/zip.php",
 
              "ezcArchiveException"         =>  "Archive/exceptions/archive_exception.php",
              "ezcArchiveFileException"     =>  "Archive/exceptions/file_exception.php",
              "ezcArchiveValueException"     =>  "Archive/exceptions/archive_value.php",
              "ezcArchiveEmptyException"     =>  "Archive/exceptions/archive_empty.php",
              "ezcArchiveUnknownTypeException"     =>  "Archive/exceptions/archive_unknown_type.php",
              "ezcArchiveEntryPrefixException"     =>  "Archive/exceptions/archive_entry_prefix.php",
              "ezcArchiveChecksumException"     =>  "Archive/exceptions/archive_checksum.php",
              "ezcArchiveBlockSizeException"     =>  "Archive/exceptions/archive_block_size.php",
              "ezcArchiveIoException"     =>  "Archive/exceptions/archive_io.php",
              "ezcArchiveInternalException"     =>  "Archive/exceptions/archive_internal_exception.php",
 
              "ezcArchiveLocalFileHeader"            =>  "Archive/zip/headers/zip_local_file.php",
              "ezcArchiveCentralDirectoryHeader"     =>  "Archive/zip/headers/zip_central_directory.php",
              "ezcArchiveCentralDirectoryEndHeader"  =>  "Archive/zip/headers/zip_central_directory_end.php",
 
              "ezcArchiveV7Header"          =>  "Archive/tar/headers/tar_v7.php",
              "ezcArchiveUstarHeader"       =>  "Archive/tar/headers/tar_ustar.php",
              "ezcArchivePaxHeader"         =>  "Archive/tar/headers/tar_pax.php",
              "ezcArchiveGnuHeader"         =>  "Archive/tar/headers/tar_gnu.php",
 
              "ezcArchiveStatMode"          =>  "Archive/stat_mode.php",
              "ezcArchiveChecksums"         =>  "Archive/checksums.php",
              "ezcArchiveMime"              =>  "Archive/archive_mime.php"
            );


?>
