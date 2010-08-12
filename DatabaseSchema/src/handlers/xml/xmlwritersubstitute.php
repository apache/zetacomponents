<?php
/**
 * File containing the XMLWriter class.
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
 * @package DatabaseSchema
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This class implements a quick and dirty fallback in the case the PHP extension XMLWriter is not available.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @access private
 */
class XMLWriter
{
    private $elementStack;
    private $uriFs = false;
    
    public function __construct()
    {
        $this->elementStack = array();
    }

    public function openUri( $filename )
    {
        $this->uriFs = fopen( $filename, 'w' );
        return $this->uriFs;
    }

    public function startDocument( $version, $charset = 'utf-8' )
    {
        fputs( $this->uriFs, "<?xml version='$version' encoding='$charset' ?>\n" );
    }

    public function startElement( $name )
    {
        fputs( $this->uriFs, "<$name>" );
        array_push( $this->elementStack, $name );
    }

    public function endElement()
    {
        $name = array_pop( $this->elementStack );
        fputs( $this->uriFs, "</$name>" );
    }

    public function text( $text )
    {
        fputs( $this->uriFs, $text );
    }

    public function endDocument()
    {
        fclose( $this->uriFs );
    }

    public function flush()
    {
        fputs( $this->uriFs, "\n" );
    }

    public function setIndent( $switch )
    {
    }
}
?>
