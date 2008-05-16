<?php

require_once 'tutorial_autoload.php';

$debug = ezcDebug::getInstance();

// Switch on global stack traces.
$debug->options->stackTrace            = true;

// Configure stack trace appearance.
$debug->options->stackTraceDepth       = 3;
$debug->options->stackTraceMaxData     = 32;
$debug->options->stackTraceMaxChildren = 3;
$debug->options->stackTraceMaxDepth    = 2;

// ... somewhere else ...

// Log with no explicit stacktrace indication
ezcDebug::getInstance()->log(
    'Function testThis() has been called.',
    ezcLog::NOTICE,
    array( 'additional' => 'info' )
);

// ... somewhere else ...

// Print out log with stacktraces.
$debug = ezcDebug::getInstance();
echo $debug->generateOutput();

?>
