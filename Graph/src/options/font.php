<?php
/**
 * File containing the ezcGraphFontOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @package Graph
 */
class ezcGraphFontOptions extends ezcBaseOptions
{
    /**
     * Font face 
     * 
     * @var mixed
     */
    protected $font;

    /**
     * Minimum font size for displayed texts
     * 
     * @var float
     */
    protected $minFontSize = 6;

    /**
     * Maximum font size for displayed texts
     * 
     * @var float
     */
    protected $maxFontSize = 96;

    /**
     * The minimal used font size for this element
     * 
     * @var float
     */
    protected $minimalUsedFont = 96;

    /**
     * Font color 
     * 
     * @var ezcGraphColor
     */
    protected $color;

    /**
     * Percent of font size used for line spacing 
     * 
     * @var float
     */
    protected $lineSpacing = .1;

    public function __construct( array $options = array() )
    {
        $this->color = ezcGraphColor::fromHex( '#000000' );

        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'minFontSize':
                $this->minFontSize = max(1, (float) $propertyValue);
                break;
            case 'maxFontSize':
                $this->maxFontSize = max(1, (float) $propertyValue);
                break;
            case 'minimalUsedFont':
                $propertyValue = (float) $propertyValue;
                if ( $propertyValue < $this->minimalUsedFont )
                {
                    $this->minimalUsedFont = $propertyValue;
                }
                break;
            case 'color':
                if ( $propertyValue instanceof ezcGraphColor )
                {
                    $this->color = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcGraphColor' );
                }
                break;
            case 'font':
                if ( is_string( $propertyValue ) )
                {
                    $this->font = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
