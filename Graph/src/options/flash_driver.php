<?php
/**
 * File containing the ezcGraphFlashDriverOption class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class containing the basic options for charts
 *
 * @property int $compression
 *           Compression level used for generated flash file
 *           @see http://php.net/manual/en/function.swfmovie.save.php
 * @property float $circleResolution
 *           Resolution for circles, until I understand how to draw ellipses
 *           with SWFShape::curveTo()
 * 
 * @version //autogentag//
 * @package Graph
 */
class ezcGraphFlashDriverOptions extends ezcGraphDriverOptions
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
        $this->properties['compression'] = 9;
        $this->properties['circleResolution'] = 2.;

        parent::__construct( $options );
    }

    /**
     * Set an option value
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @throws ezcBasePropertyNotFoundException
     *          If a property is not defined in this class
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'compression':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue < 0 ) ||
                     ( $propertyValue > 9 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, '0 <= int <= 9' );
                }

                $this->properties['compression'] = max( 0, min( 9, (int) $propertyValue ) );
                break;
            case 'circleResolution':
                if ( !is_numeric( $propertyValue ) ||
                     ( $propertyValue <= 0 ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'float > 0' );
                }

                $this->properties['circleResolution'] = (float) $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }
}

?>
