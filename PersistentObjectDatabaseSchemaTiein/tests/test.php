<?php
/**
 * ezcPersistentObjectDatabaseSchemaTieinTest 
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutput class.
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcPersistentObjectDatabaseSchemaTieinTest extends ezcTestCase
{
    private $results;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcPersistentObjectDatabaseSchemaTieinTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    protected function setUp()
    {
        $this->results = require dirname( __FILE__ ) . "/data.php";
    }
    
    public function testUnusualCall()
    {
        $dir = realpath( dirname( __FILE__ ) . "/../../" );
        $oldDir = realpath( getcwd() );
        
        chdir( "/" );
        $res = `php {$dir}/PersistentObjectDatabaseSchemaTiein/src/rungenerator.php`;
        chdir( $oldDir );

        // file_put_contents( __FUNCTION__, substr( $res, 0, 203 ) );
        $this->assertEquals( $this->results[__FUNCTION__], substr( $res, 0, 203 ), "Error output incorrect with no parameters." );
    }

    public function testNoParameters()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testOnlySourceParameter()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -s test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testOnlyFormatParameter()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testFormatSourceParameter()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f test -s test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testInvalidFormat()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f test -s test test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testInvalidSource()
    {
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s test test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testInvalidDestination()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source test`;
        // file_put_contents( __FUNCTION__, $res );
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );
    }

    public function testValidFromFile()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $destination = $this->createTempDir( "PersObjDatSchem" );
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source $destination`;
        // file_put_contents( __FUNCTION__, $res );

        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_only/definitions/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        $this->removeTempDir();
    }

    public function testValidFromFileWithClasses()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $destination = $this->createTempDir( "PersObjDatSchem" );

        mkdir( "$destination/definitions" );
        mkdir( "$destination/classes" );
        
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source "$destination/definitions" "$destination/classes"`;
        // file_put_contents( __FUNCTION__, $res );

        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_class/definitions/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/definitions/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_class/classes/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/classes/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        $this->removeTempDir();
    }

    public function testValidFromFileWithClassesAndPrefix()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $destination = $this->createTempDir( "PersObjDatSchem" );

        mkdir( "$destination/definitions" );
        mkdir( "$destination/classes" );
        
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -p ezcapp -f xml -s $source "$destination/definitions" "$destination/classes"`;
        // file_put_contents( __FUNCTION__, $res );

        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_class_prefix/definitions/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/definitions/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_class_prefix/classes/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/classes/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        $this->removeTempDir();
    }
    
    public function testDuplicateWriteFromFileFailure()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $destination = $this->createTempDir( "PersObjDatSchem" );
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source $destination`;
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source $destination`;
        // file_put_contents( __FUNCTION__, $res );

        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        $this->removeTempDir();
    }
    
    public function testDuplicateWriteFromFileSuccess()
    {
        $source = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";
        $destination = $this->createTempDir( "PersObjDatSchem" );
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source $destination`;
        // Note "-o"!
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f xml -s $source -o $destination`;
        // file_put_contents( __FUNCTION__, $res );

        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        $this->removeTempDir();
    }

    public function testValidFromDb()
    {
        $type = ezcTestSettings::getInstance()->db->phptype;
        $dsn = ezcTestSettings::getInstance()->db->dsn;

        if ( $dsn === null || $type === null || $dsn === "sqlite://:memory:" )
        {
            $this->markTestSkipped( "DSN or database type not set or DSN not supported." );
        }

        // setup this test
        $destination = $this->createTempDir( "PersObjDatSchem" );
        
        $db = ezcDbFactory::create( $dsn );
        $fileSource = dirname( __FILE__ ) . "/data/webbuilder.schema.xml";

        $schema = ezcDbSchema::createFromFile( "xml", $fileSource );
        $schema->writeToDb( $db );
        
        // real test
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f "$type" -s "$dsn" "$destination"`;
        
        // Sanitize because of temp dir name
        $res = explode( "\n", $res );
        unset( $res[3], $res[4] );
        $res = implode( "\n", $res );
        
        $this->assertEquals( $this->results[__FUNCTION__], $res, "Error output incorrect with no parameters." );

        foreach ( glob( dirname( __FILE__ ) . "/data/definition_only/definitions/*.php" ) as $file )
        {
            $this->assertEquals(
                file_get_contents( $file ),
                file_get_contents( $destination . "/" . basename( $file ) ),
                "Geneator generated an invalid persistent object definition file."
            );
        }

        $this->removeTempDir();
    }

    public function testInvalidFromDb()
    {
        $type = ezcTestSettings::getInstance()->db->phptype;
        $dsn = ezcTestSettings::getInstance()->db->dsn;

        if ( $dsn === null || $type === null )
        {
            $this->markTestSkipped( "DSN or database type not set" );
        }

        // manipulate DSN
        $dsn = preg_replace( "@/[^/]*$@", "/db_not_exists", $dsn );

        // setup this test
        $destination = $this->createTempDir( "PersObjDatSchem" );
        
        // real test
        $res = `php PersistentObjectDatabaseSchemaTiein/src/rungenerator.php -f "$type" -s "$dsn" "$destination"`;
        
        $this->assertEquals( $this->results[__FUNCTION__], substr( $res, 0, 115 ), "Error output incorrect with no parameters." );

        $this->removeTempDir();
    }
}
?>
