<?php
/**
 * File containing the ezcArchiveUstarTar class.
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
 * @package Archive
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
    /**
     * Initializes the Tar and tries to read the first entry from the archive.
     *
     * At initialization it sets the blockFactor to $blockFactor. Each tar archive
     * has always $blockFactor of blocks ( 0, $blockFactor, 2 * $blockFactor, etc ).
     *
     * The Tar archive works with blocks, so therefore the first parameter expects
     * the archive as a blockFile.
     *
     * @param ezcArchiveBlockFile $blockFile
     * @param int $blockFactor
     */
    public function __construct( ezcArchiveBlockFile $blockFile, $blockFactor = 20 )
    {
        parent::__construct( $blockFile, $blockFactor );
    }

    /**
     * Returns the value which specifies a TAR_USTAR algorithm.
     *
     * @return int
     */
    public function getAlgorithm()
    {
        return self::TAR_USTAR;
    }

    /**
     * Returns true because the TAR_USTAR algorithm can write.
     *
     * @see isWritable()
     *
     * @return bool
     */
    public function algorithmCanWrite()
    {
        return true;
    }

    /**
     * Creates the a new ustar tar header for this class.
     *
     * This method expects an {@link ezcArchiveBlockFile} that points to the header that should be
     * read (and created). If null is given as  block file, an empty header will be created.
     *
     * @param string|null $file
     * @return ezcArchiveUstarHeader
     */
    protected function createTarHeader( $file = null)
    {
        return new ezcArchiveUstarHeader( $file );
    }
}
?>
