<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */


/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaConversionTest extends ezcTestCase
{
    private $referenceFile;
    private $generatedFile;
    private $deltaFile;

    /**
     * "constructor"
     */
    protected function setUp()
    {
        $this->referenceFile = dirname( __FILE__ ) . '/data/schema.dba';
        $this->generatedFile = dirname( __FILE__ ) . '/data/schema-generated.dba';
        $this->deltaFile     = dirname( __FILE__ ) . '/data/schema-delta.sql';
    }

    /**
     * "destructor"
     */
    protected function tearDown()
    {
        @unlink( $this->generatedFile );
        @unlink( $this->deltaFile );
    }

    /**
     * Compare two schemas loaded from different sources.
     *
     * Load schema #1 from a .php file, save it to mysql db.
     * Then load schema #2 from the same db and save it to another .php file.
     * (the .php files can be then compared manually)
     * Then compare the schemas.
     * There should be no differences.
     *
     * i.e.:
     * php -> schema1 -> mydb -> schema2 -> php
     *
     */
    public function testCompareSchemas()
    {
        $db = ezcDbInstance::get();
        $schema = new ezcDbSchema;

        $schema->load( $this->referenceFile, 'php-file', 'schema' );
        $schema->save( $db, ( $db->getName() . '-db' ) );

        $schema2 = new ezcDbSchema;
        $schema2->load( $db, ( $db->getName() . '-db' ) );
        $schema2->save( $this->generatedFile, 'php-file', 'schema' );

        $diff = $schema->compare( $schema2 );
        $schema->saveDelta( $diff, $this->deltaFile, ( $db->getName() . '-file' ) );
        $this->assertEquals( array(), $diff, 'Found differences in the schemas.' );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaConversionTest' );
    }

}

?>
