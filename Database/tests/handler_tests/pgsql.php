<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

require_once 'base.php';

/**
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseHandlerPgsqlTest extends ezcDatabaseHandlerBaseTest
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->handlerClass = 'ezcDbHandlerPgsql';
        parent::setUp();
    }
}

?>
