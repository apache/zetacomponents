<?php
/**
 * File containing the ezcConsoleProgressMonitorOptions class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct class to store the options of the ezcConsoleOutput class.
 * This class stores the options for the {@link ezcConsoleOutput} class.
 * 
 * The ezcConsoleProgressMonitorOptions class has the following properties:
 * - <b>formatString</b> <i>string</i>, determines the format of the progressmonitor with a {@link printf()} compatible format string. The parameters given are:
 *   1. a float value (the progress value in percent).
 *   2. a string value (the action name).
 *   3. a string value (the status message).
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleProgressMonitorOptions extends ezcBaseOptions
{

    /**
     * The format string to describe the complete progressmonitor. 
     * 
     * @var string
     */
    private $formatString = "%8.1f%% %s %s";

    /**
     * Option write access.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseSettingValueException
     *         If a desired property value is out of range.
     *
     * @param string $key Name of the property.
     * @param mixed $value  The value for the property.
     * @return void
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "formatString":
                if ( strlen( $value ) < 1 )
                {
                    throw new ezcBaseSettingValueException( $key, $value, 'string, not empty' );
                }
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $key );
        }
        $this->$key = $value;
    }

    /**
     * Property read access.
     * 
     * @param string $key Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     */
    public function __get( $key )
    {
        if ( isset( $this->$key ) )
        {
            return $this->$key;
        }
        throw new ezcBasePropertyNotFoundException( $key );
    }
    
    /**
     * Property isset access.
     * 
     * @param string $key Name of the property.
     * @return bool True is the property is set, otherwise false.
     */
    public function __isset( $key )
    {
        if ( isset( $this->$key ) )
        {
            return true;
        }
        return false;
    }
}

?>
