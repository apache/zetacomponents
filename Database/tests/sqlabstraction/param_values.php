<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
class ezcParamValuesTest extends ezcTestCase
{

    protected $boolColumn;
    protected $intColumn;
    protected $nullColumn;
    protected $strColumn;
    protected $blobColumn;
    protected $clobColumn;

    protected $blob;
    protected $clob;

    protected $columnMapping = array(
        'bool' => array(
            'ezcDbHandlerMysql' => 'boolean',
            'ezcDbHandlerOracle' => 'char',
            'ezcDbHandlerPgsql' => 'boolean',
            'ezcDbHandlerSqlite' => 'integer',
        ),
        'int' => array(
            'ezcDbHandlerMysql' => 'bigint',
            'ezcDbHandlerOracle' => 'number',
            'ezcDbHandlerPgsql' => 'bigint',
            'ezcDbHandlerSqlite' => 'integer',
        ),
        'null' => array(
            'ezcDbHandlerMysql' => 'bigint',
            'ezcDbHandlerOracle' => 'number',
            'ezcDbHandlerPgsql' => 'bigint',
            'ezcDbHandlerSqlite' => 'integer',
        ),
        'str' => array(
            'ezcDbHandlerMysql' => 'varchar( 255 )',
            'ezcDbHandlerOracle' => 'varchar2( 255 )',
            'ezcDbHandlerPgsql' => 'varchar( 255 )',
            'ezcDbHandlerSqlite' => 'text',
        ),
        'blob' => array(
            'ezcDbHandlerMysql' => 'longblob',
            'ezcDbHandlerOracle' => 'blob',
            'ezcDbHandlerPgsql' => 'bytea',
            'ezcDbHandlerSqlite' => 'blob',
        ),
        'clob' => array(
            'ezcDbHandlerMysql' => 'longtext',
            'ezcDbHandlerOracle' => 'clob',
            'ezcDbHandlerPgsql' => 'text',
            'ezcDbHandlerSqlite' => 'clob',
        ),
    );

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcParamValuesTest' );
    }

    protected function setUp()
    {
        try {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->assertNotNull( $db, 'Database instance is not initialized.' );

        $db->exec( 'CREATE TABLE ' .
            $db->quoteIdentifier( __CLASS__ ) . 
            '( ' . 
                ( $this->boolColumn = $db->quoteIdentifier( 'bool' ) ) . ' ' . $this->columnMapping['bool'][get_class( $db )] . ', ' .
                ( $this->intColumn =  $db->quoteIdentifier( 'int' )  ) . ' ' . $this->columnMapping['int' ][get_class( $db )] . ', ' .
                ( $this->nullColumn = $db->quoteIdentifier( 'null' ) ) . ' ' . $this->columnMapping['null'][get_class( $db )] . ', ' .
                ( $this->strColumn =  $db->quoteIdentifier( 'str' )  ) . ' ' . $this->columnMapping['str' ][get_class( $db )] . ', ' .
                ( $this->blobColumn = $db->quoteIdentifier( 'blob' ) ) . ' ' . $this->columnMapping['blob'][get_class( $db )] . ', ' .
                ( $this->clobColumn = $db->quoteIdentifier( 'clob' ) ) . ' ' . $this->columnMapping['clob'][get_class( $db )] .
            ')'
        );

        // Initialize content
        $this->blob = str_repeat( "\x00\x05\x10\x42", 1024 );
        $this->clob = str_repeat( "test", 1024 );
    }

    protected function tearDown()
    {
        $db = ezcDbInstance::get();

        $db->exec( 'DROP TABLE ' .
            $db->quoteIdentifier( __CLASS__ )
        );
    }

    public function testBooleanParam()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->boolColumn,
                $query->bindValue( true ) 
            );
        $query->prepare()->execute();
    }

    public function testBooleanParamForce()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->boolColumn,
                $query->bindValue( true, null, PDO::PARAM_BOOL ) 
            );
        $query->prepare()->execute();
    }

    public function testBooleanParamForceBroken()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->boolColumn,
                $query->bindValue( 'some string', null, PDO::PARAM_BOOL ) 
            );
        $query->prepare()->execute();
    }

    public function testIntegerParam()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->intColumn,
                $query->bindValue( 42 ) 
            );
        $query->prepare()->execute();
    }

    public function testIntegerParamForce()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->intColumn,
                $query->bindValue( 42, null, PDO::PARAM_INT ) 
            );
        $query->prepare()->execute();
    }

    public function testIntegerParamForceBroken()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->intColumn,
                $query->bindValue( '42 strings', null, PDO::PARAM_INT ) 
            );
        $query->prepare()->execute();
    }

    public function testStringParam()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->strColumn,
                $query->bindValue( 'some string' ) 
            );
        $query->prepare()->execute();
    }

    public function testStringParamForce()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->strColumn,
                $query->bindValue( 'some string', null, PDO::PARAM_INT ) 
            );
        $query->prepare()->execute();
    }

    public function testStringParamForceBroken()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->strColumn,
                $query->bindValue( true, null, PDO::PARAM_INT ) 
            );
        $query->prepare()->execute();
    }

    public function testClobParam()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->clobColumn,
                $query->bindValue( $this->clob ) 
            );
        $query->prepare()->execute();
    }

    public function testClobParamForce()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->clobColumn,
                $query->bindValue( $this->clob, null, PDO::PARAM_LOB ) 
            );
        $query->prepare()->execute();
    }

    public function testClobParamForceBroken()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->clobColumn,
                $query->bindValue( 42, null, PDO::PARAM_LOB ) 
            );
        $query->prepare()->execute();
    }

    public function testBlobParam()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->blobColumn,
                $query->bindValue( $this->blob ) 
            );
        $query->prepare()->execute();
    }

    public function testBlobParamForce()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->blobColumn,
                $query->bindValue( $this->blob, null, PDO::PARAM_LOB ) 
            );
        $query->prepare()->execute();
    }

    public function testBlobParamForceBroken()
    {
        $db = ezcDbInstance::get();

        $query = $db->createInsertQuery();
        $query
            ->insertInto( $db->quoteIdentifier( __CLASS__ ) )
            ->set( 
                $this->blobColumn,
                $query->bindValue( 42, null, PDO::PARAM_LOB ) 
            );
        $query->prepare()->execute();
    }
}
?>
