<?php
/**
 * File containing the ezcTestSettings class
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
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * This object stores the settings from the TestRunner.
 *
 * Every TestCase can get the instance of this object, and access the settings. 
 * 
 * @package UnitTest
 * @version //autogentag//
 */
class ezcTestSettings
{
   /**
     * Holds the properties
     */
    private $properties = array();

    /**
     * Holds the one and only instance of this object.
     */
    private static $instance = null;

    /**
     * Use the getInstance() method instead to get an instance of this class.
     */
    private function __construct()
    {
        $this->properties['db'] = new ezcTestDatabaseSettings;
    }

    /**
     * Returns an instance of this class.
     */
	public static function getInstance()
	{
        if ( is_null( ezcTestSettings::$instance ))
        {
            ezcTestSettings::$instance = new ezcTestSettings();
        }

        return ezcTestSettings::$instance;
	}

    /** 
     * No properties can be set.
     * @ignore
     */
   public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'db':
               trigger_error( "Property: db is read-only", E_USER_ERROR );
               break;
        }
    }

    /**
     * The db property can be read.
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'db':
                return $this->properties['db'];
            default:
                return parent::__get( $name );
        }
    }

    /**
     * Set all the database settings via a given settings array.
     */
    public function setDatabaseSettings( $settings )
    {
        $settingNames = array(
            'dsn', 'phptype', 'dbsyntax', 'username', 'password', 'protocol',
            'hostspec', 'port', 'socket', 'database'
        );
        foreach ( $settingNames as $settingName )
        {
            if ( isset( $settings[$settingName] ) )
            {
                $this->properties['db']->$settingName = $settings[$settingName];
            }
        }
    }
}
?>
