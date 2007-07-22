<?php
require dirname( __FILE__ ) . '/../../../../Base/src/base.php';
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

$writer = new ezcLogSyslogWriter( "ezctest", LOG_PERROR|LOG_PID|LOG_ODELAY );

// extras
$writer->writeLogMessage( "I was bowling.", ezcLog::DEBUG, "Donny", "quotes",
                                array( "movie" => "The Big Lebowski" ) );

// debug
$writer->writeLogMessage( "The dude abides.", ezcLog::DEBUG, "Lebowski", "quotes" );

// success audit
$writer->writeLogMessage( "Don't be fatuous, Jeffrey.", ezcLog::SUCCESS_AUDIT, "Maude", "quotes" );

// fail audit
$writer->writeLogMessage( "Also, my rug was stolen.", ezcLog::FAILED_AUDIT, "Lebowski", "quotes" );

// info
$writer->writeLogMessage( "Obviously you're not a golfer.", ezcLog::INFO, "Lebowski", "quotes" );

// notice
$writer->writeLogMessage( "Forget it, Donny, you're out of your element!",
                          ezcLog::NOTICE, "Walter", "quotes" );

// warning
$writer->writeLogMessage( "Donny you're out of your element! Dude, the Chinaman is not the issue here!",
                          ezcLog::FAILED_AUDIT, "Walter", "quotes" );

// fatal
$writer->writeLogMessage( "Ok, Dude. Have it your way.", ezcLog::FATAL, "The stranger", "quotes" );

?>
