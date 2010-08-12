<?php
/**
 * File containing the ezcSearchResultDocument class.
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
 * The struct contains the result as parsed by the different search handlers.
 *
 * @package Search
 * @version //autogentag//
 * @mainclass
 */
class ezcSearchResultDocument
{
    /**
     * Document score
     *
     * @var float
     */
    public $score;

    /**
     * Document itself
     *
     * @var object(mixed)
     */
    public $document;

    /**
     * The highlighted fields
     *
     * The index is the field name, and the value the highlighted value.
     *
     * @var array(string=>string)
     */
    public $highlight;

    /**
     * Contructs a new ezcSearchResultDocument.
     *
     * @param float $score
     * @param object(mixed) $document
     * @param array(string=>string) $highlight
     */
    public function __construct( $score = 0, $document = null, $highlight = array() )
    {
        $this->score = $score;
        $this->document = $document;
        $this->highlight = $highlight;
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
     * @return ezcSearchResult
     */
    static public function __set_state( array $array )
    {
        return new ezcSearchResultDocument(
            $array['score'], $array['document'], $array['highlight']
        );
    }
}
?>
