<?php

require_once 'tutorial_autoload.php';

$tutorialPath = dirname( __FILE__ );

$settings = new ezcImageConverterSettings(
    array(
        new ezcImageHandlerSettings( 'GD',          'ezcImageGdHandler' ),
        new ezcImageHandlerSettings( 'ImageMagick', 'ezcImageImagemagickHandler' ),
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
);

$converter->createTransformation( 'preview', $filters, array( 'image/jpeg' ) );

try
{
    $converter->transform( 
        'preview', 
        $tutorialPath.'/img/imageconversion_example_02_before.jpg', 
        $tutorialPath.'/img/imageconversion_example_02_after.jpg' 
    );
}
catch ( ezcImageTransformationException $e)
{
    die( "Error transforming the image: <{$e->getMessage()}>" );
}

?>
