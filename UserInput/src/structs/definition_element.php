<?php
/**
 * File containing the ezcInputFormDefinitionElement struct
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
 * @package UserInput
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This struct records information about Input Form definition elements.
 *
 * @package UserInput
 * @version //autogentag//
 * @mainclass
 */
class ezcInputFormDefinitionElement extends ezcBaseStruct
{
    /**
     * @var OPTIONAL marks an input field as "optional". Optional input fields
     *               do not throw errors if they are not available while
     *               parsing input variables.
     */
    const OPTIONAL = 0;

    /**
     * @var REQUIRED marks an input field as "required". When a required input
     *               variable is not available while parsing input variables,
     *               the __construct will throw the UserInputMissingData
     *               exception.
     */
    const REQUIRED = 1;

    /**
     * Whether the field is optional or required. One of the self::OPTIONAL or
     * self::REQUIRED constants.
     *
     * @var int
     */
    public $type = self::OPTIONAL;

    /**
     * The name of the filter to use for this definition element.
     *
     * @var string
     */
    public $filterName = 'string';

    /**
     * The extra options to this filter.
     *
     * @var mixed
     */
    public $options = false;

    /**
     * The extra flags to this filter.
     *
     * @var mixed
     */
    public $flags = false;

    /**
     * A short hint to be shown to the user about the constraint of an input element, e.g.
     * 'between 0 and 100', 'valid email' or 'no specialchars'
     *
     * @var string
     */
    public $hint = '';

    /**
     * Constructs a definition item.
     *
     * Constructs the definition item with all its options and flags.
     *
     * @param int $type
     * @param string $filterName
     * @param mixed $options
     * @param int $flags
     * @param string $hint
     */
    public function __construct( $type = ezcInputFormDefinitionElement::OPTIONAL, $filterName = 'string', $options = null, $flags = null, $hint = '' )
    {
        $this->type = $type;
        $this->filterName = $filterName;
        $this->options = $options;
        $this->flags = $flags;
        $this->hint = $hint;
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
     * @return ezcInputFormDefinitionElement
     * @ignore
     */
    public static function __set_state( array $array )
    {
        return new ezcInputFormDefinitionElement( $array['type'], $array['filterName'], $array['options'], $array['flags'], $array['hint'] );
    }
}
?>
