<?php
/**
 * File containing the abstract ezcGraphChartElementText class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to represent a legend as a chart element
 *
 * @package Graph
 */
class ezcGraphChartElementText extends ezcGraphChartElement
{

    /**
     * Maximum percent of bounding used to display the text
     * 
     * @var float
     */
    protected $maxHeight = .1;

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
                $this->maxHeight = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Render a legend
     * 
     * @param ezcGraphRenderer $renderer 
     * @access public
     * @return void
     */
    public function render( ezcGraphRenderer $renderer, ezcGraphBoundings $boundings )
    {
        if ( empty( $this->title ) )
        {
            return $boundings;
        }


        $height = (int) min( 
            round( $this->maxHeight * ( $boundings->y1 - $boundings->y0 ) ),
            $this->font->maxFontSize + $this->padding * 2 + $this->margin * 2
        );

        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $textBoundings = new ezcGraphBoundings(
                    $boundings->x0,
                    $boundings->y0,
                    $boundings->x1,
                    $boundings->y0 + $height
                );
                $boundings->y0 += $height + $this->margin;
                break;
            case ezcGraph::BOTTOM:
                $textBoundings = new ezcGraphBoundings(
                    $boundings->x0,
                    $boundings->y1 - $height,
                    $boundings->x1,
                    $boundings->y1
                );
                $boundings->y1 -= $height + $this->margin;
                break;
        }

        $textBoundings = $renderer->drawBox(
            $textBoundings,
            $this->background,
            $this->border,
            $this->borderWidth,
            $this->margin,
            $this->padding
        );

        $renderer->drawText(
            $textBoundings,
            $this->title,
            ezcGraph::CENTER | ezcGraph::MIDDLE
        );

        return $boundings;
    }
}

?>
