<?php
// Connect signals to slots.
$signals  = new ezcSignalCollection;
$receiver = new MyReceiver;

$signals->connect( 'afterExecutionStarted', array( $receiver, 'afterExecutionStarted' ) );
$signals->connect( 'afterExecutionSuspended', array( $receiver, 'afterExecutionSuspended' ) );
$signals->connect( 'afterExecutionResumed', array( $receiver, 'afterExecutionResumed' ) );
$signals->connect( 'afterExecutionCancelled', array( $receiver, 'afterExecutionCancelled' ) );
$signals->connect( 'afterExecutionEnded', array( $receiver, 'afterExecutionEnded' ) );
$signals->connect( 'beforeNodeActivated', array( $receiver, 'beforeNodeActivated' ) );
$signals->connect( 'afterNodeActivated', array( $receiver, 'afterNodeActivated' ) );
$signals->connect( 'afterNodeExecuted', array( $receiver, 'afterNodeExecuted' ) );
$signals->connect( 'afterRolledBackServiceObject', array( $receiver, 'afterRolledBackServiceObject' ) );
$signals->connect( 'afterThreadStarted', array( $receiver, 'afterThreadStarted' ) );
$signals->connect( 'afterThreadEnded', array( $receiver, 'afterThreadEnded' ) );
$signals->connect( 'beforeVariableSet', array( $receiver, 'beforeVariableSet' ) );
$signals->connect( 'afterVariableSet', array( $receiver, 'afterVariableSet' ) );
$signals->connect( 'beforeVariableUnset', array( $receiver, 'beforeVariableUnset' ) );
$signals->connect( 'afterVariableUnset', array( $receiver, 'afterVariableUnset' ) );

// Set up database connection.
$db = ezcDbFactory::create( 'mysql://test@localhost/test' );

// Set up workflow definition storage (database).
$definition = new ezcWorkflowDatabaseDefinitionStorage( $db );

// Load latest version of workflow named "Test".
$workflow = $definition->loadByName( 'Test' );

// Set up database-based workflow executer.
$execution = new ezcWorkflowDatabaseExecution( $db );

// Pass workflow object to workflow executer.
$execution->workflow = $workflow;

// Register SignalSlot workflow engine plugin.
$plugin = new ezcWorkflowSignalSlotPlugin;
$plugin->signals = $signals;

$execution->addPlugin( $plugin );

// Start workflow execution.
$id = $execution->start();
?>
