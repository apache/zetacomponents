<?php

class ezcDocumentOdtPcssConverterTools
{
    /**
     * Serializes a color value.
     * 
     * @param array $colorValue 
     * @return string
     */
    public static function serializeColor( array $colorValue )
    {
        if ( $colorValue['alpha'] >= .5 )
        {
            return 'transparent';
        }
        else
        {
            return sprintf(
                '#%02x%02x%02x',
                round( $colorValue['red'] * 255 ),
                round( $colorValue['green'] * 255 ),
                round( $colorValue['blue'] * 255 )
            );
        }

    }
}

?>
