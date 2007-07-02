<?php
require_once 'tutorial_autoload.php';

class customLazyTemplateConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $cfg )
    {
        $cfg->templatePath = "/usr/share/templates";
        $cfg->compilePath = "/tmp/compiled_templates";
        $cfg->context = new ezcTemplateXhtmlContext();
    }
}

ezcBaseInit::setCallback( 
    'ezcInitTemplateConfiguration', 
    'customLazyTemplateConfiguration'
);

$t = new ezcTemplate();
$t->process( "hello_world.ezt" );
?>
