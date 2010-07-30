<?php
/**
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
 * @package DatabaseSchema
 */
/**
 * A container to store a field definition in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaField extends ezcBaseStruct
{
    /**
     * The type of this field
     *
     * @var string
     */
    public $type;

    /**
     * The length of this field.
     *
     * @var integer
     */
    public $length;

    /**
     * Whether this field can store NULL values.
     *
     * @var bool
     */
    public $notNull;

    /**
     * The default value for this field.
     *
     * @var mixed
     */
    public $default;

    /**
     * Whether this field is an auto increment field.
     *
     * @var bool
     */
    public $autoIncrement;

    /**
     * Whether the values for this field contain unsigned integers.
     *
     * @var bool
     */
    public $unsigned;

    /**
     * Constructs an ezcDbSchemaField object.
     *
     * @param string  $type
     * @param integer $length
     * @param bool    $notNull
     * @param mixed   $default
     * @param bool    $autoIncrement
     * @param bool    $unsigned
     */
    function __construct( $type, $length = false, $notNull = false, $default = null, $autoIncrement = false, $unsigned = false )
    {
        $this->type = (string) $type;
        $this->length = (int) $length;
        $this->notNull = (bool) $notNull;
        $this->default = $default;
        $this->autoIncrement = (bool) $autoIncrement;
        $this->unsigned = (bool) $unsigned;

        if ( $type == 'integer' && $notNull && $default === null && $autoIncrement == false )
        {
            $this->default = 0;
        }

        if ( $type == 'integer' && is_numeric( $this->default ) )
        {
            $this->default = (int) $this->default;
        }
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaField(
            $array['type'], $array['length'], $array['notNull'],
            $array['default'], $array['autoIncrement'], $array['unsigned']
        );
    }
}
?>
