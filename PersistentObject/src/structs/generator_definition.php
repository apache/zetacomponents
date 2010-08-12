<?php
/**
 * File containing the ezcPersistentGeneratorDefinition class.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package PersistentObject
 */
/**
 * Defines a persistent object id generator.
 *
 * For more information on how to use this class see
 * {@link ezcPersisentObjectIdProperty}
 *
 * @version //autogen//
 * @package PersistentObject
 */
class ezcPersistentGeneratorDefinition extends ezcBaseStruct
{
    /**
     * The name of the class implementing the generator.
     *
     * @var string
     */
    public $class;

    /**
     * Any parameters required by the generator.
     *
     * Parameters should be in the format array('parameterName' => parameterValue )
     *
     * @var array(string=>string)
     */
    public $params;

    /**
     * Constructs a new PersistentGeneratorDefinition where $class contains
     * name of the class to load and $params contains a list of parameters
     * provided to the constructor of that class.
     *
     * @param string $class
     * @param array $params
     */
    public function __construct( $class, array $params = array() )
    {
        $this->class = $class;
        $this->params = $params;
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
     * @return ezcPersistentGeneratorDefinition
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentGeneratorDefinition( $array['class'],
                                                     $array['params'] );
    }
}
?>
