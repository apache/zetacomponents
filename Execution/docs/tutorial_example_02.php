<?php
require_once 'tutorial_autoload.php';

class MyExecutionHandler implements ezcExecutionErrorHandler
{
    public static function onError( Exception $e = NULL )
    {
        if ( !is_null( $e ) )
        {
            $message = $e->getMessage();
        }
        else
        {
            $message = "Unclean Exit - ezcExecution::cleanExit() was not called.";
        }

        echo "This application did not succesfully finish its request. " .
            "The reason was:\n$message\n\n";
    }
}

ezcExecution::init( 'MyExecutionHandler' );

throw new Exception( "Throwing an exception that will not be caught." );

ezcExecution::cleanExit();
?>
