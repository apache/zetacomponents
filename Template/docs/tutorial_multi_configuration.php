<?php
require_once 'tutorial_autoload.php';

$t = new ezcTemplate();

// Set the template configuration for printer templates.
$c = ezcTemplateConfiguration::getInstance( "printer" );

$c->templatePath = "printer";              // ./printer directory;
$c->context = new ezcTemplateNoContext();  // Use a context that doesn't do anything.

$c = ezcTemplateConfiguration::getInstance();
$c->templatePath = "html";                 // ./html directory.


// And another way to configure your template engine.
$pdfConf = new ezcTemplateConfiguration( "pdf", ".", new ezcTemplateNoContext() );


try
{
    // Uses the default configuration.
    $t->process( "hello_world.ezt" );
}
catch ( Exception $e )
{
    echo $e->getMessage() . "\n\n";
}

try
{
    // Uses the printer configuration
    $t->process( "hello_world.ezt", ezcTemplateConfiguration::getInstance( "printer" ) );
}
catch ( Exception $e )
{
    echo $e->getMessage() . "\n\n";
}

try
{
    // Uses the PDF configuration.
    $t->configuration = $pdfConf;
    $t->process( "hello_world.ezt" );
}
catch ( Exception $e )
{
    echo $e->getMessage() . "\n\n";
}
?>
