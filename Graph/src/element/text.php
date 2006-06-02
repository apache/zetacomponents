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
     * Padding between border an text in pixel 
     * 
     * @var integer
     */
    protected $padding = 2;

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

        $this->renderBorder( $renderer );
        $this->renderBackground( $renderer );

        $height = (int) min( 
            round( $this->maxHeight * ( $boundings->y1 - $boundings->y0 ) ),
            $this->font->maxFontSize + $this->padding * 2
        );

        switch ( $this->position )
        {
            case ezcGraph::TOP:
                $renderer->drawTextBox(
                    new ezcGraphCoordinate(
                        $boundings->x0 + $this->padding,
                        $boundings->y0 + $this->padding
                    ),
                    $this->title,
                    $boundings->x1 - $boundings->x0 - $this->padding * 2,
                    $height - $this->padding * 2,
                    ezcGraph::CENTER | ezcGraph::MIDDLE
                );
                $boundings->y0 += $height;
                break;
            case ezcGraph::BOTTOM:
                $renderer->drawTextBox(
                    new ezcGraphCoordinate(
                        $boundings->x0 + $this->padding,
                        $boundings->y1 - $height + $this->padding
                    ),
                    $this->title,
                    $boundings->x1 - $boundings->x0 - $this->padding * 2,
                    $height - $this->padding * 2,
                    ezcGraph::CENTER | ezcGraph::MIDDLE
                );
                $boundings->y1 -= $height;
                break;
        }
        return $boundings;
    }
}

?>
