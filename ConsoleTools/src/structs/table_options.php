<?php
/**
 * File containing the ezcConsoleTableOptions class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct class to store the options of the ezcConsoleTable class.
 *
 * This class stores the options for the {@link ezcConsoleTable} class.
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleTableOptions
{
    /**
     * Column width, either a fixed int value (number of chars)  or 'auto'.
     * 
     * @var mixed
     */
    protected $colWidth = 'auto';

    /**
     * Wrap style of text contained in strings.
     * @see ezcConsoleTable::WRAP_AUTO
     * @see ezcConsoleTable::WRAP_NONE
     * @see ezcConsoleTable::WRAP_CUT
     * 
     * @var int
     */
    protected $colWrap = ezcConsoleTable::WRAP_AUTO;

    /**
     * Standard column alignment, applied to cells that have to explicit
     * alignment assigned.
     *
     * @see ezcConsoleTable::ALIGN_LEFT
     * @see ezcConsoleTable::ALIGN_RIGHT
     * @see ezcConsoleTable::ALIGN_CENTER
     * @see ezcConsoleTable::ALIGN_DEFAULT
     * 
     * @var int
     */
    protected $defaultAlign = ezcConsoleTable::ALIGN_LEFT;

    /**
     * Padding characters for side padding between data and lines. 
     * 
     * @var string
     */
    protected $colPadding = ' ';

    /**
     * Type of the given table width (fixed or maximal value).
     * 
     * @var int
     */
    protected $widthType = ezcConsoleTable::WIDTH_MAX;
        
    /**
     * Character to use for drawing vertical lines. 
     * 
     * @var string
     */
    protected $lineVertical = '-';

    /**
     * Character to use for drawing horizontal lines. 
     * 
     * @var string
     */
    protected $lineHorizontal = '|';

    /**
     * Character to use for drawing line corners.
     * 
     * @var string
     */
    protected $corner = '+';
    
    /**
     * Standard column content format, applied to cells that have 'default' as
     * the content format.
     * 
     * @var string
     */
    protected $defaultFormat = 'default';

    /**
     * Standard border format, applied to rows that have 'default' as the
     * border format.
     * 
     * @var string
     */
    protected $defaultBorderFormat = 'default';

    /**
     * Create a new ezcConsoleProgressbarOptions struct. 
     *
     * Create a new ezcConsoleProgressbarOptions struct for use with {@link
     * ezcConsoleOutput}. 
     * 
     * @todo documentation missing!
     */
    public function __construct( 
        $colWidth = 'auto',
        $colWrap = ezcConsoleTable::WRAP_AUTO,
        $defaultAlign = ezcConsoleTable::ALIGN_LEFT,
        $colPadding = ' ',
        $widthType = ezcConsoleTable::WIDTH_MAX,
        $lineVertical = '-',
        $lineHorizontal = '|',
        $corner = '+',
        $defaultFormat = 'default',
        $defaultBorderFormat = 'default'
    )
    {
        $this->__set( 'colWidth', $colWidth );
        $this->__set( 'colWrap', $colWrap );
        $this->__set( 'defaultAlign', $defaultAlign );
        $this->__set( 'colPadding', $colPadding );
        $this->__set( 'widthType', $widthType );
        $this->__set( 'lineVertical', $lineVertical );
        $this->__set( 'lineHorizontal', $lineHorizontal );
        $this->__set( 'corner', $corner );
        $this->__set( 'defaultFormat', $defaultFormat );
        $this->__set( 'defaultBorderFormat', $defaultBorderFormat );
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
            case 'colWidth':
                if ( !is_array( $val ) && is_string( $val ) && $val !== 'auto' )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'array(int) or "auto"' );
                }
                break;
            case 'colWrap':
                if ( $val !== ezcConsoleTable::WRAP_AUTO && $val !== ezcConsoleTable::WRAP_NONE && $val !== ezcConsoleTable::WRAP_CUT )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'ezcConsoleTable::WRAP_AUTO, ezcConsoleTable::WRAP_NONE, ezcConsoleTable::WRAP_CUT' );
                }
                break;
            case 'defaultAlign':
                if ( $val !== ezcConsoleTable::ALIGN_DEFAULT && $val !== ezcConsoleTable::ALIGN_LEFT && $val !== ezcConsoleTable::ALIGN_CENTER && $val !== ezcConsoleTable::ALIGN_RIGHT )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'ezcConsoleTable::ALIGN_DEFAULT, ezcConsoleTable::ALIGN_LEFT, ezcConsoleTable::ALIGN_CENTER, ezcConsoleTable::ALIGN_RIGHT' );
                }
                break;
            case 'colPadding':
                if ( !is_string( $val ) )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'string' );
                }
                break;
            case 'widthType':
                if ( $val !== ezcConsoleTable::WIDTH_MAX && $val !== ezcConsoleTable::WIDTH_FIXED )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'ezcConsoleTable::WIDTH_MAX, ezcConsoleTable::WIDTH_FIXED' );
                }
                break;
            case 'lineVertical':
            case 'lineHorizontal':
            case 'corner':
                if ( !is_string( $val ) && strlen( $val ) !== 1 )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'string, length = 1' );
                }
                break;
            case 'defaultFormat':
                if ( !is_string( $val ) || strlen( $val ) < 1 )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'string, length = 1' );
                }
                break;
            case 'defaultBorderFormat':
                if ( !is_string( $val ) || strlen( $val ) < 1 )
                {
                    throw new ezcBaseSettingValueException( $propertyName, $val, 'string, length = 1' );
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
