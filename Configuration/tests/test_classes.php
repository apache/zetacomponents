<?php
class testDelayedInitConfigurationManager
{
    static function configureObject( $object )
    {
        $object->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );
    }
}
?>
