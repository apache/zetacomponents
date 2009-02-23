<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Execution
 * @subpackage Tests
 */

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest1
{
}

/**
 * @package Execution
 * @subpackage Tests
 */
class ExecutionTest2 implements ezcExecutionErrorHandler
{
    static public function onError( Exception $e = NULL )
    {
        echo "\nThe ezcExecution succesfully detected an unclean exit.\n";
        echo "Have a nice day!\n";
    }
}
?>
