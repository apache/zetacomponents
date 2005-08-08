<?php

abstract class LoggerWriterDatabase extends Writer
{
    public function __constructor( /* Connect to my database*/)
    {
    }

    /**
     * The function that actuallty writes the log entry.
     *
     * Group determines the file name, to write to. 
     */
    public function writeLogEntry( string $group, array $logEntry)
    {

    }
}

?>
