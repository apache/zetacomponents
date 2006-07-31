<?php
/**
 * File containing the ezcArchiveFile class.
 *
 * @package Archive
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/** 
 * The ezcArchiveFile should implement the common interface between the 
 * ezcArchiveBlockFile and ezcArchiveCharacterFile.
 *
 * @package Archive
 * @version //autogentag//
 * @access private
 */ 
abstract class ezcArchiveFile implements Iterator 
{
    /**
     * The current location in the open file.
     *
     * @var resource  
     */
    protected $fp = null;

    /**
     * True if the current file is opened read-only. 
     *
     * @var boolean  
     */
    protected $readOnly = false;

    /**
     * True when the current block is valid, otherwise false.
     *
     * @var boolean  
     */
    protected $isValid = false;

    /**
     * True when the current file does not have any blocks, otherwise false.
     * 
     * @var boolean  
     */
    protected $isEmpty;

    /** 
     * The name of the character of block file.
     *
     * @var string
     */
    protected $fileName;

    /**
     * True if the file-pointer supports seeking, otherwise false.
     * For example, files that use the bzip2 stream cannot seek.  
     *
     * @var boolean       
     */
    protected $fpIsSeekable;

    /**
     * The mode that the file is opened. 
     * For example: "r+w", "rb", etc. 
     *
     * @var string   
     */
    protected $fpMode;

    /**
     * The Uri of the file.
     *
     * @var string   
     */
    protected $fpUri;

    protected $streamFilters;

    protected $readWriteSwitch = -1;

    protected function openFile( $fileName, $createIfNotExist )
    {
        if( $createIfNotExist && !self::fileExists( $fileName ) )
        {
            $this->isEmpty = true;
            if( !self::touch( $fileName ) )
            {
                throw new ezcBaseFilePermissionException( self::getPureFileName( $fileName ), ezcBaseFilePermissionException::WRITE );
            }
        }
        
        // Try to open it in read and write mode.
        $this->fp = @fopen( $fileName, "r+b" );
        if ( !$this->fp )
        {
            // Try to open it in read-only mode.
            $this->fp = @fopen( $fileName, "rb" );
            $this->readOnly = true;
        }

        // Check if we opened the file. 
        if ( !$this->fp )
        {
            if( !self::fileExists( $fileName ) )
            {
                throw new ezcBaseFileNotFoundException( $fileName );
            }

            // Cannot read the file.
            throw new ezcBaseFilePermissionException( $fileName, ezcBaseFilePermissionException::READ );
        }

        $status =  stream_get_meta_data( $this->fp );
        
        // Set some modes.
        $this->fpIsSeekable = $status["seekable"];
        $this->fpMode = $status["mode"];
        $this->fpUri = $status["uri"];

        // Hardcode BZip2 to read-only.
        // For some reason we can open the file in read-write mode, but we cannot rewind the fp. Strange..
        if ( $status["wrapper_type"] == "BZip2" ) $this->readOnly = true;

        // Why is it read only?
        if( $this->readOnly )
        {
            if( $status["wrapper_type"] == "ZLIB" || $status["wrapper_type"] == "BZip2" ) 
            {
                // Write only mode available?
                $b = fopen( $fileName, "a" );
                if( $b !== false )
                {
                    // We have also a write-only mode. Back to the read only mode.
                    fclose( $b );

                    $this->readOnly = false;
                    $this->readWriteSwitch = 0; // Set to reading.
                }
            }
        }

        // Check if the archive is empty.
        if( fgetc( $this->fp ) === false )
        {
            $this->isEmpty = true;
        }
        else
        {
            $this->rewind();
            $this->isEmpty = false;
        }

        $this->fileName = $fileName;
    }

/*
        $this->readOnly = false;
        $this->fileName = $fileName;

        if ( $createIfNotExist && !self::fileExists( $fileName ) ) 
        {
            $this->fp = @fopen( $fileName, "w+b" );

            if ( $this->fp === false )
            {


                throw new ezcBaseFilePermissionException( $fileName, ezcBaseFilePermissionException::WRITE | ezcBaseFilePermissionException::READ, "Cannot create file for reading and writing." );
            }

            $this->isEmpty = true;
        }
        else
        {
            $this->isEmpty = false; 

            // Try to open it, even when we know that the file doesn't exist.
            $this->fp = @fopen( $fileName, "r+b" );
            if ( !$this->fp )
            {
                // Try to open readonly.
                $this->fp = @fopen( $fileName, "rb" );
                $this->readOnly = true;
            }

            if ( !$this->fp )
            {
                if ( !file_exists( $fileName ) )
                {
                    throw new ezcBaseFileNotFoundException( $fileName );
                }

                throw new ezcBaseFilePermissionException( $fileName, ezcBaseFilePermissionException::READ );
            }
        }

        $this->getStreamInformation();
 */
    //}

