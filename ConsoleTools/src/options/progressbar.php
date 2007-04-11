<?php
/**
 * File containing the ezcConsoleProgressbarOptions class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct class to store the options of the ezcConsoleOutput class.
 * This class stores the options for the {@link ezcConsoleOutput} class.
 *
 * @property string $barChar
 *           The character to fill the bar with, during progress indication.
 * @property string $emptyChar
 *           The character to pre-fill the bar, before indicating progress.
 * @property string $formatString
 *           The format string to describe the complete progressbar.
 * @property string $fractionFormat
 *           Format to display the fraction value.
 * @property string $processChar
 *           The character for the end of the progress area (the arrow!).
 * @property int $redrawFrequency
 *           How often to redraw the progressbar (on every Xth call to advance()).
 * @property int $step
 *           How many steps to advance the progressbar on each call to advance().
 * @property int $width
 *           The width of the bar itself.
 * @property string $actFormat
 *           The format to display the actual value with.
 * @property string $maxFormat
 *           The format to display the actual value with.
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleProgressbarOptions extends ezcBaseOptions
{
    /**
     * Construct a new options object.
     * Options are constructed from an option array by default. The constructor
     * automatically passes the given options to the __set() method to set them 
     * in the class.
     * 
     * @param array(string=>mixed) $options The initial options to set.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    public function __construct( array $options = array() )
    {
        $this->properties['barChar'] = "+";
        $this->properties['emptyChar'] = "-";
        $this->properties['formatString'] = "%act% / %max% [%bar%] %fraction%%";
        $this->properties['fractionFormat'] = "%01.2f";
        $this->properties['progressChar'] = ">";
        $this->properties['redrawFrequency'] = 1;
        $this->properties['step'] = 1;
        $this->properties['width'] = 78;
        $this->properties['actFormat'] = '%.0f';
        $this->properties['maxFormat'] = '%.0f';
        parent::__construct( $options );
    }

    /**
     * Option write access.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseValueException
     *         If a desired property value is out of range.
     *
     * @param string $key Name of the property.
     * @param mixed $value  The value for the property.
     * @ignore
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
                    throw new ezcBaseValueException( $key, $value, 'string, not empty' );
                }
                break;
            case "width":
                if ( !is_int( $value ) || $value < 5 )
                {
                    throw new ezcBaseValueException( $key, $value, 'int >= 5' );
                }
                break;
            case "redrawFrequency":
            case "step":
                if ( ( !is_int( $value ) && !is_float( $value ) ) || $value < 1 )
                {
                    throw new ezcBaseValueException( $key, $value, 'int > 0' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $key );
        }
        $this->properties[$key] = $value;
    }
}

?>
