<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcDatabaseHandlerOracleTest extends ezcDatabaseHandlerBaseTest
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->handlerClass = 'ezcDbHandlerOracle';
        parent::setUp();
    }

    protected function tearDownTables()
    {
        $sequences = $this->db->query( "SELECT sequence_name FROM user_sequences" )->fetchAll();
        
        foreach ( $sequences as $sequenceDef )
        {
            $this->db->query( 'DROP SEQUENCE "' . $sequenceDef['sequence_name'] . '"' );
        }
        $tables = $this->db->query( "SELECT table_name FROM user_tables ORDER BY table_name" )->fetchAll();

        foreach ( $tables as $tableDef )
        {
            $this->db->query( 'DROP TABLE "' . $tableDef['table_name'] . '"' );
        }
    }
}

?>
