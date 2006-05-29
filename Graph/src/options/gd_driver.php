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
     *  - ezcGraphGdDriver::PNG
     *  - ezcGraphGdDriver::JPEG
     * 
     * @var int
     */
    protected $imageFormat;

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
                if ( in_array(  $propertyValue,
                                array(  ezcGraphGdDriver::PNG,
                                        ezcGraphGdDriver::JPEG ) ) ) 
                {
                    $this->imageFormat = (int) $propertyValue;
                }
                else
                {
                    throw new ezcBaseValueException( $propertyValue, 'integer' );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }
}

?>
