<?php
/**
 * File containing the ezcGraphChartOption class
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
class ezcGraphChartOptions extends ezcBaseOptions
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
     * Background images filename
     * 
     * @var string
     */
    protected $backgroundImage;

    /**
     * Background color of the chart
     * 
     * @var ezcGraphColor
     */
    protected $background;

    /**
     * Border color of the chart 
     * 
     * @var ezcGraphColor
     */
    protected $border;

    /**
     * Border width 
     * 
     * @var int
     */
    protected $borderWidth;
    
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
            case 'backgroundImage':
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

                $this->backgroundImage = $propertyValue;
                break;
            case 'background':
                $this->background = ezcGraphColor::create( $propertyValue );
                break;
            case 'border':
                $this->border = ezcGraphColor::create( $propertyValue );
                break;
            case 'borderWidth':
                $this->borderWidth = max( 1, (int) $propertyValue );
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
    }
}

?>
