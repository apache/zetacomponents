<?php
ezcTestRunner::addFileToFilter( __FILE__ );

class testDelayedInitDebug
{
    static function configureObject( $object )
    {
        $object->setOutputFormatter( new TestReporter() );
    }
}
?>
