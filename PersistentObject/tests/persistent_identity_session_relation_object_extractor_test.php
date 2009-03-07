<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/relation_test_employer.php";
require_once dirname( __FILE__ ) . "/data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/data/relation_test_address.php";

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionRelationObjectExtractorTest extends ezcTestCase
{
    protected $defManager;

    protected $sesstion;

    protected $idMap;

    protected $creator;

    protected $extractor;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setup()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
        RelationTestPerson::setupTables();
        RelationTestPerson::insertData();

        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->db->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );

        $this->defManager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );

        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            $this->defManager
        );

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->defManager
        );

        $this->creator = new ezcPersistentIdentityRelationQueryCreator(
            $this->defManager
        );

        $this->extractor = new ezcPersistentIdentitySessionRelationObjectExtractor(
            $this->idMap,
            $this->defManager
        );
    }

    public function teardown()
    {
        RelationTestEmployer::cleanup();
    }

    public function testOneLevelOneRelationExtract()
    {
        // Prepare PDOStatement
        $relations = array(
            new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
        );
        $q = $this->session->database->createSelectQuery();
        $this->creator->createQuery( $q, 'RelationTestPerson', 2, $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $person = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $person );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $person
        );

        $employers = $this->idMap->getRelatedObjects(
            $person, 'RelationTestEmployer'
        );
        
        $this->assertNotNull( $employers );

        $this->assertEquals( 1, count( $employers ) );

        $this->assertEquals(
            current( $employers ),
            current( $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ) )
        );
    }
    
}

?>
