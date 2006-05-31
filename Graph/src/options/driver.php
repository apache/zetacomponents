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
     * Color of text
     * 
     * @var ezcGraphColor
     */
    protected $fontColor;

    /**
     * Percent of font size used for line spacing 
     * 
     * @var float
     */
    protected $lineSpacing = .1;

    public function __construct( array $options = array() )
    {
        $this->fontColor = ezcGraphColor::fromHex( '#000000' );

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
            case 'minFontSize':
                $this->minFontSize = max(1, (float) $propertyValue);
                break;
            case 'maxFontSize':
                $this->maxFontSize = max(1, (float) $propertyValue);
                break;
            case 'font':
                // Heavily depends on driver - check should be implemented in 
                // derived classes
                $this->checkFont( $propertyValue );
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }

    abstract protected function checkFont( $font );
}

?>
