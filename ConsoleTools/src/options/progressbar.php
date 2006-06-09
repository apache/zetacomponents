<?php
/**
 * File containing the ezcConsoleProgressbarOptions class.
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
 * The ezcConsoleProgressbarOptions class has the following properties:
 * - <b>barChar</b> <i>string</i>, the character to fill the bar with, during progress indication.
 * - <b>emptyChar</b> <i>string</i>, the character to pre-fill the bar, before indicating progress.
 * - <b>formatString</b> <i>string</i>, fhe format string to describe the complete progressbar.
 *   Supports the placeholders 
 *   - "%bar%" for the actual progress bar
 *   - "%max%" for the maximum value to reach when the bar finishes
 *   - "%act%" for the actual value during progress
 *   - "%fraction%" for the actual percentage value of the bar.
 * - <b>fractionFormat</b> <i>string</i>, a {@link printf()} compatible format for the fraction value.
 * - <b>progressChar</b> <i>string</i>, the head of the progressbar (probably an arrow).
 * - <b>redrawFrequency</b> <i>int</i>, how often the bar will be redrawen (1 means on every call to advance()).
 * - <b>step</b> <i>int</i>, how many steps to advance the progressbar on each call to advance().
 * - <b>width</b> <i>int</i>, the width of the bar itself.
 * - <b>actFormat</b> <i>string</i>, the format of the actual value {@link printf()}.
 * - <b>maxFormat</b> <i>string</i>, the format of the maximal value {@link printf()}.
 *
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleProgressbarOptions extends ezcBaseOptions
{
    /**
     * The character to fill the bar with, during progress indication. 
     * 
     * @var string
     */
    private $barChar = "+";

    /**
     * The character to pre-fill the bar, before indicating progress. 
     * 
     * @var string
     */
    private $emptyChar = "-";

    /**
     * The format string to describe the complete progressbar. 
     * 
     * @var string
     */
    private $formatString = "%act% / %max% [%bar%] %fraction%%";

    /**
     * Format to display the fraction value. 
     * 
     * @var string
     */
    private $fractionFormat = "%01.2f";

    /**
     * The character for the end of the progress area (the arrow!).
     * 
     * @var string
     */
    private $progressChar = ">";

    /**
     * How often to redraw the progressbar (on every Xth call to advance()).
     * 
     * @var int
     */
    private $redrawFrequency = 1;

    /**
     * How many steps to advance the progressbar on each call to advance().
     * 
     * @var int
     */
    private $step = 1;

    /**
     * The width of the bar itself. 
     * 
     * @var int
     */
    private $width = 78;

    /**
     * The format to display the actual value with. 
     * 
     * @var string
     */
    private $actFormat = '%.0f';

    /**
     * The format to display the actual value with. 
     * 
     * @var string
     */
    private $maxFormat = '%.0f';

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
            case "barChar":
            case "emptyChar":
            case "progressChar":
            case "formatString":
            case "fractionFormat":
            case "actFormat":
            case "maxFormat":
                if ( strlen( $value ) < 1 )
                {
                    throw new ezcBaseSettingValueException( $key, $value, 'string, not empty' );
                }
                break;
            case "width":
                if ( !is_int( $value ) || $value < 5 )
                {
                    throw new ezcBaseSettingValueException( $key, $value, 'int >= 5' );
                }
                break;
            case "redrawFrequency":
            case "step":
                if ( ( !is_int( $value ) && !is_float( $value ) ) || $value < 1 )
                {
                    throw new ezcBaseSettingValueException( $key, $value, 'int > 0' );
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
