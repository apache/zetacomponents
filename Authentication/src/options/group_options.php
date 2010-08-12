<?php
/**
 * File containing the ezcAuthenticationGroupOptions class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class containing the options for group authentication filter.
 *
 * Example of use:
 * <code>
 * $options = new ezcAuthenticationGroupOptions();
 * $options->mode = ezcAuthenticationGroupFilter::MODE_AND;
 * $options->mode->multipleCredentials = false;
 *
 * // $filter1 and $filter2 are authentication filters which need all to succeed
 * // in order for the group to succeed
 * $filter = new ezcAuthenticationGroupFilter( array( $filter1, $filter2 ), $options );
 * </code>
 *
 * @property int $mode
 *           The way of grouping the authentication filters. Possible values:
 *            - ezcAuthenticationGroupFilter::MODE_OR (default): at least one
 *              filter in the group needs to succeed in order for the group to
 *              succeed.
 *            - ezcAuthenticationGroupFilter::MODE_AND: all filters in the group
 *              need to succeed in order for the group to succeed.
 * @property bool $multipleCredentials
 *           If enabled (set to true), each filter must be added to the group
 *           along with a credentials object (through the constructor or with
 *           addFilter()). By default is false (the credentials from the
 *           ezcAuthentication object are used for all filters in the group).
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationGroupOptions extends ezcAuthenticationFilterOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options Options for this class
     */
    public function __construct( array $options = array() )
    {
        $this->mode = ezcAuthenticationGroupFilter::MODE_OR;
        $this->multipleCredentials = false;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name The name of the property to set
     * @param mixed $value The new value of the property
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'mode':
                $modes = array(
                                ezcAuthenticationGroupFilter::MODE_OR,
                                ezcAuthenticationGroupFilter::MODE_AND
                              );
                if ( !in_array( $value, $modes, true ) )
                {
                    throw new ezcBaseValueException( $name, $value, implode( ', ', $modes ) );
                }
                $this->properties[$name] = $value;
                break;

            case 'multipleCredentials':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}
?>
