<?php
require_once 'tutorial_autoload.php';

class customLazyDatabaseConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $instance )
    {
        switch ( $instance )
        {
            case false: // Default instance
                return ezcDbFactory::create( 'mysql://user:password@host/database' );
            case 'sqlite':
                return ezcDbFactory::create( 'sqlite://:memory:' );
        }
    }
}

ezcBaseInit::setCallback( 
    'ezcInitDatabaseInstance', 
    'customLazyDatabaseConfiguration'
);

// Create and configure default mysql connection
$db = ezcDbInstance::get();

// Create and configure additional sqlite connection
$sb = ezcDbInstance::get( 'sqlite' );
?>
