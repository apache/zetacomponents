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
class ezcGraphChartElementBackgroundImage extends ezcGraphChartElement
{

    /**
     * Filename of the file to use for background
     * 
     * @var string
     */
    protected $source = '';

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
            case 'source':
                // Check for existance of file
                if ( !is_file( $propertyValue ) || !is_readable( $propertyValue ) )
                {
                    throw new ezcBaseFileNotFoundException( $propertyValue );
                }

                // Check for beeing an image file
                $data = getImageSize( $propertyValue );
                if ( $data === false )
                {
                    throw new ezcGraphInvalidImageFileException( $propertyValue );
                }

                // SWF files are useless..
                if ( $data[2] === 4 ) 
                {
                    throw new ezcGraphInvalidImageFileException( 'We cant use SWF files like <' . $propertyValue . '>.' );
                }

                $this->source = $propertyValue;
                break;
            case 'position':
                $this->position = (int) $propertyValue;
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
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
        if ( empty( $this->source ) )
        {
            return $boundings;
        }

        // Get background image boundings
        $data = getimagesize( $this->source );

        // Determine x position
        switch ( true )
        {
            case ( $this->position & ezcGraph::LEFT ):
                $xPosition = 0;
                break;
            case ( $this->position & ezcGraph::RIGHT ):
                $xPosition = $boundings->x1 - $data[0];
                break;
            case ( $this->position & ezcGraph::CENTER ):
            default:
                $xPosition = (int) round( ( $boundings->x1 - $data[0] ) / 2 );
                break;
        }

        // Determine y position
        switch ( true )
        {
            case ( $this->position & ezcGraph::TOP ):
                $yPosition = 0;
                break;
            case ( $this->position & ezcGraph::BOTTOM ):
                $yPosition = $boundings->y1 - $data[1];
                break;
            case ( $this->position & ezcGraph::MIDDLE ):
            default:
                $yPosition = (int) round( ( $boundings->y1 - $data[1] ) / 2 );
                break;
        }

        $renderer->drawBackgroundImage(
            $this->source,
            new ezcGraphCoordinate( $xPosition, $yPosition ),
            $data[0],
            $data[1]
        );

        return $boundings;
    }
}

?>
