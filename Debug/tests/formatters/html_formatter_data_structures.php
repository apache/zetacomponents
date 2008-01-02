<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

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
        $log1->datetime = "Oct 05 2005 12:04:20";
       
        $log2 = new ezcDebugStructure();
        $log2->message = "SELECT DISTINCT ezdiscountrule.id\n FROM ezdiscountrule,\n ezuser_discountrule\n WHERE ezuser_discountrule.contentobject_id = '10' AND\n".
                         "ezuser_discountrule.discountrule_id = ezdiscountrule.id";
        $log2->source = "content";
        $log2->category = "sql";
        $log2->verbosity = 2;
        $log2->datetime = "Oct 05 2005 12:04:25";

        return array( $log1, $log2 );
    }

    public function getTimeStructure()
    {
        $time = new ezcDebugTimer();
        $time->startTimer("Script", "html_reporter_test", "script");

        if ( true != false ) $i_do_something = false;

        $time->startTimer("Timing module", "content", "module");

        if ( true != false ) $i_do_something = true;

        $this->mySQLFunction($time);
        $this->mySQLFunction($time);
        $this->mySQLFunction($time);
       
        $this->anotherMySQLFunction($time);
        $this->anotherMySQLFunction($time);
         
        $time->stopTimer("Timing module");

        $time->stopTimer("Script");

        return $time->getTimeData();
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
