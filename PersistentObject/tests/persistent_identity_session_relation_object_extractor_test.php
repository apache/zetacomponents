<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . '/persistent_identity_session_relation_prefetch_test.php';

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionRelationObjectExtractorTest extends ezcPersistentIdentitySessionRelationPrefetchTest
{
    protected $sesstion;

    protected $idMap;

    protected $extractor;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setup()
    {
        parent::setup();

        RelationTestPerson::setupTables( $this->db );
        RelationTestPerson::insertData( $this->db );

        $this->session = new ezcPersistentSession(
            $this->db,
            $this->defManager
        );

        $this->idMap = new ezcPersistentBasicIdentityMap(
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
        $q = $this->getOneLevelOneRelationQuery();
        
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
