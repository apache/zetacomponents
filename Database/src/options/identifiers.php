<?php
/**
 * File containing the ezcDbMssqlOption class
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
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Class containing the options for MS SQL Server connections
 *
 * @property int $quoteIdentifier
 *           Mode of quoting identifiers.
 *
 * @package Database
 * @version //autogentag//
 */
class ezcDbMssqlOptions extends ezcBaseOptions
{
    /**
     * Constant represents mode of identifiers quoting that compliant to SQL92.
     * Sets QUOTED_IDENTIFIERS ON for MS SQL Server connection.
     * and treats double quotes as quoting characters for identifiers.
     *
     * @access public
     */
    const QUOTES_COMPLIANT = 0;

    /**
     * Constant represents mode of identifiers quoting that
     * corresponds to QUOTE_IDENTIFIERS OFF for MS SQL Server connection.
     * Sets QUOTED_IDENTIFIERS to OFF
     * and treats '[' and ']' as quoting characters for identifiers.
     *
     * @access public
     */
    const QUOTES_LEGACY    = 1;

    /**
     * Recommended ( and default ) mode for identifiers quoting.
     * Gets current QUOTED_IDENTIFIERS value for MS SQL Server
     * connection and changes ezcDbMssqlHandler's quoting identifier characters
     * correspondently if it's necessary. QUOTED_IDENTIFIERS value
     * for connection will not be changed.
     *
     * @access public
     */
    const QUOTES_GUESS     = 2;


    /**
     * Constant represents mode of identifiers quoting that not
     * touch any settings related to quoting identifiers.
     * Could be used for minimizing amount of requests
     * to MS SQL Server and for optimization.
     *
     *
     * @access public
     */
    const QUOTES_UNTOUCHED = 3;


    /**
     * Creates an ezcDbMssqlOptions object with default option values.
     *
     * @param array $options
     */
    public function __construct( array $options = array() )
    {
        $this->quoteIdentifier = self::QUOTES_GUESS;

        parent::__construct( $options );
    }

    /**
     * Set an option value
     *
     * @param string $propertyName
     * @param mixed $propertyValue
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @throws ezcBaseValueException
     *          If a property is out of range
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'quoteIdentifier':
                if ( !is_numeric( $propertyValue )  ||
                     ( ( $propertyValue != self::QUOTES_COMPLIANT ) &&
                       ( $propertyValue != self::QUOTES_LEGACY ) &&
                       ( $propertyValue != self::QUOTES_GUESS ) &&
                       ( $propertyValue != self::QUOTES_UNTOUCHED )
                     )
                   )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue,
                        'one of ezcDbMssqlOptions::QUOTES_COMPLIANT, QUOTES_LEGACY, QUOTES_GUESS, QUOTES_UNTOUCHED constants' );
                }

                $this->quoteIdentifier = (int) $propertyValue;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
