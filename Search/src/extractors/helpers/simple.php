<?php
/**
 * File containing the ezcSearchSimpleArticle class.
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
 * A sample definition for indexing articles.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchSimpleArticle implements ezcSearchDefinitionProvider, ezcBasePersistable
{
    /**
     * Id for the article.
     *
     * @var string
     */
    public $id;

    /**
     * Article title.
     *
     * @var string
     */
    public $title;

    /**
     * Article body.
     *
     * @var string
     */
    public $body;

    /**
     * Published date for the article.
     *
     * @var DateTime
     */
    public $published;

    /**
     * URL for the article.
     *
     * @var string
     */
    public $url;

    /**
     * Article type.
     *
     * @var string
     */
    public $type;

    /**
     * Constructs a new image definition.
     *
     * @param string $id
     * @param string $title
     * @param string $body
     * @param DateTime $published
     * @param string $url
     * @param string $type
     */
    public function __construct( $id = null, $title = null, $body = null, $published = null, $url = null, $type = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->published = $published;
        $this->url = $url;
        $this->type = $type;
    }

    /**
     * Returns the definition of this class.
     *
     * @return ezcSearchDocumentDefinition
     */
    static public function getDefinition()
    {
        $n = new ezcSearchDocumentDefinition( 'ezcSearchSimpleArticle' );
        $n->idProperty = 'id';
        $n->fields['id']        = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::TEXT );
        $n->fields['title']     = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::TEXT, 2, true, false, true );
        $n->fields['body']      = new ezcSearchDefinitionDocumentField( 'body', ezcSearchDocumentDefinition::TEXT, 1, false, false, true );
        $n->fields['published'] = new ezcSearchDefinitionDocumentField( 'published', ezcSearchDocumentDefinition::DATE );
        $n->fields['url']       = new ezcSearchDefinitionDocumentField( 'url', ezcSearchDocumentDefinition::STRING );
        $n->fields['type']      = new ezcSearchDefinitionDocumentField( 'type', ezcSearchDocumentDefinition::STRING, 0, true, false, false );

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
            'body' => $this->body,
            'published' => $this->published,
            'url' => $this->url,
            'type' => $this->type,
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
