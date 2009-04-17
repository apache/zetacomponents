<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'find_query_test.php';

/**
 * Tests the ezcPersistentFindQuery class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentRelationFindQueryTest extends ezcPersistentFindQueryTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRelationSetNameInCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $sn = 'mySetName';

        $findQuery = new ezcPersistentRelationFindQuery( $q, $cn, $sn );

        $this->assertEquals( $sn, $findQuery->relationSetName );
    }

    public function testRelationSourceInCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $sn = 'mySetName';
        $src = new stdClass();

        $findQuery = new ezcPersistentRelationFindQuery( $q, $cn, $sn, $src );

        $this->assertEquals( $sn, $findQuery->relationSetName );
        $this->assertSame( $src, $findQuery->relationSource );
    }

    public function testSetOwnPropertiesSuccess()
    {
        $findQuery = $this->createFindQuery();
        
        $this->assertSetProperty( $findQuery, 'relationSetName', array( 'mySetName' ) );
        $this->assertSetProperty( $findQuery, 'relationSource', array( new stdClass() ) );
    }

    public function testSetOwnPropertiesFailure()
    {
        parent::testSetOwnPropertiesFailure();
        $findQuery = $this->createFindQuery();
        
        $this->assertSetPropertyFails(
            $findQuery,
            'relationSetName',
            array( 23, 42.23, true, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $findQuery,
            'relationSource',
            array( 23, 42.23, true, array(), 'foo' )
        );
    }

    public function testGetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $sn = 'mySetName';
        $src = new stdClass();

        $findQuery = $this->createFindQuery();

        $findQuery->relationSetName = $sn;
        $findQuery->relationSource  = $src;

        $this->assertEquals( $sn, $findQuery->relationSetName );
        $this->assertEquals( $src, $findQuery->relationSource );
    }

    public function testIssetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $findQuery = $this->createFindQuery();

        $this->assertTrue( isset( $findQuery->relationSetName ) );
        $this->assertTrue( isset( $findQuery->relationSource ) );
    }

    protected function createFindQuery()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';

        return new ezcPersistentRelationFindQuery( $q, $cn );
    }
}

?>
