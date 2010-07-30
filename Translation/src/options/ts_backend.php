<?php
/**
 * File containing the ezcTranslationTsBackendOptions class.
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
 * @package Translation
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Struct class to store the options of the ezcTranslationTsBackend class.
 *
 * This class stores the options for the {@link ezcTranslationTsBackend} class.
 *
 * @property string $location
 *           Path to the directory that contains all TS .xml files.
 * @property string $format
 *           Format for the translation file's name.  In this format
 *           string the special place holder [LOCALE] will be
 *           replaced with the requested locale's name. For example a
 *           format of "translations/[LOCALE].xml" will result in the
 *           filename for the translation file to be
 *           "translations/nl_NL.xml" if the nl_NL locale is
 *           requested.
 * @property bool $keepObsolete
 *           When this option is set to "true" the reader will not drop
 *           translation messages with the "obsolete" type set.
 * 
 * @package Translation
 * @version //autogentag//
 * @mainclass
 */
class ezcTranslationTsBackendOptions extends ezcBaseOptions
{
    /**
     * Constructs a new options class.
     *
     * It also sets the default values of the format property
     *
     * @param array(string=>mixed) $array The initial options to set.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    public function __construct( $array = array() )
    {
        $this->properties['format'] = '[LOCALE].xml';
        $this->properties['keepObsolete'] = false;
        parent::__construct( $array );
    }

    /**
     * Property write access.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseSettingValueException
     *         If a desired property value is out of range.
     *
     * @param string $propertyName Name of the property.
     * @param mixed $val  The value for the property.
     * @ignore
     */
    public function __set( $propertyName, $val )
    {
        switch ( $propertyName )
        {
            case 'location':
                if ( $val[strlen( $val ) - 1] != '/' )
                {
                    $val .= '/';
                }
                break;
            case 'format':
            case 'keepObsolete':
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $val;
    }
}

?>
