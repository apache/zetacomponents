<?php

class ezcGraphChartOption extends ezcBaseOptions
{
    protected $width;

    protected $height;

    protected $backgroundImage;

    protected $background;

    protected $border;

    protected $borderWidth;
    
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
                // @TODO: Implement checks
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
        }
    }
}

?>
