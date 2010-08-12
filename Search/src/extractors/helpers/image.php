<?php
/**
 * File containing the ezcSearchSimpleImage class.
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
 * @package Search
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * A sample definition for indexing images.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchSimpleImage implements ezcSearchDefinitionProvider
{
    /**
     * Id for the image.
     *
     * @var string
     */
    public $id;

    /**
     * Image title.
     *
     * @var string
     */
    public $title;

    /**
     * URL for the image.
     *
     * @var string
     */
    public $url;

    /**
     * Image width.
     *
     * @var int
     */
    public $width;

    /**
     * Image height.
     *
     * @var int
     */
    public $height;

    /**
     * Image mime-type.
     *
     * @var string
     */
    public $mime;

    /**
     * Constructs a new image definition.
     *
     * @param string $id
     * @param string $title
     * @param string $url
     * @param int $width
     * @param int $height
     * @param string $mime
     */
    public function __construct( $id = null, $title = null, $url = null, $width = null, $height = null, $mime = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
        $this->mime = $mime;
    }

    /**
     * Returns the definition of this class.
     *
     * @return ezcSearchDocumentDefinition
     */
    static public function getDefinition()
    {
        $n = new ezcSearchDocumentDefinition( 'ezcSearchSimpleImage' );
        $n->idProperty = 'id';
        $n->fields['id']        = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::TEXT );
        $n->fields['title']     = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::TEXT, 2, true, false, true );
        $n->fields['url']       = new ezcSearchDefinitionDocumentField( 'url', ezcSearchDocumentDefinition::STRING );
        $n->fields['width']     = new ezcSearchDefinitionDocumentField( 'width', ezcSearchDocumentDefinition::INT );
        $n->fields['height']    = new ezcSearchDefinitionDocumentField( 'height', ezcSearchDocumentDefinition::INT );
        $n->fields['mime']      = new ezcSearchDefinitionDocumentField( 'mime', ezcSearchDocumentDefinition::STRING );

        return $n;
    }

    /**
     * Returns the state of this definition as an array.
     *
     * @return array(string=>string)
     */
    public function getState()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'width' => $this->width,
            'height' => $this->height,
            'mime' => $this->mime,
        );
    }

    /**
     * Sets the state of this definition.
     *
     * @param array(string=>string) $state
     */
    public function setState( array $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }
}
?>
