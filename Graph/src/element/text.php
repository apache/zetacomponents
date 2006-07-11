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

        $boundings = $renderer->drawBox(
            $boundings,
            $this->background,
            $this->border,
            $this->borderWidth,
            $this->margin,
            $this->padding
        );

        $height = (int) min( 
            round( $this->maxHeight * ( $boundings->y1 - $boundings->y0 ) ),
            $this->font->maxFontSize + $this->padding * 2
        );

        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $renderer->drawText(
                    new ezcGraphBoundings(
                        $boundings->x0,
                        $boundings->y0,
                        $boundings->x1,
                        $boundings->y0 + $height
                    ),
                    $this->title,
                    ezcGraph::CENTER | ezcGraph::MIDDLE
                );

                $boundings->y0 += $height + $this->margin;
                break;
            case ezcGraph::BOTTOM:
                $renderer->drawText(
                    new ezcGraphBoundings(
                        $boundings->x0,
                        $boundings->y1 - $height,
                        $boundings->x1,
                        $boundings->y1
                    ),
                    $this->title,
                    ezcGraph::CENTER | ezcGraph::MIDDLE
                );
                $boundings->y1 -= $height + $this->margin;
                break;
        }
        return $boundings;
    }
}

?>
