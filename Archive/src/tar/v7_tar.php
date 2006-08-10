<?php
/**
 * File contains the ezcArchiveV7Tar class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/** 
 * The ezcArchiveV7Tar class implements the Tar v7 archive format.
 *
 * ezcArchiveV7Tar is a subclass from {@link ezcArchive} that provides the common interface.
 * Tar v7 algorithm specific methods are implemented in this class.
 *
 * ezcArchiveV7Tar reads on creation only the first {@link ezcArchiveEntry} from the archive. 
 * When needed next entries are read.
 *
 * The V7 Tar algorithm is most basic implementation of Tar. This format has the following characteristics:
 * - Filenames up to 100 characters.
 * - Stores the file permissions.
 * - Stores the owner and group by ID.
 * - Stores the last modification time.
 * - Can archive: regular files and symbolic links. 
 * - Maximum file size: 8 Gygabyte.
 *
 * @package Archive
 * @version //autogentag//
 */ 
class ezcArchiveV7Tar extends ezcArchive
{
    /**
     * Amount of bytes in a block.
     */
    const BLOCK_SIZE = 512;

    /**
     * Tar archives have always $blockFactor of blocks.
     * 
     * @var int
     */
    protected $blockFactor = 20;

    /**
     * Stores all the headers from the archive. 
     *
     * The first header of the archive has index zero. The ezcArchiveV7Header or a subclass from this header 
     * is stored in the array. {@link createTarHeader()} will create the correct header.
     * 
     * @var array(ezcArchiveV7Header)
     */
    protected $headers;

    /**
     * Stores the block number where the header starts.
     *
     * The fileNumber is the index of the array.
     *
     * @var array(int)
     */ 
    protected $headerPositions;

    protected $hasNullBlocks;


    protected $addedBlocks = 0;
    protected $addedBlocksNotReliable = false;


    /**
     * Initializes the Tar and tries to read the first entry from the archive.
     *
     * At initialization it sets the blockFactor to $blockFactor. Each tar archive
     * has always $blockFactor of blocks ( 0, $blockFactor, 2 * $blockFactor, etc ).
     * 
     * The Tar archive works with blocks, so therefore the first parameter expects
     * the archive as a blockFile. 
     * 
     * @param ezcArchiveBlockFile $file
     * @param int $blockFactor
     */
    public function __construct( ezcArchiveBlockFile $file, $blockFactor = 20 ) 
    {
        $this->blockFactor = $blockFactor;
        $this->file = $file;

        $this->headers = array();
        $this->headerPositions = array();

        $this->entriesRead = 0;
        $this->fileNumber = 0;

        $this->hasNullBlocks = $this->file->isNew() ?  false : true;
        $this->addedBlocks = 0;

        if( $this->file->getFileAccess() !== ezcArchiveFile::WRITE_ONLY) $this->readCurrentFromArchive();
    }

    public function __destruct()
    {
        $this->close();
    }

    // Documentation is inherited.
    public function getAlgorithm()
    {
        return self::TAR_V7;
    }

    // Documentation is inherited.
    public function algorithmCanWrite()
    {
        return true;
    }

    /**
     * Creates the a new tar header for this class.
     * 
     * Usually this class is reimplemented by other Tar algorithms, and therefore it returns another Tar 
     * header. 
     *
     * This method expects an {@link ezcArchiveBlockFile} that points to the header that should be
     * read (and created). If null is given as  block file, an empty header will be created.
     *
     * @param $file  
     * @return ezcArchiveV7Header  The ezcArchiveV7Header or a subclass is returned.
     */
    protected function createTarHeader( $file = null )
    {
        return new ezcArchiveV7Header( $file );
    }

    /**
     * Read the current entry from the archive.
     *
     * The current entry from the archive is read, if possible. This method will set the {@link $completed} 
     * to true, if the end of the archive is reached. The {@link $entriesRead} will be increased, if the 
     * entry is correctly read.
     *
     * @return void
     */
    protected function readCurrentFromArchive()
    {
        // Not cached, read the next block.
        if ( $this->entriesRead == 0 )
        {
            $this->file->rewind();
            if ( !$this->file->isEmpty() && !$this->file->valid() )
            {
                throw new ezcArchiveBlockSizeException( $this->file->getFileName(),  "At least one block expected in tar archive" );
            }
        }
        else
        {
            // Search the new block.
            $newBlock = $this->headerPositions[ $this->fileNumber - 1 ] +  $this->file->getBlocksFromBytes( $this->headers[ $this->fileNumber - 1 ]->fileSize );

            // Search for that block.
            if ( $newBlock != $this->file->key() )
            {
                $this->file->seek( $newBlock );
            }

            // Read the new block.
            $this->file->next();
        }

        // This might be a null block.
        if ( !$this->file->valid() || $this->file->isNullBlock() )
        {
            $this->completed = true;
            return false;
        }

        $this->headers[ $this->fileNumber ] = $this->createTarHeader( $this->file ); 
        $this->headerPositions[ $this->fileNumber ] = $this->file->key();

        // Set the currentEntry information.
        $struct = new ezcArchiveFileStructure(); 
        $this->headers[ $this->fileNumber ]->setArchiveFileStructure( $struct );
        $this->entries[ $this->fileNumber ] = new ezcArchiveEntry( $struct );

        $this->entriesRead++;

        return true;
    }

