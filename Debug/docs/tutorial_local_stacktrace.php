<?php

require_once 'tutorial_autoload.php';

// ... inside some function...

// Log with no explicit stacktrace indication
ezcDebug::getInstance()->log(
    'Function testThis() has been called.',
    ezcLog::NOTICE,
    array( 'additional' => 'info' ),
    // Enable stack trace
    true
);

// ... somewhere else ...

// Print out log with stacktraces.
$debug = ezcDebug::getInstance();
echo $debug->generateOutput();

?>
