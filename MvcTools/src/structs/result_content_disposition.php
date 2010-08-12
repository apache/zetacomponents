<?php
/**
 * File containing the ezcMvcResultContentDisposition class
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
 * @package MvcTools
 */

/**
 * This struct contains content disposition meta-data
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResultContentDisposition extends ezcBaseStruct
{
    /**
     * The disposition type (inline or attachment)
     *
     * @var string
     */
    public $type;

    /**
     * The filename parameter, encoded as a UTF-8 string.
     *
     * @var string
     */
    public $filename;

    /**
     * The creation date parameter
     *
     * @var DateTime
     */
    public $creationDate;

    /**
     * The modification date parameter
     *
     * @var DateTime
     */
    public $modificationDate;

    /**
     * The read date parameter
     *
     * @var DateTime
     */
    public $readDate;

    /**
     * The size parameter
     *
     * @var int
     */
    public $size;

    /**
     * Constructs a new ezcMvcResultContent.
     *
     * @param string $type
     * @param string $filename
     * @param DateTime $creationDate
     * @param DateTime $modificationDate
     * @param DateTime $readDate
     * @param int $size
     */
    public function __construct( $type = 'inline', $filename = null,
        DateTime $creationDate = null, DateTime $modificationDate = null,
        DateTime $readDate = null,
        $size = null )
    {
        $this->type = $type;
        $this->filename = $filename;
        $this->creationDate = $creationDate;
        $this->modificationDate = $modificationDate;
        $this->readDate = $readDate;
        $this->size = $size;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcMvcResultContent
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcResultContent( $array['type'], $array['filename'],
            $array['creationDate'], $array['modificationDate'],
            $array['readDate'], $array['size'] );
    }
}
?>
