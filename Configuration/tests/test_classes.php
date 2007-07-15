<?php
class testDelayedInitConfigurationManager implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );
    }
}
?>