    // Documentation is inherited.
    protected function writeCurrentDataToFile( $targetPath )
    {
        if ( !$this->valid() ) return false;

        $requestedBlock = $this->headerPositions[$this->fileNumber];
        $currentBlock = $this->file->key();
        if ( $currentBlock != $requestedBlock ) $this->file->seek( $requestedBlock );

        $header = $this->headers[ $this->fileNumber ];

        if ( $header->fileSize > 0 )
        {
            $completeBlocks = ( int ) ( $header->fileSize / self::BLOCK_SIZE );
            $rest = ( $header->fileSize % self::BLOCK_SIZE );

            //  Write to file
            $fp = fopen( $targetPath, "w" );

            for( $i = 0; $i < $completeBlocks; $i++ )
            {
                fwrite( $fp, $this->file->next() );
            }

            fwrite( $fp, $this->file->next(), $rest );
            fclose( $fp );
         }
         else
         {
             touch( $targetPath );
         }

         return true;
    }

    // Documentation is inherited.
    public function truncate( $fileNumber = 0)
    {
        if( $this->file === null ) throw new ezcArchiveException( "The archive is closed" );

        if ($this->file->getFileAccess() === ezcArchiveFile::READ_ONLY || !$this->algorithmCanWrite())
        {
            throw new ezcBaseFilePermissionException( $this->file->getFileName(), ezcBaseFilePermissionException::WRITE, "Archive is read-only" );
        }

        $originalFileNumber = $this->fileNumber;
        $this->hasNullBlocks = false;
        $this->addedBlocksNotReliable = true;

        // Entirely empty the file.
        if ( $fileNumber == 0 )
        {
            $this->file->truncate();

            $this->entriesRead = 0;
            $this->fileNumber = 0;
            $this->completed = true;
        }
        else
        {
            $this->seek( $fileNumber ); // read the headers.
            $endBlockNumber = $this->headerPositions[ $fileNumber - 1 ] +  $this->file->getBlocksFromBytes( $this->headers[ $fileNumber - 1 ]->fileSize );

            if ( $endBlockNumber === false )
            {
                return false;
            }

            if( !$this->file->truncate ( $endBlockNumber + 1 ) )
            {
                throw new ezcArchiveException( "The archive cannot be truncated to " . ($endBlockNumber + 1) . " block(s). ".
                                               "This happens with write-only files or stream (e.g. compress.zlib) ");
            }

            $this->entriesRead = $fileNumber;
            $this->completed = true;
            $this->fileNumber = $originalFileNumber;

            return $this->valid();
        }
    }

    // Documentation is inherited.
    public function appendToCurrent( $files, $prefix )
    {
        if( $this->file === null ) throw new ezcArchiveException( "The archive is closed" );
        
        if ($this->file->getFileAccess() !== ezcArchiveFile::READ_WRITE )
        {
            throw new ezcArchiveException( "Cannot appendToCurrent when writing to a read-only, write-only stream (e.g. compress.zlib)." );
        }

        if ($this->file->getFileAccess() === ezcArchiveFile::READ_ONLY || !$this->algorithmCanWrite())
        {
            throw new ezcBaseFilePermissionException( $this->file->getFileName(),  ezcBaseFilePermissionException::WRITE );
        }

        $entries = $this->getEntries( $files, $prefix);
        $originalFileNumber = $this->fileNumber;

        for( $i = 0; $i < sizeof( $files ); $i++)
        {
            // Changes the fileNumber
            $this->appendHeaderAndFileToCurrent( $entries[$i] );
        }

        $this->fileNumber = $originalFileNumber;
        return $this->valid();
    }


    /** 
     * Append a file or directory to the end of the archive. Multiple files or directory can 
     * be added to the archive when an array is used as input parameter.
     *
     * @see appendToCurrent()
     *
     * @throws ezcArchiveWriteException  if one of the files cannot be written to the archive.
     * @throws ezcFileReadException      if one of the files cannot be read from the local filesystem.
     *
     * @param string|array(string) $entries  Add the files and or directories to the archive.
     *
     * @return void
     */
    public function append( $files, $prefix)
    {
        if( $this->file === null ) throw new ezcArchiveException( "The archive is closed" );

        if ($this->file->getFileAccess() === ezcArchiveFile::READ_ONLY || !$this->algorithmCanWrite())
        {
            throw new ezcArchiveException( "Archive is read-only" );
        }

        // Appending to an existing archive with a compressed stream does not work because we have to remove the NULL-blocks. 
        if( $this->hasNullBlocks && $this->file->getFileAccess() !== ezcArchiveFile::READ_WRITE )
        {
            throw new ezcArchiveException( "Cannot append to this archive" );
        }

        // Existing files need to be read, because we don't know if it contains NULL-blocks at the end of the archive.
        if( $this->file->getFileAccess() !== ezcArchiveFile::WRITE_ONLY )
            $this->seek( 0, SEEK_END );

        // Do the same as in appendToCurrent(). But we know that it's possible.
        $entries = $this->getEntries( $files, $prefix);
        $originalFileNumber = $this->fileNumber;

        for( $i = 0; $i < sizeof( $files ); $i++)
        {
            // Changes the fileNumber
            $this->appendHeaderAndFileToCurrent( $entries[$i] );
        }

        $this->fileNumber = $originalFileNumber;
        return $this->valid();
     }


