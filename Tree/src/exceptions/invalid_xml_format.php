<?php
/**
 * File containing the ezcTreeInvalidXmlFormatException class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when an XML tree document does not validate.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeInvalidXmlFormatException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidXmlFormatException.
     *
     * @param string $xmlFile
     * @param array $errors
     */
    public function __construct( $xmlFile, $errors )
    {
        $message = '';
        foreach ( $errors as $error )
        {
            $message .= sprintf( "%s:%d:%d: %s\n", $error->file, $error->line, $error->column, trim( $error->message ) );
        }
        parent::__construct( "The XML file '$xmlFile' does not validate according to the expected schema:\n". $message );
    }
}
?>
