<?php
require_once 'tutorial_autoload.php';

class customLazyPersistentSessionConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        switch ( $instance )
        {
            case null: // Default instance
                $session = new ezcPersistentSession(
                    ezcDbInstance::get(),
                    new ezcPersistentCodeManager( '../persistent' )
                );
                return $session;
            case 'second':
                $session = new ezcPersistentSession(
                    ezcDbInstance::get(),
                    new ezcPersistentCodeManager( '../additionalPersistent' )
                );
                return $session;
        }
    }
}

ezcBaseInit::setCallback( 
    'ezcInitPersistentSessionInstance', 
    'customLazyPersistentSessionConfiguration'
);

// Create and configure default persistent session
$db = ezcPersistentSessionInstance::get();

// Create and configure additional persistent session
$sb = ezcPersistentSessionInstance::get( 'second' );
?>
