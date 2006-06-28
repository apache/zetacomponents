<?php
/**
 * File containing the ezcGraphSvgDriverOption class
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
class ezcGraphSvgDriverOptions extends ezcGraphDriverOptions
{

    /**
     * Assumed percentual average width of chars with the used font
     * 
     * @var float
     */
    protected $assumedCharacterWidth = .55;

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
            case 'assumedCharacterWidth':
                $this->assumedCharacterWidth = min( 1, max( 0, (float) $propertyValue ) );
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    protected function checkFont( $font )
    {
    }
}

?>
