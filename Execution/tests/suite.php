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
 * Including the tests
 */
require_once 'execution_init_test.php';

/**
 * @package Execution
 * @subpackage Tests
 */
class ezcExecutionSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Execution" );

        $this->addTest( ezcExecutionInitDefinition::suite() );
    }

    public static function suite()
    {
        return new ezcExecutionSuite();
    }
}
?>
