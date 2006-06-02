<?php
/**
 * File containing the ezcGraphDriverOption class
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
abstract class ezcGraphDriverOptions extends ezcBaseOptions
{
    /**
     * Width of the chart
     * 
     * @var int
     */
    protected $width;

    /**
     * Height of the chart
     * 
     * @var int
     * @access protected
     */
    protected $height;

    /**
     * Font configuration
     * 
     * @var ezcGraphFontOptions
     */
    protected $font;

    /**
     * Percent of font size used for line spacing 
     * 
     * @var float
     */
    protected $lineSpacing = .1;

    public function __construct( array $options = array() )
    {
        $this->font = new ezcGraphFontOptions();
        $this->font->color = ezcGraphColor::fromHex( '#000000' );

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
            case 'width':
                $this->width = max( 1, (int) $propertyValue );
                break;
            case 'height':
                $this->height = max( 1, (int) $propertyValue );
                break;
            case 'font':
                if ( $propertyValue instanceof ezcGraphFontOptions )
                {
                    $this->font = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphFontOptions' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
