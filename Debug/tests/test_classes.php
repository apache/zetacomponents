<?php
class testDelayedInitDebug
{
    static function configureObject( $object )
    {
        $object->setOutputFormatter( new TestReporter() );
    }
}
?>
