<?php
require_once 'tutorial_autoload.php';

class customLazyConfigurationConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $cfg )
    {
        $cfg->init( 'ezcConfigurationIniReader', dirname( __FILE__ ) . '/examples' );
    }
}

ezcBaseInit::setCallback( 
    'ezcInitConfigurationManager', 
    'customLazyConfigurationConfiguration'
);

// Classes loaded and configured on first request
$cfg = ezcConfigurationManager::getInstance();

$pw = $cfg->getSetting( 'settings', 'db', 'password' );
echo "The password is '{$pw}'.\n";
?>
