<?php
/**
 * Autoloader definition for the EventLog component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLog
 */

return array(
    'ezcLog'               =>  'EventLog/log.php',

    'ezcLogContext'        =>  'EventLog/context.php',
    'ezcLogMessage'        =>  'EventLog/log_message.php',

    'ezcLogWriter'         =>  'EventLog/interfaces/writer.php',
    'ezcLogMapper'         =>  'EventLog/interfaces/mapper.php',

    'ezcLogFilter'         =>  'EventLog/structs/log_filter.php',

    'ezcLogFilterSet'      =>  'EventLog/mapper/filterset.php',
    'ezcLogFilterRule'     =>  'EventLog/mapper/filter_rule.php',

    'ezcLogFileWriter'     =>  'EventLog/writers/writer_file.php',
    'ezcLogUnixFileWriter' =>  'EventLog/writers/writer_unix_file.php',

    'ezcLogWriterException'=>  'EventLog/exceptions/writer_exception.php'
);
?>
