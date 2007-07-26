<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

require_once 'tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcDbTreeTest extends ezcTreeTest
{
    private $tempDir;

    protected function setUp()
    {
        try
        {
            $this->dbh = ezcDbInstance::get();
            $this->cleanupTables( $this->dbh );

            // create the parent_child table
            $schema = ezcDbSchema::createFromFile(
                'array',
                dirname( __FILE__ ) . '/files/parent_child.dba'
            );
            $schema->writeToDb( $this->dbh );

            // insert test data
            $data = array(
                // child -> parent
                1 => 'null',
                2 => 1,
                3 => 1,
                4 => 1,
                6 => 4,
                7 => 6,
                8 => 6,
                5 => 1,
                9 => 5
            );
            foreach( $data as $childId => $parentId )
            {
                $this->dbh->exec( "INSERT INTO parent_child(id, parent_id) VALUES( $childId, $parentId )" );
            }

            // add data
            for ( $i = 1; $i <= 9; $i++ )
            {
                $this->dbh->exec( "INSERT INTO data(id, data) values ( $i, 'Node $i' )" );
            }
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }

    }

    protected function cleanupTables()
    {
        try
        {
            $this->dbh->exec( 'DROP TABLE parent_child' );
            $this->dbh->exec( 'DROP TABLE data' );
        }
        catch ( Exception $e )
        {
            // ignore
        }
    }

    protected function tearDown()
    {
    }
}

?>
