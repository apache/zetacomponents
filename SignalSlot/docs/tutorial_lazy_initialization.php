<?php
require_once 'tutorial_autoload.php';

class customLazySignalConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $signal )
    {
        $signal->connect( 'default', 'signal', 'customFunction' );
    }
}

ezcBaseInit::setCallback( 
    'ezcInitSignalStaticConnections', 
    'customLazySignalConfiguration'
);

function customFunction()
{
    echo "Custom function called with:\n", var_export( func_get_args(), true );
}

$signals = new ezcSignalCollection();
$signals->emit( 'signal', 42 );
?>
