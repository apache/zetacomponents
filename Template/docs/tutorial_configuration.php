<?php

// Autoload.
require_once 'tutorial_autoload.php';

$config = ezcTemplateConfiguration::getInstance();

$config->templatePath = "/usr/share/templates";
$config->compilePath = "/tmp/compiled_templates";
$config->context = new ezcTemplateXhtmlContext();  // Is already the default, though.


$t = new ezcTemplate();
$t->process( "hello_world.ezt" );
?>
