<?php
/**
 * File containing the abstract ezcGraphChartElement class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * 
 *
 * @package Graph
 */
abstract class ezcGraphChartElement extends ezcBaseOptions
{

    /**
     * Title of chart element
     * 
     * @var string
     */
    protected $title;

    /**
     * Background color of chart element 
     * 
     * @var ezcGraphColor
     */
    protected $background;

    /**
     * Boundings of this elements
     * 
     * @var ezcGraphBoundings
     */
    protected $boundings;

    /**
     * Border color of chart element 
     * 
     * @var ezcGraphColor
     */
    protected $border;

    /**
     * Distance between border and content of element
     * 
     * @var integer
     */
    protected $padding;

    /**
     * Distance between outer boundings and border of an element 
     * 
     * @var integer
     */
    protected $margin;

    /**
     * Border width 
     * 
     * @var integer
     */
    protected $borderWidth;

    /**
     * Integer defining the elements position in the chart 
     * 
     * @var integer
     */
    protected $position;

    /**
     * Maximum size of the title
     * 
     * @var integer
     */
    protected $maxTitleHeight = 16;

    /**
     * Percentage of boundings which are used for the title with position
     * left, right or center
     * 
     * @var float
     */
    protected $portraitTitleSize = .15;

    /**
     * Percentage of boundings which are used for the title with position
     * top otr bottom
     * 
     * @var float
     */
    protected $landscapeTitleSize = .2;

    /**
     * Font used for this element 
     * 
     * @var ezcGraphFontOptions
     */
    protected $font;

    /**
     * Indicates if font configuration was already cloned for this specific
     * element.
     * 
     * @var boolean
     */
    protected $fontCloned = false;

    public function __construct( array $options = array() )
    {
        $this->boundings = new ezcGraphBoundings();
        $this->position = ezcGraph::LEFT;
        $this->font = new ezcGraphFontOptions();

        parent::__construct( $options );
    }

    /**
     * Set colors and border fro this element
     * 
     * @param ezcGraphPalette $palette Palette
     * @return void
     */
    public function setFromPalette( ezcGraphPalette $palette )
    {
        $this->border = $palette->elementBorderColor;
        $this->borderWidth = $palette->elementBorderWidth;
        $this->background = $palette->elementBackground;
        $this->padding = $palette->padding;
        $this->margin = $palette->margin;
    }

    /**
     * __set 
     * 
     * @param mixed $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBaseValueException
     *          If a submitted parameter was out of range or type.
     * @throws ezcBasePropertyNotFoundException
     *          If a the value for the property options is not an instance of
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'title':
                $this->title = (string) $propertyValue;
                break;
            case 'background':
                $this->background = ezcGraphColor::create( $propertyValue );
                break;
            case 'border':
                $this->border = ezcGraphColor::create( $propertyValue );
                break;
            case 'padding':
                $this->padding = max( 0, (int) $propertyValue );
                break;
            case 'margin':
                $this->margin = max( 0, (int) $propertyValue );
                break;
            case 'borderWidth':
                $this->borderWidth = max( 0, (int) $propertyValue);
                break;
            case 'font':
                if ( $propertyValue instanceof ezcGraphFontOptions )
                {
                    $this->font = $propertyValue;
                }
                elseif ( is_string( $propertyValue ) )
                {
                    if ( !$this->fontCloned )
                    {
                        $this->font = clone $this->font;
                        $this->fontCloned = true;
                    }

                    $this->font->font = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'ezcGraphFontOptions' );
                }
                break;
            case 'position':
                $positions = array(
                    ezcGraph::TOP,
                    ezcGraph::BOTTOM,
                    ezcGraph::LEFT,
                    ezcGraph::RIGHT,
                );

                if ( in_array( $propertyValue, $positions, true ) )
                {
                    $this->position = $propertyValue;
                }
                else 
                {
                    throw new ezcBaseValueException( 'position', $propertyValue, 'integer' );
                }
                break;
            default:
                throw new ezcGraphNoSuchDataSetException( $propertyName );
                break;
        }
    }
    
    public function __get( $propertyName )
    {
        if ( $propertyName === 'font' )
        {
            // Clone font configuration when requested for this element
            if ( !$this->fontCloned )
            {
                $this->font = clone $this->font;
                $this->fontCloned = true;
            }
        }

        return parent::__get( $propertyName );
    }

    /**
     * Renders this chart element
     *
     * This method receives and returns a part of the canvas where it can be 
     * rendered on.
     * 
     * @param ezcGraphBoundings $boundings Part of canvase to render element on
     * @return ezcGraphBoundings Part of canvas, which is still free to draw on
     */
    abstract public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings );

    protected function getTitleSize( ezcGraphBoundings $boundings, $direction = ezcGraph::HORIZONTAL )
    {
        if ( $direction === ezcGraph::HORIZONTAL )
        {
            return min(
                $this->maxTitleHeight,
                ( $boundings->y1 - $boundings->y0 ) * $this->landscapeTitleSize
            );
        }
        else
        {
            return min(
                $this->maxTitleHeight,
                ( $boundings->y1 - $boundings->y0 ) * $this->portraitTitleSize
            );
        }
    }
}

?>