    public function close()
    {
        if( $this->file !== null )
        {
            $this->writeEnd();

            $this->file->close();
            $this->file = null;
        }
    }

    public function writeEnd()
    {
        if( $this->file === null ) throw new ezcArchiveException( "The archive is closed" );

        if( $this->file->isModified() )
        {
            if( !$this->hasNullBlocks )
            {
                if( $this->addedBlocksNotReliable )
                {
                    $this->appendNullBlocks();
                }
                else
                {
                    // Added Blocks  -  Added null blocks (Block factor 20)
                    // 0             -  0
                    // 1             - 19
                    // 19            - 1
                    // 20            - 0
                    // 21            - 19
                    $nullBlocks = ($this->blockFactor - ($this->addedBlocks % $this->blockFactor ) ) % $this->blockFactor;
                    $this->file->appendNullBlock( $nullBlocks );
                }

                $this->hasNullBlocks = true;
                $this->addedBlocksNotReliable = false;
                $this->addedBlocks = 0;
            }
        }
    }

    /**
     * Appends the given {@link ezcArchiveBlockFile} $file and {@link ezcArchiveEntry} $entry 
     * to the archive file. 
     *
     * The $entry will be used to create the correct header, whereas the $file contains the raw data 
     * that should be append to the archive. 
     *
     * @param string $file
     * @param ezcArchiveEntry $entry
     * @return void
     */
    protected function appendHeaderAndFileToCurrent( $entry )
    {
        // Are we at a valid entry?
        if ( !$this->isEmpty() && !$this->valid() ) return false;

        if ( !$this->isEmpty() && $this->file->getFileAccess() !== ezcArchiveFile::WRITE_ONLY)
        {
            // Truncate the next file and don't add the null blocks.
            $this->truncate( $this->fileNumber + 1, false );
        }

        if ( $this->entriesRead == 0 ) $this->fileNumber = 0; else $this->fileNumber++;

        // Add the new header to the file map.
        $this->headers[ $this->fileNumber ] = $this->createTarHeader(); 
        $this->headers[ $this->fileNumber ]->setHeaderFromArchiveEntry( $entry );

        // Search the end of the block file, append encoded header, and search for the end-again.
        $this->file->seek( 0, SEEK_END );
        $this->headers[$this->fileNumber]->writeEncodedHeader( $this->file );

        // Add the new blocknumber to the map.
        $this->headerPositions[$this->fileNumber] = $this->file->key();

        // Append the file, if needed.
        $this->addedBlocks += 1;
        if ( $entry->getSize() > 0 ) 
        {
            $this->addedBlocks += $this->file->appendFile( $entry->getPath() );
        }

        if(!( $this->file->isNew() && $this->file->getFileAccess() === ezcArchiveFile::WRITE_ONLY  ))
        {
            $this->addedBlocksNotReliable = true;
        }

        $this->hasNullBlocks = false;
        $this->completed = true;
        $this->entriesRead++;

        $this->entries[$this->fileNumber] = $entry;
        return true;
    }

    /**
     * Appends zero or more null blocks to the end of the archive, so that it matches the $blockFactor.
     *
     * If the archive has already the correct size, no null blocks will be appended. Otherwise as many
     * null blocks are appended (up to $blockFactor - 1) so that it matches the $blockFactor.
     * @return void
     */
    protected function appendNullBlocks()
    {
        $last = 0;
        if( $this->file->getLastBlockNumber() == -1 )
        {
            if( !$this->file->valid() )
            {
                $this->file->rewind();
            }
     
            while( $this->file->valid() )
            {
                $last = $this->file->key();
                $this->file->next();
            }
        }
        else
        {
            $last = $this->file->getLastBlockNumber();
        }

        $this->file->seek( $last );

        // Go to the end.
        /*
         */
       
        //echo ("Last block: " . $this->file->getLastBlockNumber() );

        // Need a ftell in the seek. 
        //$this->file->seek( 0, SEEK_END );
        
            $blockNumber =  $last;

            // 0  .. 19 => first block.
            // 20 .. 39 => second block.
            // e.g: 20 - ( 35 % 20 ) - 1 = 19 - 15 = 4
            $append = $this->blockFactor - ( $blockNumber % $this->blockFactor ) - 1;
            $this->file->appendNullBlock( $append );
    }
}
?>
