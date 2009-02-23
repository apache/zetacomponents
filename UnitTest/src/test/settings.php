<?php
/**
 * File containing the ezcTestSettings class
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
