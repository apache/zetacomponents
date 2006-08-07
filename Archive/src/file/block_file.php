<?php
/**
 * File contains the ezcArchiveBlockFile class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/** 
 * The ezcArchiveBlockFile class provides an interface for reading from and writing to a block file.
 *
 * A block file is a file that consist of zero or more blocks. Each block has a predefined amount
 * of bytes known as the block-size. The block file implements the Iterator interface. Via the methods
 * 
 * - key()
 * - valid()
 * - current()
 * - rewind()
 *
 * can single blocks be accessed. The append(), appendToCurrent() method, appends and possibly removes 
 * blocks from and to the file.
 *
 * The block-file takes the necessary measurements to read and write to a compressed stream.
 *
 * The following example stores 16 bytes in 4 blocks. The current() points to the second block: 1.
 * <code>
 *  ---- ---- ---- ---- 
 * |0 1 | 5 6| 9 0| 3 4|
 * |2 4 | 7 8| 1 2| 5 6|
 *  ---- ---- ---- ---- 
 *   0    1    2    3    
 *
 *        ^         ^
 *        |         \ LastBlock
 *
 *     Current      
 * </code>
 * 
 *
 * @package Archive
 * @version //autogentag//
 * @access private
 */ 
class ezcArchiveBlockFile extends ezcArchiveFile 
{
    /**
     * The block size.
     *
     * @var int
     */
    private $blockSize;

    /**
     * The current number of the block. 
     *
     * The first block starts with zero.
     *
     * @var int  
     */
    private $blockNumber = -1;

    /**
     * The current block data.
     *
     * @var string  
     */
    private $blockData;

    private $lastBlock = -1;

    /**
     * Sets the property $name to $value.
     * 
     * Because there are no properties available, this method will always 
     * throw an {@link ezcBasePropertyNotFoundException}.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Returns the property $name.
     * 
     * Available read-only property: blockSize
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case "blockSize": return $this->blockSize;
        }

        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Constructs a new ezcArchiveBlockFile. 
     *
     * The given file name is tried to be opened in read / write mode. If that fails, the file will be opened
     * in read-only mode.
     *
     * If the bool $createIfNotExist is set to true, it will create the file if it doesn't exist. 
     *
     * @throws ezcBaseFileNotFoundException if the file cannot be found.
     * @throws ezcBaseFilePermissionException if the file permissions are wrong.
     *
     * @param string $fileName
     * @param bool $createIfNotExist
     * @param int $blockSize 
     *
     */
    public function __construct( $fileName, $createIfNotExist = false, $blockSize = 512 )
    {
        $this->blockSize = $blockSize;

        $this->openFile( $fileName, $createIfNotExist );
    }


    /** 
     * The destructor will close all open files. 
     */ 
    public function __destruct()
    {
        if ( $this->fp )
        {
            fclose( $this->fp );
        }
    }

    /**
     * Rewind the current file. 
     *
     * @return void
     */
    public function rewind()
    {
        $this->blockNumber = -1;
        
        parent::rewind();
    }

    /**
     * Return the data from the current block if the block is valid. 
     *
     * If the block is not valid, the value false is returned.
     *
     * @return string
     */
    public function current()
    {
        return ( $this->isValid ? $this->blockData : false );
    }

    /**
     * Iterate to the next block.
     * 
     * Returns the data of the next block if it exists; otherwise returns false.
     *
     * @return string  
     */
    public function next()
    {
        if ( $this->isValid  )
        {
            // XXX move the calc to readmode? 
            //$this->switchReadMode( ( $this->blockNumber + 1 ) * $this->blockSize );
            
            // Read one block.
            $this->blockData = fread( $this->fp, $this->blockSize );

            if ( strlen( $this->blockData ) < $this->blockSize )
            {
                if( $this->lastBlock != -1 ) 
                {
                    if( $this->blockNumber != $this->lastBlock )
                    {
                        die ("Something weird happened with the blockNumber. Lastblock number registered at " . $this->lastBlock . " but changed into " . $this->blockNumber );
                    }
                }
                $this->lastBlock = $this->blockNumber;
                $this->isValid = false;
                return false;
            }
            $this->blockNumber++;

            return $this->blockData;
        }

        return false;
    }

