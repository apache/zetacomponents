<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require 'input/class.php';

/**
 * Class used in the test suite.
 *
 * @package Debug
 * @subpackage Tests
 */
class HtmlReporterDataStructures
{
    public function getLogStructure()
    {
        $log1 = new ezcDebugStructure();

        $log1->message = "SELECT contentobject_id, login, email, password_hash, password_hash_type\n FROM ezuser\n WHERE contentobject_id='10'";
        $log1->source = "content";
        $log1->category = "sql";
        $log1->verbosity = 1;
        $log1->datetime = 1201870191;
       
        $log2 = new ezcDebugStructure();
        $log2->message = "SELECT DISTINCT ezdiscountrule.id\n FROM ezdiscountrule,\n ezuser_discountrule\n WHERE ezuser_discountrule.contentobject_id = '10' AND\n".
                         "ezuser_discountrule.discountrule_id = ezdiscountrule.id";
        $log2->source = "content";
        $log2->category = "sql";
        $log2->verbosity = 2;
        $log2->datetime = 1201870191;

        return array( $log1, $log2 );
    }

    public function getTimeStructure()
    {
        $time = array (
          0 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'my query',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6352,
             'stopTime' => 1201870820.6352,
             'elapsedTime' => 1.9073486328125E-5,
             'startNumber' => 2,
             'stopNumber' => 3,
          )),
          1 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'my query',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6353,
             'stopTime' => 1201870820.6353,
             'elapsedTime' => 1.5974044799805E-5,
             'startNumber' => 4,
             'stopNumber' => 5,
          )),
          2 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'my query',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6353,
             'stopTime' => 1201870820.6353,
             'elapsedTime' => 1.5974044799805E-5,
             'startNumber' => 6,
             'stopNumber' => 7,
          )),
          3 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'replace mysql',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6354,
             'stopTime' => 1201870820.6354,
             'elapsedTime' => 1.5974044799805E-5,
             'startNumber' => 8,
             'stopNumber' => 9,
          )),
          4 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'replace mysql',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6354,
             'stopTime' => 1201870820.6355,
             'elapsedTime' => 1.5974044799805E-5,
             'startNumber' => 10,
             'stopNumber' => 11,
          )),
          5 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'Timing module',
             'source' => NULL,
             'group' => 'content',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6352,
             'stopTime' => 1201870820.6355,
             'elapsedTime' => 0.0003199577331543,
             'startNumber' => 1,
             'stopNumber' => 12,
          )),
          6 => 
          ezcDebugTimerStruct::__set_state(array(
             'name' => 'Script',
             'source' => NULL,
             'group' => 'html_reporter_test',
             'switchTime' => 
            array (
            ),
             'startTime' => 1201870820.6351,
             'stopTime' => 1201870820.6355,
             'elapsedTime' => 0.00037717819213867,
             'startNumber' => 0,
             'stopNumber' => 13,
          )),
        );
        return $time;
    }

    public function getLogStructureWithPhpStacktrace()
    {
        $rawTrace = require 'input/stacktrace_php.php';
        $stacktrace = new ezcDebugPhpStacktraceIterator(
            $rawTrace,
            0,
            new ezcDebugOptions()
        );
        $log = $this->getLogStructure();

        foreach ( $log as $logItem )
        {
            $logItem->stackTrace = $stacktrace;
        }
        return $log;
    }

    public function getLogStructureWithXdebugStacktrace()
    {
        $rawTrace = require 'input/stacktrace_xdebug.php';
        $stacktrace = new ezcDebugXdebugStacktraceIterator(
            $rawTrace,
            0,
            new ezcDebugOptions()
        );
        $log = $this->getLogStructure();

        foreach ( $log as $logItem )
        {
            $logItem->stackTrace = $stacktrace;
        }
        return $log;
    }

    protected function mySQLFunction(&$time)
    {
        $time->startTimer("my query", "html_reporter_test" , "query");

        // My query.. 

        $time->stopTimer("my query");
    }

    protected function anotherMySQLFunction(&$time)
    {
        $time->startTimer("replace mysql", "html_reporter_test" , "query");

        // My query.. 

        $time->stopTimer("replace mysql");
    }
}
?>
