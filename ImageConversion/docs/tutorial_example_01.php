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

$converter->createTransformation( 'jpeg', array(), array( 'image/jpeg' ) );

try
{
    $converter->transform( 
        'jpeg', 
        $tutorialPath.'/img/imageconversion_example_01_before.bmp', 
        $tutorialPath.'/img/imageconversion_example_01_after.jpg' 
    );
}
catch ( ezcImageTransformationException $e)
{
    die( "Error transforming the image: <{$e->getMessage()}>" );
}


?>
