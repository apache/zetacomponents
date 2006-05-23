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

    public function __construct( array $options = array() )
    {
        $this->boundings = new ezcGraphBoundings();
        $this->position = ezcGraph::LEFT;

        parent::__construct( $options );
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
            case 'borderWidth':
                $this->borderWidth = max( 0, (int) $propertyValue);
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
                throw new ezcGraphNoSuchDatasetException( $propertyName );
                break;
        }
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

    protected function renderBorder( ezcGraphRenderer $renderer )
    {
        if ( $this->border instanceof ezcGraphColor )
        {
            // Default bordervalue to 1
            $this->borderWidth = max( 1, $this->borderWidth );
         
            // Draw border
            $renderer->drawRect(
                $this->border,
                new ezcGraphCoordinate( $this->boundings->x0, $this->boundings->y0 ),
                $this->boundings->x1 - $this->boundings->x0,
                $this->boundings->y1 - $this->boundings->y0,
                $this->borderWidth
            );

            // Reduce local boundings by borderWidth
            $this->boundings->x0 += $this->borderWidth;
            $this->boundings->y0 += $this->borderWidth;
            $this->boundings->x1 -= $this->borderWidth;
            $this->boundings->y1 -= $this->borderWidth;
        }
    }

    protected function renderBackground( ezcGraphRenderer $renderer )
    {
        if ( $this->background instanceof ezcGraphColor )
        {
            $renderer->drawBackground(
                $this->background,
                new ezcGraphCoordinate( $this->boundings->x0, $this->boundings->y0 ),
                $this->boundings->x1 - $this->boundings->x0,
                $this->boundings->y1 - $this->boundings->y0
            );
        }
    }

    protected function renderTitle( ezcGraphRenderer $renderer )
    {
        if ( !empty( $this->title ) )
        {
            switch ( $this->position )
            {
                case ezcGraph::LEFT:
                case ezcGraph::RIGHT:
                case ezcGraph::CENTER:
                    $height = min(
                        $this->maxTitleHeight,
                        ( $this->boundings->y1 - $this->boundings->y0 ) * $this->portraitTitleSize
                    );
                    $renderer->drawTextBox(
                        new ezcGraphCoordinate( $this->boundings->x0, $this->boundings->y0 ),
                        $this->title,
                        $this->boundings->x1 - $this->boundings->x0,
                        $height
                    );
                    $this->boundings->y0 += $height;
                    break;
                case ezcGraph::TOP:
                    $height = min(
                        $this->maxTitleHeight,
                        ( $this->boundings->y1 - $this->boundings->y0 ) * $this->landscapeTitleSize
                    );
                    $renderer->drawTextBox(
                        new ezcGraphCoordinate( $this->boundings->x0, $this->boundings->y0 ),
                        $this->title,
                        $this->boundings->x1 - $this->boundings->x0,
                        $height
                    );
                    $this->boundings->y0 += $height;
                    break;
                case ezcGraph::BOTTOM:
                    $height = min(
                        $this->maxTitleHeight,
                        ( $this->boundings->y1 - $this->boundings->y0 ) * $this->landscapeTitleSize
                    );
                    $renderer->drawTextBox(
                        new ezcGraphCoordinate( $this->boundings->x0, $this->boundings->y1 - $height ),
                        $this->title,
                        $this->boundings->x1 - $this->boundings->x0,
                        $height
                    );
                    $this->boundings->y1 -= $height;
                    break;
            }
        }
    }
}

?>