    /**
     * Returns the key, the current block number of the current element. 
     *
     * The first block has the number zero. 
     * 
     * @return int 
     */
    public function key()
    {
        return ( $this->isValid ? $this->blockNumber : false );
    }

    /**
     * Returns true if the current block is valid, otherwise false.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->isValid;
    }

    /**
     * Returns true if the current block is a null block, otherwise false. 
     * 
     * A null block is a block consisting of only NUL characters. 
     * If the current block is invalid, this method will return false. 
     *
     * @return bool 
     */
    public function isNullBlock()
    {
        if ( $this->isValid )
        {
            for( $i = 0; $i < $this->blockSize; $i++ )
            {
                if ( ord( $this->blockData[$i] ) != 0 )
                    return false;
            }
            return true;
        }
        
        return false;
    }

    /**
     * Appends the string $data after the current block.
     * 
     * The blocks after the current block are removed and the $data will be 
     * appended. The data will always be appended after the current block. 
     * To replace the data from the first block, the truncate() method should 
     * be called first. 
     * 
     * Multiple blocks will be written when the length of the $data exceeds
     * the block size. If the data doesn't fill an entire block, the rest 
     * of the block will be filled with NUL characters.
     *
     * @param   string  $data  Data that should be appended.
     * @return int        The total amount of blocks added.
     * 
     * @throws  ezcBaseFilePermissionException when the file is opened in read-only mode.
     */
    public function append( $data )
    {
        if ( $this->readOnly ) 
        {
            throw new ezcBaseFilePermissionException( $this->fileName, ezcBaseFilePermissionException::WRITE, "The archive is opened in a read-only mode." );
        }

        if( !$this->isEmpty && $this->isValid)
        {
            $needToTruncate = true;
            $currentBlock = $this->blockNumber;
            // Do we need to truncate the file?

            // Check if we already read the entire file. This way is quicker to check.
            if( $this->lastBlock != -1 )
            {
                // Last block is known. 
                if( $this->lastBlock == $this->blockNumber )
                {
                    // We are at the last block.
                    $needToTruncate = false;
                }
            }
            else
            {
                // The slower method. Check if we can read the next block.
                if( !$this->next() )
                {
                    // We got a next block. 
                    $needToTruncate = false;
                }
            }

            if( $needToTruncate )
            {
                if( $this->readWriteSwitch >= 0 )
                {
                    // Sorry, don't know how to truncate this file (except copying everything).
                    throw new ezcArchiveException( "Cannot truncate the file" );
                }

                echo ("\nNEED TO TRUNCATE\n");

                if( $this->blockNumber < $this->lastBlock ) 
                {
                echo ("blocknumber: " . $this->blockNumber ."\n");
                echo ("Last block: " . $this->lastBlock ."\n" );

                    die ("\nHello,  NO need to truncate. But why are we not at the last block? \n\n" );
                }
                $pos = $currentBlock * $this->blockSize;
                ftruncate( $this->fp, $pos );

                $this->lastBlock = $currentBlock;
                $this->blockNumber = $currentBlock;
            }
        }
        else
        {
            if( !$this->isEmpty && !$this->isValid ) 
            {
                echo ("WARNING, should not append to a non-empty, non-valid block. Assuming the end.\n");
                //throw new ezcArchiveException ("Not at a valid block position to append");
            }
        }

        // We are at the end of the file. Let's append the data.
        // Switch write mode, if needed.
        $this->switchWriteMode();

        $dataLength = sizeof( $data );
        $length = $this->writeBytes( $data );

        if ( ( $mod = ( $length % $this->blockSize ) ) > 0 )
        {
            $this->writeBytes( pack( "a". ( $this->blockSize  - $mod ), "") );
        }

//        echo ("\nLength " . $length );
//        echo ("\nmod " . $mod );
//        echo ("\nbs " . $this->blockSize );

        //$addedBlocks = ( (int) ($length / $this->blockSize ) ) + 1;
        //$addedBlocks = ( (int) (($length + $this->blockSize - $mod) / $this->blockSize ) );
        $addedBlocks = ( (int) (($length - 1) / $this->blockSize ) ) + 1;

        // Added the blocks. 
        $this->isModified = true;
        $this->isEmpty = false;

        $this->blockNumber += $addedBlocks;
        $this->lastBlock += $addedBlocks;
        $this->blockData = $data;
        $this->isValid = true;

        $this->switchReadMode();

        return $addedBlocks;


       /*
        $currentPos = ftell($this->fp );
        if( $currentPos == false ) $currentPos = 0;
        $lastBlock = $this->lastBlock  < 0 ? 0 : $this->lastBlock;
         */

        // XXX = SOLVE IT WITH BLOCK NUMBERS..
        // IF we are not at the end; and have to switch to write mode, we cannot append.
        
        // XXX append should switch back to readMode.
        
        //$this->switchWriteMode();

        // Always at the end?

/*
        if( $this->lastBlock != $this->blockNumber )
        {
            echo ("LAST BLOCK: " . $this->lastBlock . "\n" );
            echo ("BLOCK NUmber: " . $this->blockNumber . "\n" );
            ftruncate( $this->fp, ftell( $this->fp ) );
        }
 */

        /*
        if ( $lastBlock * $this->blockSize != $currentPos )
        {
            ftruncate( $this->fp, ftell( $this->fp ) );
        }
         */

    }

