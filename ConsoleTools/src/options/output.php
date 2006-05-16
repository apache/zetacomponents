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
class ezcConsoleOutputOptions extends ezcBaseOptions
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
}

?>
