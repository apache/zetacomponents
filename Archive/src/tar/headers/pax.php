<?php
/**
 * File contains the ezcArchivePaxHeader class.
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
 * @access private
 */

/**
 * The ezcArchivePaxHeader class represents the Tar Pax header.
 *
 * ezcArchivePaxHeader can read the header from an ezcArchiveBlockFile or ezcArchiveEntry.
 *
 * The values from the headers are directly accessible via the class properties, and allows
 * reading and writing to specific header values.
 *
 * The entire header can be appended to an ezcArchiveBlockFile again or written to an ezcArchiveFileStructure.
 * Information may get lost, though.
 *
 * The header is the {@link ezcArchiveUstarHeader} with extra header information described on the following webpage:
 * {@link http://www.opengroup.org/onlinepubs/009695399/utilities/pax.html}
 *
 * Currently, only the extended header is supported.
 *
 * @package Archive
 * @version //autogentag//
 * @access private
 */
class ezcArchivePaxHeader extends ezcArchiveUstarHeader
{
    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @return void
     * @ignore
     */
    public function __set( $name, $value )
    {
        return parent::__set( $name, $value );
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        return parent::__get( $name );
    }

    /**
     * Returns an array with pax header information.
     *
     * This method reads an extended set of data from the ezcArchiveBlockFile
     * $file and returns the values in an array.
     *
     * @param ezcArchiveBlockFile $file
     * @return array(string=>string)
     */
    protected function getPaxDecodedHeader( ezcArchiveBlockFile $file )
    {
        $result = array();

        // next block has the info.
        $file->next();

        $data = $file->current();

        $offset = 0;

        while ( strcmp( $data[$offset], "\0" ) != 0 )
        {
            $space = strpos( $data, " ", $offset );

            $length = substr( $data, $offset, $space - $offset );
            $equalSign = strpos( $data, "=",  $space );

            $keyword = substr( $data, $space + 1, $equalSign - $space - 1 );

            $value = rtrim( substr( $data, $equalSign + 1, $length - $equalSign - 1 ), "\n" );

            $result[ $keyword ] = $value;

            $offset += $length;
        }

        return $result;
    }

    /**
     * Creates and initializes a new header.
     *
     * If the ezcArchiveBlockFile $file is null then the header will be empty.
     * When an ezcArchiveBlockFile is given, the block position should point to the header block.
     * This header block will be read from the file and initialized in this class.
     *
     * @param ezcArchiveBlockFile $file
     */
    public function __construct( ezcArchiveBlockFile $file = null )
    {
        if ( !is_null( $file ) )
        {
            parent::__construct( $file );

            if ( $this->type == "x" )
            {
                $paxArray = $this->getPaxDecodedHeader( $file );
                $file->next();
            }

            parent::__construct( $file );

            // Override some fields.
            foreach ( $paxArray as $key => $value )
            {
                switch ( $key )
                {
                    case "gid":
                        $this->groupId = $value;
                        break;  // For group IDs larger than 2097151.

                    case "linkpath":
                        $this->linkName = $value;
                        break;  // Long link names?

                    case "path":
                        $this->fileName = $value;
                        $this->filePrefix = "";
                        break; // Really long file names.

                    case "size":
                        $this->size = $value;
                        break;  // For files with a size greater than 8589934591 bytes.

                    case "uid":
                        $this->userId = $value;
                        break;  // For user IDs larger than 2097151.
                }
            }
        }
    }
}
?>
