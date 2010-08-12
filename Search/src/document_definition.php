<?php
/**
 * File containing the ezcSearchDefinitionDocument class.
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
 * The struct contains a document definition.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchDocumentDefinition
{
    /**
     * Type for string fields.
     */
    const STRING = 1;

    /**
     * Type for text fields.
     */
    const TEXT = 2;

    /**
     * Type for HTML fields.
     */
    const HTML = 3;

    /**
     * Type for date fields.
     */
    const DATE = 4;

    /**
     * Type for integer fields.
     */
    const INT = 5;

    /**
     * Type for floating point fields.
     */
    const FLOAT = 6;

    /**
     * Type for boolean fields.
     */
    const BOOLEAN = 7;

    /**
     * Contains the document type - which is the same as the class name.
     *
     * @var string
     */
    public $documentType;

    /**
     * Contains the id property. This one is required.
     *
     * @var string
     */
    public $idProperty = null;

    /**
     * Contains the field name of the default search field.
     *
     * @var string
     */
    public $defaultField = null;

    /**
     * Contains an array of field definitions
     *
     * The array key also contains the name of the field
     *
     * @var array(string=>ezcSearchDefinitionDocumentField)
     */
    public $fields = array();

    /**
     * Creates a new ezcSearchDocumentDefinition for document type $documentType.
     *
     * @param string $documentType
     */
    public function __construct( $documentType )
    {
        $this->documentType = $documentType;
    }

    /**
     * Returns a list with all the field names
     *
     * @return array(string)
     */
    public function getFieldNames()
    {
        return array_keys( $this->fields );
    }

    /**
     * Returns all the field names that should appear in the search result
     *
     * @return array(string)
     */
    public function getSelectFieldNames()
    {
        $fields = array();
        foreach ( $this->fields as $name => $def )
        {
            if ( $def->inResult )
            {
                $fields[] = $name;
            }
        }
        return $fields;
    }

    /**
     * Returns all the field names that should appear in the highlighted fields
     *
     * @return array(string)
     */
    public function getHighlightFieldNames()
    {
        $fields = array();
        foreach ( $this->fields as $name => $def )
        {
            if ( $def->highlight )
            {
                $fields[] = $name;
            }
        }
        return $fields;
    }
}
?>
