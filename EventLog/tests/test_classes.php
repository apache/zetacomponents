<?php
class testDelayedInitLog implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( '/' ), true) );
    }
}
?>
