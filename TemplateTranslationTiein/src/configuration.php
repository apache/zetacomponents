<?php
/**
 * File containing the ezcTemplateTranslationConfiguration class
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
 * @package TemplateTranslationTiein
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcTemplateTranslationConfiguration provides an environment for translations in templates.
 *
 * @package TemplateTranslationTiein
 * @mainclass
 * @version //autogen//
 */
class ezcTemplateTranslationConfiguration
{
    /**
     * @param ezcTemplateTranslationConfiguration Instance
     */
    static private $instance = null;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Private constructor to prevent non-singleton use
     */
    private function __construct()
    {
        $this->properties = array( 'locale' => null, 'manager' => null );
    }

    /**
     * Returns an instance of the class ezcTemplateTranslationConfiguration
     *
     * @return ezcTemplateTranslationConfiguration Instance of ezcTemplateTranslationConfiguration
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new ezcTemplateTranslationConfiguration();
        }
        return self::$instance;
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @throws ezcBaseValueException if a the value for a property is out of
     *         range.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'locale':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                break;

            case 'manager':
                if ( ( !$value instanceof ezcTranslationManager) && $value !== null )
                {
                    throw new ezcBaseValueException( $name, $value, 'instance of ezcTranslationManager or null' );
                }
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
        $this->properties[$name] = $value;
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'locale':
                return $this->properties[$name];

            case 'manager':
                if ( $this->properties[$name] === null )
                {
                    ezcBaseInit::fetchConfig( 'ezcInitTemplateTranslationManager', $this );
                }
                if ( $this->properties[$name] === null )
                {
                    throw new ezcTemplateTranslationManagerNotConfiguredException();
                }
                return $this->properties[$name];
        }
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'locale':
            case 'manager':
                return isset( $this->properties[$name] );

            default:
                return false;
        }
        // if there is no default case before:
        return parent::__isset( $name );
    }
}
?>
