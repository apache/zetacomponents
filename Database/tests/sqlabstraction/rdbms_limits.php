<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * testing sql abstraction for common rdbms limits
 *
 * @package Database
 * @subpackage Tests
 */
class ezcRdbmsLimitTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcRdbmsLimitTest' );
    }

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

        $this->assertNotNull( $db, 'Database instance is not initialized.' );

    }

    protected function tearDown()
    {
    }

    public function testLongTableNames()
    {
        $db = ezcDbInstance::get();
        if ( $db->getName() === 'mysql' )
        {
            self::markTestSkipped( 'Not for MySQL' );
        }

        for ( $i = 8; $i <= 256; $i *= 2 )
        {
            $table = str_pad( 'table', $i, 'very_' );

            try
            {
                $db->exec( 'CREATE TABLE ' .
                    $db->quoteIdentifier( $table ) . 
                    '( ' . $db->quoteIdentifier( $column = 'id' ) . ' int )'
                );

                $query = $db->createSelectQuery();
                $query->select( $db->quoteIdentifier( $column ) )
                      ->from( $db->quoteIdentifier( $table ) );
                $query->prepare()->execute();

                $db->exec( 'DROP TABLE ' .
                    $db->quoteIdentifier( $table )
                );
            }
            catch ( PDOException $e )
            {
                $this->fail( "Failed to use table name with length $i: " . $e->getMessage() );
            }
        }
    }

    public function testLongColumnNames()
    {
        $db = ezcDbInstance::get();
        if ( $db->getName() === 'mysql' )
        {
            self::markTestSkipped( 'Not for MySQL' );
        }

        try
        {
            $db->exec( 'DROP TABLE ' .
                $db->quoteIdentifier( $table = 'rdbms_test' ) );
        }
        catch ( Exception $e ) {} // Ignore

        for ( $i = 8; $i <= 256; $i *= 2 )
        {
            $column = str_pad( 'column', $i, 'very_' );

            try
            {
                $db->exec( 'CREATE TABLE ' .
                    $db->quoteIdentifier( $table ) . 
                    '( ' . $db->quoteIdentifier( $column ) . ' int )'
                );

                $query = $db->createSelectQuery();
                $query->select( $db->quoteIdentifier( $column ) )
                      ->from( $db->quoteIdentifier( $table ) );
                $query->prepare()->execute();

                $db->exec( 'DROP TABLE ' .
                    $db->quoteIdentifier( $table )
                );
            }
            catch ( PDOException $e )
            {
                $this->fail( "Failed to use column name with length $i: " . $e->getMessage() );
            }
        }
    }

    public function testInsertLongText()
    {
        $db = ezcDbInstance::get();

        try
        {
            $db->exec( 'DROP TABLE ' .
                $db->quoteIdentifier( $table = 'rdbms_test' ) );
        }
        catch ( Exception $e ) {} // Ignore

        // Type depends on DB handler
        switch ( $class = get_class( $db ) )
        {
            case 'ezcDbHandlerMysql':
            case 'ezcDbHandlerPgsql':
                // Oracle default length for varchar2
                // Also default length in DatabaseSchema
                $type = 'text';
                break;
            default:
                $type = 'clob';
                break;
        }

        $db->exec( 'CREATE TABLE ' .
            $db->quoteIdentifier( $table ) . 
            '( ' . $db->quoteIdentifier( $column = 'text' ) . ' ' . $type . ' )' );

        for( $i = 512; $i <= pow( 2, 16 ); $i *= 2 )
        {
            $text = str_pad( '', $i, 'test ' );

            try
            {
                $query = $db->createInsertQuery();
                $query
                    ->insertInto( $db->quoteIdentifier( $table ) )
                    ->set( $db->quoteIdentifier( $column ), $query->bindValue( $text, null, PDO::PARAM_STR ) );
                $query->prepare()->execute();
            }
            catch ( PDOException $e )
            {
                $this->fail( "Insert of long text failed with $i chars: " . $e->getMessage() );
            }
        }

        $db->exec( 'DROP TABLE ' .
            $db->quoteIdentifier( $table )
        );
    }

    public function testManyInElements()
    {
        $db = ezcDbInstance::get();

        try
        {
            $db->exec( 'DROP TABLE ' .
                $db->quoteIdentifier( $table = 'rdbms_test' ) );
        }
        catch ( Exception $e ) {} // Ignore

        $db->exec( 'CREATE TABLE ' .
            $db->quoteIdentifier( $table ) . 
            '( ' . $db->quoteIdentifier( $column = 'id' ) . ' int )' );

        // Insert 10.000 rows...
        for ( $i = 0; $i < 10000; $i++ )
        {
            $query = $db->createInsertQuery();
            $query
                ->insertInto( $db->quoteIdentifier( $table ) )
                ->set( $db->quoteIdentifier( $column ), $query->bindValue( $i ) );
            $query->prepare()->execute();
        }

        // Try some IN statements
        for( $i = 512; $i <= pow( 2, 13 ); $i *= 2 )
        {
            $inValues = array();
            for ( $j = 0; $j < $i; ++$j )
            {
                $inValues[] = $j;
            }

            try
            {
                $query = $db->createSelectQuery();
                $query
                    ->select( $db->quoteIdentifier( $column ) )
                    ->from( $db->quoteIdentifier( $table ) )
                    ->where( $query->expr->in(
                        $db->quoteIdentifier( $column ),
                        $inValues
                    ) );
                $statement = $query->prepare();
                $statement->execute();

                $result = $statement->fetchAll();
                $this->assertEquals(
                    count( $result ),
                    $i,
                    'Count of returned records did not match.'
                );
            }
            catch ( PDOException $e )
            {
                $this->fail( "IN() expression failed with $i values: " . $e->getMessage() );
            }
        }

        $db->exec( 'DROP TABLE ' .
            $db->quoteIdentifier( $table )
        );
    }

    public function testManyNotInElements()
    {
        $db = ezcDbInstance::get();

        try
        {
            $db->exec( 'DROP TABLE ' .
                $db->quoteIdentifier( $table = 'rdbms_test' ) );
        }
        catch ( Exception $e ) {} // Ignore

        $db->exec( 'CREATE TABLE ' .
            $db->quoteIdentifier( $table ) . 
            '( ' . $db->quoteIdentifier( $column = 'id' ) . ' int )' );

        // Insert 10.000 rows...
        for ( $i = 0; $i < 10000; $i++ )
        {
            $query = $db->createInsertQuery();
            $query
                ->insertInto( $db->quoteIdentifier( $table ) )
                ->set( $db->quoteIdentifier( $column ), $query->bindValue( $i ) );
            $query->prepare()->execute();
        }

        // Try some IN statements
        for( $i = 512; $i <= pow( 2, 13 ); $i *= 2 )
        {
            $inValues = array();
            for ( $j = 0; $j < $i; ++$j )
            {
                $inValues[] = $j;
            }

            try
            {
                $query = $db->createSelectQuery();
                $query
                    ->select( $db->quoteIdentifier( $column ) )
                    ->from( $db->quoteIdentifier( $table ) )
                    ->where( $query->expr->not( 
                        $query->expr->in(
                            $db->quoteIdentifier( $column ),
                            $inValues
                        )
                    ) );
                $statement = $query->prepare();
                $statement->execute();

                $result = $statement->fetchAll();
                $this->assertEquals(
                    count( $result ),
                    10000 - $i,
                    'Count of returned records did not match.'
                );
            }
            catch ( PDOException $e )
            {
                $this->fail( "NOT IN() expression failed with $i values: " . $e->getMessage() );
            }
        }

        $db->exec( 'DROP TABLE ' .
            $db->quoteIdentifier( $table )
        );
    }
}
?>
