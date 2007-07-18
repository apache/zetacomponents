<?php
class testDelayedInitDebug implements ezcBaseConfigurationInitializer
{
    static function configureObject( $object )
    {
        $object->setOutputFormatter( new TestReporter() );
    }
}
?>
