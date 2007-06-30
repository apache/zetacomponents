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
        'filledThumbnail',
        array(
            'width'  => 100,
            'height' => 100,
            'color'  => array(
                200,
                200,
                200,
            ),
        )
    )
);

$converter->createTransformation( 'thumbnail', $filters, array( 'image/jpeg', 'image/png' ) );

try
{
    $converter->transform( 
        'thumbnail', 
        $tutorialPath.'/img/imageconversion_example_05_before.jpg', 
        $tutorialPath.'/img/imageconversion_example_05_after.jpg' 
    );
}
catch ( ezcImageTransformationException $e)
{
    die( "Error transforming the image: <{$e->getMessage()}>" );
}

?>
