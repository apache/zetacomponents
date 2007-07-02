<?php
require_once 'tutorial_autoload.php';

class customLazyLogConfiguration implements ezcBaseConfigurationInitializer
{
    public static function configureObject( $log )
    {
        $writeAll = new ezcLogUnixFileWriter( "/tmp/logs", "general.log" );
        $log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writeAll, true ) );
    }
}

ezcBaseInit::setCallback( 
    'ezcInitLog', 
    'customLazyLogConfiguration'
);

// Use log
$log = ezcLog::getInstance();

$log->log( "Paid with credit card.", ezcLog::SUCCESS_AUDIT, array( "category" => "shop" ) );
$log->log( "The credit card information is removed.", ezcLog::NOTICE, array( "category" => "shop" ) );
?>
