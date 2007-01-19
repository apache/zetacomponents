<?php
class testDelayedInitLog
{
    static function configureObject( $object )
    {
        $object->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( '/' ), true) );
    }
}
?>
