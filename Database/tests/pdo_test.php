<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Test the PDO system.
 *
 * @package Database
 * @subpackage Tests
 */
class PDOTest extends ezcTestCase
{
    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->q = new ezcQueryInsert( $db );
        try
        {
            $db->exec( 'DROP TABLE query_test' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $db->exec( 'CREATE TABLE query_test ( id int, company VARCHAR(255), section VARCHAR(255), employees int )' );

    }

    protected function tearDown()
    {
        $db = ezcDbInstance::get();
        $db->exec( 'DROP TABLE query_test' );
    }


    // Works in 5.14 and 5.2.1RC2
    public function testIdNotFound()
    {
        $db = ezcDbInstance::get();
        $q = $db->prepare("INSERT INTO query_test VALUES( 1, 'name', 'section', 22)" );
        $q->execute();


        $stmt = $db->prepare('select * from `query_test` where `id`=:id');
        $stmt->bindValue(':id', 1);
        $stmt->execute();
        $row = $stmt->fetchAll( PDO::FETCH_ASSOC );
        var_dump($stmt);
        var_dump($row);
        $stmt->closeCursor();
    }


    // Works in PHP 5.2.1RC2, segfaults in PHP 5.1.4
    public function testSegfaultWrongFunctionCall()
    {
        $db = ezcDbInstance::get();

        $q = $db->prepare("INSERT INTO query_test VALUES( '', 'name', 'section', 22)" ); 
        $q->execute();

        $q->oasdfa(); // Wrong method call.
    }


    // Works in PHP 5.1.4, Fails (hangs) in PHP 5.2.1RC2-dev.
    public function testInsertWithWrongColon()
    {
        $db = ezcDbInstance::get();

        $q = $db->prepare("INSERT INTO query_test VALUES( ':id', 'name', 'section', 22)" ); // <-- ':id' should be :id (or a string without ":")
        $q->execute();
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "PDOTest" );
    }
}

?>
