<?php
class testDelayedInitPersistentSessionInstance implements ezcBaseConfigurationInitializer
{
    static function configureObject( $identifier )
    {
        if ( $identifier !== false )
        {
            switch ( $identifier )
            {
                case 'delayed1':
                    $session = new ezcPersistentSession(
                        ezcDbInstance::get(),
                        new ezcPersistentCodeManager( '../persistent' )
                    );
                    return $session;
                  
            }
        }
    }
}
?>
