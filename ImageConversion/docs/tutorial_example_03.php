<?php

require_once 'tutorial_autoload.php';

$tutorialPath = dirname( __FILE__ );

$settings = new ezcImageConverterSettings(
    array(
        new ezcImageHandlerSettings( 'GD',          'ezcImageGdHandler' ),
        new ezcImageHandlerSettings( 'ImageMagick', 'ezcImageImagemagickHandler' ),
    ),
    array( 
        'image/gif' => 'image/png',
    )
);

$converter = new ezcImageConverter( $settings );

$filters = array( 
    new ezcImageFilter( 
        'scale',
        array( 
            'width'     => 320,
            'height'    => 240,
            'direction' => ezcImageGeometryFilters::SCALE_DOWN,
        )
    ),
    new ezcImageFilter( 
        'colorspace',
        array( 
            'space' => ezcImageColorspaceFilters::COLORSPACE_GREY, 
        )
    ),
    new ezcImageFilter( 
        'border',
        array(
            'width' => 5,
            'color' => array( 240, 240, 240 ),
        )
    ),
);

$converter->createTransformation( 'oldphoto', $filters, array( 'image/jpeg', 'image/png' ) );

try
{
    $converter->transform( 
        'oldphoto', 
        $tutorialPath.'/img/imageconversion_example_03_before.jpg', 
        $tutorialPath.'/img/imageconversion_example_03_after.jpg' 
    );
}
catch ( ezcImageTransformationException $e)
{
    die( "Error transforming the image: <{$e->getMessage()}>" );
}

?>
