<?php
require_once 'tutorial_autoload.php';

$cfg = ezcConfigurationManager::getInstance();
$cfg->init( 'ezcConfigurationIniReader', dirname( __FILE__ ) . '/examples' );

$pw = $cfg->getSetting( 'settings', 'db', 'password' );
echo "The password is '{$pw}'.\n";

$settings = $cfg->getSettings( 'settings', 'db', array( 'user', 'password' ) );
echo "Connecting with {$settings['user']}:{$settings['password']}.\n";

list( $user, $pass ) = $cfg->getSettingsAsList( 'settings', 'db', array( 'user', 'password' ) );
echo "Connecting with {$user}:{$pass}.\n";
?>
