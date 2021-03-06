<?php
/**
 * Struct which holds a file bundled with the request.
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
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRequestFile extends ezcBaseStruct
{    
    /**
     * File mimetype.
     * 
     * @var string
     */
    public $mimeType;

    /**
     * File name.
     * 
     * @var string
     */
    public $name;

    /**
     * File size.
     * 
     * @var int
     */
    public $size;

    /**
     * Status of the upload.
     * 
     * @link http://php.net/manual/en/features.file-upload.errors.php
     * @var mixed
     */
    public $status;

    /**
     * Temporary file path.
     * 
     * @var string
     */
    public $tmpPath;

    /**
     * Constructs a new ezcMvcRequestFile with mime type $mimeType, name $name, size $size, status $status, and tmpPath $tmpPath..
     *
     * @param string $mimeType File mime type.
     * @param string $name File name.
     * @param int $size File size.
     * @param int $status File upload status.
     * @param string $tmpPath File temporary path.
     * @return void
     */
    public function __construct( $mimeType, $name, $size, $status, $tmpPath )
    {
        $this->mimeType = $mimeType;
        $this->name     = $name;
        $this->size     = $size;
        $this->status   = $status;
        $this->tmpPath  = $tmpPath;
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
     * @return ezcMvcRequestFile
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRequestFile( $array['mimeType'], $array['name'], $array['size'], $array['status'], $array['tmpPath'] );
    }
}
?>