    /**
     * Write the given string $data to the current file.
     *
     * This method tries to write the $data to the file. Upon failure, this method
     * will retry, until no progress is made anymore. And eventually it will throw
     * an exception. Sometimes an (invalid) interrupt may stop the writing process.
     *
     * @throws ezcBaseFileIoException if it is not possible to write to the file.
     * 
     * @param string data
     * @return void
     */
    protected function writeBytes( $data )
    {
        $dl = strlen( $data );
        if ( $dl == 0 ) return; // No bytes to write.
        
        $wl = fwrite( $this->fp, $data );

        // Partly written? For example an interrupt can occur when writing a remote file.
        while ( $dl > $wl && $wl != 0 )
        {
            // retry, until no progress is made.
            $data = substr( $data, $wl );

            $dl = strlen( $data );
            $wl = fwrite( $this->fp, $data );
        }

        if ( $wl == 0 )
        {
            throw new ezcBaseFileIoException ( $this->fileName, ezcBaseFileIoException::WRITE, "Retried to write, but no progress was made. Disk full?" ); 
        }

        return $wl;
    }

    /**
     * Appends one block with only NUL characters to the file.
     *
     * @throws ezcBaseFilePermissionException if the file is opened in read-only mode.
     * 
     * @return void
     */
    // XXX rename to appendNullBlocks
    public function appendNullBlock( $amount = 1 )
    {
        $this->append( pack( "a". ( $amount * $this->blockSize ), "" ) );
    }
 

    /**
     * Truncate the current block file to $block blocks. 
     * 
     * If $blocks is zero, the entire block file will be truncated. After the file is truncated,
     * make sure the current block position is valid. So, do a rewind() after
     * truncating the entire block file.
     *
     * @param int $blocks 
     * @return void
     */
    public function truncate( $blocks = 0 )
    {
        // Empty files don't need to be truncated.
        if( $this->isEmpty() ) return true;

        if( $this->readWriteSwitch < 0 )
        {
            // We can read-write in the file. Easy.
            $pos = $blocks * $this->blockSize;
            ftruncate( $this->fp, $pos );
            $this->isModified = true;
            if ( $pos == 0 )
            {
                $this->isEmpty = true;
            }
            
            if ( $this->blockNumber >= $blocks )
            {
                $this->isValid = false;
            }

            $this->lastBlock = $blocks - 1;

            return true;
       }
        
        //
        // Truncate the whole file.
        if( $blocks == 0 )
        {
            die("Truncate whole file");
        }

        // Truncate at the end?

        if( !$this->isValid )
        {
            $this->rewind();
        }

        // XXX check this, can be done via getLastBlockNumber() ? 
        while( $this->isValid && $blocks > $this->blockNumber ) $this->next();

        if( $this->isValid )
        {
            die ("CANNOT TRUNCATE 1234RAY");
        }

        return true;


/*

        // Some where in the middle.
        

        // If we are not at a valid position or we are too far in the file then rewind.
        if( !$this->isValid || $blocks < $this->blockNumber) $this->rewind();

        // Read the next block.
        while ( $blocks < $this->blockNumber  ) $this->next();

        // XXX Do the position trick. We cannot truncate in the middle anyway.




        if( $this->lastBlock == -1 )
        {
            // Didn't read the entire file, yet.




        }


       

        // Since we can only read or only write to the file, we have some limitations.
        if( $this->readWriteSwitch >= 0 )
        {

            if( $blocks == 0 )
            {
                $this->isEmpty = true;
                die ("TRUNCATING TO ZERO: FIX" );
            }

            // XXX Check if we want to truncate after the last block. In that case, we don't truncate at all.
            if ( !$this->valid() )
            {
               $this->rewind();
            }

            $this->next();
            while( $this->next() && $blocks > $this->blockNumber );

            if( $blocks > $this->blockNumber ) 
            {
                return true;
            }

            return false;
        }

        /*
        // Maybe we just want to write to the next block.
        if( $blocks == $this->blockNumber + 1 )
        {
            if( $this->next() === false )
            {
                // Perfect, we are at the last block.

                $this->lastBlock = $blocks; 
                
                echo ("JA");
                return true;
            }
        }
         */
/*
        $pos = $blocks * $this->blockSize;
        ftruncate( $this->fp, $pos );

        if ( $pos == 0 )
        {
            $this->isEmpty = true;
        }
        
        if ( $this->blockNumber > $blocks )
        {
            $this->isValid = false;
        }

        $this->lastBlock = $blocks;

        return true;
 */
    }
    

