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
        'watermarkAbsolute',
        array(
            'image' => $tutorialPath . '/img/watermark.png',
            'posX'  => -52,
            'posY'  => -25,
        )
    )
);

$converter->createTransformation( 'watermark', $filters, array( 'image/jpeg', 'image/png' ) );

try
{
    $converter->transform( 
        'watermark', 
        $tutorialPath.'/img/imageconversion_example_04_before.jpg', 
        $tutorialPath.'/img/imageconversion_example_04_after.jpg' 
    );
}
catch ( ezcImageTransformationException $e)
{
    die( "Error transforming the image: <{$e->getMessage()}>" );
}

?>
