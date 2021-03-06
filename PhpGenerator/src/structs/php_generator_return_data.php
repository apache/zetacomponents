<?php
/**
 * File containing the ezcPhpGeneratorReturnData class
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
 * @package PhpGenerator
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Holds meta-data about a function/method return data.
 *
 * ezcPhpGeneratorReturnData stores the name of the variable that should have
 * the return value of a function/method call assigned to it. It also stores the
 * type of assignment to use when assigning the return value to the specified variable.
 *
 * @package PhpGenerator
 * @version //autogentag//
 */
class ezcPhpGeneratorReturnData extends ezcBaseStruct
{
    /**
     * The type of the assignment to use. The default is a normal '=' assignment.
     * @var int One of ezcPhpGenerator:: ASSIGN_NORMAL, ASSIGN_APPEND_TEXT, ASSIGN_ADD,
     *                 ASSIGN_SUBTRACT or ASSIGN_ARRAY_APPEND.

     */
    public $type;

    /**
     * The name of the variable gets the method return value assigned to it.
     * @var string
     */
    public $variable;

    /**
     * Constructs a new PhpGeneratorReturnData.
     *
     * @param string $variable The name of the variable that should have the
     *                         return value of the function/method call assigned to it.
     * @param int $type One of ezcPhpGenerator:: ASSIGN_NORMAL, ASSIGN_APPEND_TEXT, ASSIGN_ADD,
     *                  ASSIGN_SUBTRACT or ASSIGN_ARRAY_APPEND.
     */
    public function __construct( $variable = '', $type = ezcPhpGenerator::ASSIGN_NORMAL )
    {
        $this->variable = $variable;
        $this->type = $type;
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
     * @return ezcPhpGeneratoReturnData
     */
    public static function __set_state( array $array )
    {
        return new ezcPhpGeneratorParameter( $array['variable'], $array['type'] );
    }
}
?>