    /**
     * Sets the current block position. 
     * 
     * The new position is obtained by adding the $blockOffset amount of blocks to 
     * the position specified by $whence. 
     *
     * These values are: 
     *  SEEK_SET: The first block,
     *  SEEK_CUR: The current block position,
     *  SEEK_END: The last block.
     *
     * The blockOffset can be negative.
     *
     * @param int $blockOffset  
     * @param int $whence
     * @return void
     */
    public function seek( $blockOffset, $whence = SEEK_SET )
    {
        if( ftell( $this->fp ) === false || $this->readWriteSwitch >= 0)
        {
            // Okay, cannot tell the current file position. 
            // This happens with some compression streams. 

            if( !$this->isValid ) 
            {
                if( $whence == SEEK_CUR )
                {
                    throw new ezcArchiveException("Cannot seek SEEK_CUR with an invalid block position");
                }

                $this->rewind();
            }

            if( $whence == SEEK_END && $this->lastBlock == -1 )
            {
                if( $blockOffset > 0 ) 
                {
                    die ("This requires us to read the file twice. Try not to do this");
                }

                // Go to the end.
                while( $this->next() ); 


                // We are a bit too far. Sneak back position.
                //die( "SNEAK BACK");
                //SHOULD GO GREIT
            }

            switch($whence )
            {
                case SEEK_CUR:  $searchBlock = $this->blockNumber += $blockOffset; break;
                case SEEK_END:  $searchBlock = $this->lastBlock += $blockOffset; break;
                case SEEK_SET:  $searchBlock = $blockOffset; break;
            }

            if( $searchBlock < $this->blockNumber )
            {
                $this->rewind();
            }

            while( $this->isValid && $this->blockNumber < $searchBlock ) $this->next();

            return ( $this->blockNumber == $searchBlock );
        }
        else
        {
            $this->isValid = true;

            $pos = $this->blockSize * $blockOffset;
            if ( $whence == SEEK_END || $whence == SEEK_CUR )
            {
                if ( !$this->isEmpty() ) 
                {
                    $pos -= $this->blockSize;
                }
            }

            if ( !( $whence == SEEK_SET && $pos == ftell( $this->fp ) ) )
            {
                $this->positionSeek( $pos, $whence );
            }

            if( ftell( $this->fp ) === false )
            {
                throw new ezcArchiveException( "Cannot tell the current position, but this is after the position seek. " );
            }

            $this->blockNumber = $this->getBlocksFromBytes( ftell( $this->fp ) ) - 1; 
            $this->next(); // Will set isValid to false, if blockfile is empty.
        }
    }

    /**
     * Calculates the blocks for the given $bytes.
     *
     * @param  int $bytes
     * @return int
     */
    public function getBlocksFromBytes( $bytes ) 
    {
        return (int) ceil ($bytes  / $this->blockSize );
    }

    /**
     *  Returns true if the blockfile is empty, otherwise false.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->isEmpty;
    }

    public function getLastBlockNumber()
    {
        return $this->lastBlock;
    }
}
?>
