<?php
/**
 * Autoloader definition for the Archive component.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Archive
 */

return array(
    'ezcArchiveException'                 => 'Archive/exceptions/exception.php',
    'ezcArchiveBlockSizeException'        => 'Archive/exceptions/block_size.php',
    'ezcArchiveChecksumException'         => 'Archive/exceptions/checksum.php',
    'ezcArchiveEmptyException'            => 'Archive/exceptions/empty.php',
    'ezcArchiveEntryPrefixException'      => 'Archive/exceptions/entry_prefix.php',
    'ezcArchiveInternalException'         => 'Archive/exceptions/internal_exception.php',
    'ezcArchiveIoException'               => 'Archive/exceptions/io.php',
    'ezcArchiveUnknownTypeException'      => 'Archive/exceptions/unknown_type.php',
    'ezcArchiveValueException'            => 'Archive/exceptions/value.php',
    'ezcArchive'                          => 'Archive/archive.php',
    'ezcArchiveV7Header'                  => 'Archive/tar/headers/v7.php',
    'ezcArchiveV7Tar'                     => 'Archive/tar/v7.php',
    'ezcArchiveFile'                      => 'Archive/file/file.php',
    'ezcArchiveLocalFileHeader'           => 'Archive/zip/headers/local_file.php',
    'ezcArchiveUstarHeader'               => 'Archive/tar/headers/ustar.php',
    'ezcArchiveUstarTar'                  => 'Archive/tar/ustar.php',
    'ezcArchiveBlockFile'                 => 'Archive/file/block_file.php',
    'ezcArchiveCallback'                  => 'Archive/interfaces/callback.php',
    'ezcArchiveCentralDirectoryEndHeader' => 'Archive/zip/headers/central_directory_end.php',
    'ezcArchiveCentralDirectoryHeader'    => 'Archive/zip/headers/central_directory.php',
    'ezcArchiveCharacterFile'             => 'Archive/file/character_file.php',
    'ezcArchiveChecksums'                 => 'Archive/utils/checksums.php',
    'ezcArchiveEntry'                     => 'Archive/entry.php',
    'ezcArchiveFileStructure'             => 'Archive/structs/file.php',
    'ezcArchiveFileType'                  => 'Archive/utils/file_type.php',
    'ezcArchiveGnuHeader'                 => 'Archive/tar/headers/gnu.php',
    'ezcArchiveGnuTar'                    => 'Archive/tar/gnu.php',
    'ezcArchiveOptions'                   => 'Archive/options/archive.php',
    'ezcArchivePaxHeader'                 => 'Archive/tar/headers/pax.php',
    'ezcArchivePaxTar'                    => 'Archive/tar/pax.php',
    'ezcArchiveStatMode'                  => 'Archive/utils/stat_mode.php',
    'ezcArchiveZip'                       => 'Archive/zip/zip.php',
);
?>
