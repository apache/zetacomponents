<?php
/**
 * File containing the ezcConsoleOutputOptions class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct class to store the options of the ezcConsoleOutput class.
 *
 * This class stores the options for the {@link ezcConsoleOutput} class.
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleOutputOptions
{
    /**
     * Determines the level of verbosity. 
     * 
     * @var int
     */
    protected $verbosityLevel = 1;

    /**
     * Determines, whether text is automatically wrapped after a specific amount
     * of characters in a line. If set to 0 (default), lines will not be wrapped
     * automatically.
     * 
     * @var int
     */
    protected $autobreak = 0;

    /**
     * Wether to use formatting or not. 
     * 
     * @var bool
     */
    protected $useFormats = true;

    /**
     * Create a new ezcConsoleOutputOptions struct. 
     * Create a new ezcConsoleOutputOptions struct for use with {@link ezcConsoleOutput}. 
     * 
     * @param int $verbosityLevel Verbosity of the output to show.
     * @param int $autobreak    Auto wrap lines after num chars (0 = unlimited)
     * @param bool $useFormats  Whether to enable formated output
     * @return void
     */
    public function __construct( $verbosityLevel = 1, $autobreak = 0, $useFormats = true )
    {
        $this->verbosityLevel = $verbosityLevel;
        $this->autobreak = $autobreak;
        $this->useFormats = $useFormats;
    }

    /**
     * Property read access.
     * 
     * @throws ezcBasePropertyNotFoundException if the the desired property is
     *         not found.
     *
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
     */
    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) )
        {
            return $this->$propertyName;
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
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
     * @return void
     */
    public function __set( $propertyName, $val )
    {
        switch ( $propertyName )
        {
            case 'verbosityLevel':
            case 'autobreak':
                if ( !is_int( $val ) || $val < 0 )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'int >= 0' );
                }
                break;
            case 'useFormats':
                if ( !is_bool( $val ) )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'bool' );
                }
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $propertyName );
        }
        $this->$propertyName = $val;
    }
 
    /**
     * Property isset access.
     * 
     * @param string $propertyName Name of the property.
     * @return bool True if the property is set, false otherwise.
     */
    public function __isset( $propertyName )
    {
        return isset( $this->$propertyName );
    }

}

?>
