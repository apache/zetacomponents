<?php
/**
 * File containing the ezcTreeVisitorXHTMLOptions class.
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
 * Class containing the options for the ezcTreeVisitorXHTMLOptions class.
 *
 * @property string $basePath
 *           Which string to prefix the href-targets with.
 * @property bool $addLinks
 *           Whether links should be generated or not.
 * @property bool $displayRootNode
 *           Whether the root node should be displayed. The root node will
 *           still be disabled from the links that the visitor creates when
 *           $selectedNodeLink is set to true.
 * @property string $xmlId
 *           The ID that should be set on the top level 'ul' XHTML tag.
 * @property array(string) $highlightNodeIds
 *           Which IDs should have the 'highlight' CSS class added.
 * @property array(string) $subtreeHighlightNodeIds
 *           Which subtree IDs should have the 'highlight' CSS class added.
 * @property bool $selectedNodeLink
 *           If enabled, only the requested node is shown in links, and not the full path.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeVisitorXHTMLOptions extends ezcBaseOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->basePath = '';
        $this->addLinks = true;
        $this->displayRootNode = false;
        $this->xmlId = null;
        $this->highlightNodeIds = array();
        $this->subtreeHighlightNodeIds = array();
        $this->selectedNodeLink = false;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'basePath':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                $this->properties[$name] = $value;
                break;

            case 'addLinks':
            case 'displayRootNode':
            case 'selectedNodeLink':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;

            case 'highlightNodeIds':
            case 'subtreeHighlightNodeIds':
                if ( !is_array( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'array(string)' );
                }
                $this->properties[$name] = $value;
                break;

            case 'xmlId':
                if ( !is_null( $value ) && !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'null or string' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>
