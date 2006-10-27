<?php
/**
 * File containing the ezcGraphChartElementText class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Chart element to display texts in a chart
 *
 * @property float $maxHeight
 *           Maximum percent of bounding used to display the text.
 *
 * @package Graph
 */
class ezcGraphChartElementText extends ezcGraphChartElement
{
    /**
     * Constructor
     * 
     * @param array $options Default option array
     * @return void
     * @ignore
     */
    public function __construct( array $options = array() )
    {
        $this->properties['maxHeight'] = .1;

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
            case 'maxHeight':
                $this->properties['maxHeight'] = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Render the text
     * 
     * @param ezcGraphRenderer $renderer Renderer
     * @param ezcGraphBoundings $boundings Boundings for the axis
     * @return ezcGraphBoundings Remaining boundings
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        $height = (int) min( 
            round( $this->properties['maxHeight'] * ( $boundings->y1 - $boundings->y0 ) ),
            $this->properties['font']->maxFontSize + $this->padding * 2 + $this->margin * 2
        );

        switch ( $this->properties['position'] )
        {
            case ezcGraph::TOP:
                $textBoundings = new ezcGraphBoundings(
                    $boundings->x0,
                    $boundings->y0,
                    $boundings->x1,
                    $boundings->y0 + $height
                );
                $boundings->y0 += $height + $this->properties['margin'];
                break;
            case ezcGraph::BOTTOM:
                $textBoundings = new ezcGraphBoundings(
                    $boundings->x0,
                    $boundings->y1 - $height,
                    $boundings->x1,
                    $boundings->y1
                );
                $boundings->y1 -= $height + $this->properties['margin'];
                break;
        }

        $textBoundings = $renderer->drawBox(
            $textBoundings,
            $this->properties['background'],
            $this->properties['border'],
            $this->properties['borderWidth'],
            $this->properties['margin'],
            $this->properties['padding']
        );

        $renderer->drawText(
            $textBoundings,
            $this->properties['title'],
            ezcGraph::CENTER | ezcGraph::MIDDLE
        );

        return $boundings;
    }
}

?>
