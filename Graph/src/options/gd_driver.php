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
class ezcGraphGdDriverOptions extends ezcGraphDriverOptions
{
    /**
     * Type of generated image.
     *
     * Should be one of those:
     *  - IMG_PNG
     *  - IMG_JPEG
     * 
     * @var int
     */
    protected $imageFormat = IMG_PNG;

    /**
     * Count of degrees to render one polygon for in circular arcs
     * 
     * @var integer
     */
    protected $detail = 1;

    /**
     * Percent to darken circular arcs at the sides
     * 
     * @var float
     */
    protected $shadeCircularArc = .5;

    /**
     * Factor of supersampling used to simulate antialiasing 
     * 
     * @var integer
     */
    protected $supersampling = 2;

    /**
     * Background image to put the graph on 
     * 
     * @var string
     */
    protected $background = false;

    /**
     * Function used to resample / resize images
     * 
     * @var string
     */
    protected $resampleFunction = 'imagecopyresampled';
    
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
            case 'imageFormat':
                if ( imagetypes() & $propertyValue )
                {
                    $this->imageFormat = (int) $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'Unsupported image type.' );
                }
                break;
            case 'detail':
                $this->detail = max( 1, (int) $propertyValue );
                break;
            case 'shadeCircularArc':
                $this->shadeCircularArc = max( 0, min( 1, (float) $propertyValue ) );
                break;
            case 'supersampling':
                $this->supersampling = (int) max( 1, $propertyValue );
                break;
            case 'background':
                if ( $propertyValue === false ||
                     ( is_file( $propertyValue ) && is_readable( $propertyValue ) ) )
                {
                    $this->background = realpath( $propertyValue );
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'readable file' );
                }
                break;
            case 'resampleFunction':
                if ( function_exists( $propertyValue ) )
                {
                    $this->resampleFunction = $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'function' );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    protected function checkFont( $font )
    {
        // We expect a valid font file here.
        if ( !is_file( $font ) || !is_readable( $font ) )
        {
            throw new ezcBaseFileNotFoundException( $font );
        }

        // @TODO: Check if font file is a valid TTF file.
        $this->font = realpath( $font );
    }
}

?>