    /** 
     * Returns the file name or file path.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /** 
     *  Switch to write mode.
     */
    public function switchWriteMode()
    {
        // Switch only when we are in read (only) mode.
        if( $this->readWriteSwitch == 0 )
        {
            fclose( $this->fp );
            $this->fp = fopen( $this->fileName, "ab" );
            if ($this->fp === false )
            {
                throw new ezcBaseFilePermissionException( self::getPureFileName( $this->fileName ), ezcBaseFilePermissionException::WRITE, "Cannot switch to write mode");
            }
            $this->readWriteSwitch = 1;
        }
    }

    public function switchReadMode( $pos = 0)
    {
        // Switch only when we are in write (only) mode.
        if( $this->readWriteSwitch == 1 )
        {
            fclose( $this->fp );

            $this->fp = fopen( $this->fileName, "rb" );
            if ($this->fp === false )
            {
                throw new ezcBaseFilePermissionException( self::getPureFileName( $this->fileName ), ezcBaseFilePermissionException::READ, "Cannot switch back to read mode");
            }
            $this->readWriteSwitch = 0;
            $this->positionSeek( $pos );
        }
    }

    public function isReadOnlyWriteOnlyStream()
    {
        return ( $this->readWriteSwitch >= 0 );
    }



    /**
     * PHP system touch doesn't work correctly with the compress.zlib file.
     * 
     */
    public static function touch( $fileName )
    {
        return touch( self::getPureFileName( $fileName ) );
    }

    public static function fileExists( $fileName )
    {
        return file_exists( self::getPureFileName( $fileName ) );
/*
        if ( !file_exists( $fileName ) )
        {
            if ( strncmp( $fileName, "compress.zlib://", 16 ) == 0 )
            {
                return file_exists( substr( $fileName, 16) );
            }
            
            if ( strncmp( $fileName, "compress.bzip2://", 17 ) == 0 )
            {
                return file_exists( substr( $fileName, 17) );
            }
            
            return false;
        }

        return true;
 */
    }

    /**
     *  Return the file name without any filters or compression stream.
     */
    private static function getPureFileName( $fileName )
    {
        // TODO: Multistream goes wrong.
        if ( strncmp( $fileName, "compress.zlib://", 16 ) == 0 )
        {
            return substr( $fileName, 16);
        }
        
        if ( strncmp( $fileName, "compress.bzip2://", 17 ) == 0 )
        {
            return substr( $fileName, 17);
        }

        return $fileName;
    }




    /**
     * Rewind the current file, and the current() method will return the
     * data from the first block, if available.
     */
    public function rewind()
    {
        if ( !is_null( $this->fp ) )
        {
            $this->isValid = true;

            if ( !$this->fpIsSeekable )
            {
                fclose( $this->fp );
                $this->fp = fopen( $this->fpUri, $this->fpMode );
            }
            else
            {
                rewind( $this->fp );
            }

            $this->next();
        }
        else
        {
            $this->isValid = false;
        }
    }

    public function getStreamInformation()
    {
        $status =  stream_get_meta_data( $this->fp );
       // $status =  socket_get_status( $this->fp );
        $this->fpIsSeekable = $status["seekable"];
        $this->fpMode = $status["mode"];
        $this->fpUri = $status["uri"];

        // Hardcode BZip2 to read-only.
        if ( $status["wrapper_type"] == "BZip2" && !$this->readOnly ) $this->readOnly = true;
    }

    protected function positionSeek( $pos, $whence = SEEK_SET)
    {
        if ( $this->fpIsSeekable )
        {
          return fseek( $this->fp, $pos, $whence );
        }
        else
        {
            switch ( $whence )
            {
                case SEEK_SET: $transPos = $pos; break;
                case SEEK_CUR: $transPos = $pos + ftell( $this->fp ); break;
                case SEEK_END: 
                    throw new Exception( "SEEK_END in a non-seekable file is not supported (yet)." );
                    /*
                    $st = fstat( $this->fp );
                    $transPos = $pos + $st["size"]; 
                    echo ( "e" );
                    break;
                    */
            }

            $cur = ftell( $this->fp );
            if ( $transPos <  $cur )
            {
                fclose( $this->fp );
                $this->fp = fopen( $this->fpUri, $this->fpMode );

                $cur = 0;
            }
            
            for( $i = $cur; $i < $transPos; $i++)
            {
                $c = fgetc( $this->fp );
                if ( $c === false ) return -1;
            }

            return 0;
        }
    }

    public function isReadOnly()
    {
        return $this->readOnly;
    }

    public function appendStreamFilter( $filter )
    {
        $this->streamFilters[] = stream_filter_append( $this->fp, $filter );
        //var_dump ( $this->streamFilters );
    }

    public function removeStreamFilter()
    {
        stream_filter_remove( array_pop( $this->streamFilters ) );
    }
    


}


?>
