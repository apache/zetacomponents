<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests ezcPersistentOneToManyRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentOneToManyRelationTest extends ezcTestCase
{
    public static function suite()
    {
        return new ezcTestSuite( "ezcPersistentOneToManyRelationTest" );
    }

    public function testConstructoreSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        $this->assertEquals(
            "persons",
            $relation->sourceTable
        );
        $this->assertEquals(
            "addresses",
            $relation->destinationTable
        );
        $this->assertEquals(
            false,
            $relation->reverse
        );
        $this->assertEquals(
            array(),
            $relation->columnMap
        );
        $this->assertEquals(
            false,
            $relation->cascade
        );
    }

    public function testConstructoreFailureInvalidSourceTable()
    {
        try
        {
            $relation = new ezcPersistentOneToManyRelation( array(), "addresses" );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->sourceTable in ctor." );
    }

    public function testConstructoreFailureInvalidDestinationTable()
    {
        try
        {
            $relation = new ezcPersistentOneToManyRelation( "persons", array() );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->destinationTable in ctor." );
    }

    public function testGetAccessSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        $relation->sourceTable = "employers";
        $relation->destinationTable = "employees";
        /* Skipped here, is teste dedicatedly
         * $relation->columnMap = array( ... );
         */
        $relation->reverse = true;
        $relation->cascade = true;

        $this->assertEquals(
            "employers",
            $relation->sourceTable
        );
        $this->assertEquals(
            "employees",
            $relation->destinationTable
        );
        $this->assertEquals(
            array(),
            $relation->columnMap
        );
        $this->assertEquals(
            true,
            $relation->reverse
        );
        $this->assertEquals(
            true,
            $relation->cascade
        );
    }

    public function testGetAccessFailureNonExistents()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $foo = $relation->nonExistent;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on access of non existent property." );
    }

    public function testSetAccessSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        $relation->sourceTable = "employers";
        $relation->destinationTable = "employees";
        $relation->columnMap = array(
            new ezcPersistentSingleTableMap( "id", "person_id" ),
        );
        $relation->reverse = true;
        $relation->cascade = true;

        $this->assertEquals(
            "employers",
            $relation->sourceTable
        );
        $this->assertEquals(
            "employees",
            $relation->destinationTable
        );
        $this->assertEquals(
            array(
                new ezcPersistentSingleTableMap( "id", "person_id" ),
            ),
            $relation->columnMap
        );
        $this->assertEquals(
            true,
            $relation->reverse
        );
        $this->assertEquals(
            true,
            $relation->cascade
        );
    }

    public function testSetAccessFailureSourceTable()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->sourceTable = array();
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->sourceTable." );
    }

    public function testSetAccessFailureDestinationTable()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->destinationTable = array();
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->destinationTable." );
    }
    
    public function testSetAccessFailureReverse()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->reverse = array();
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->reverse." );
    }
    
    public function testSetAccessFailureCascade()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->cascade = array();
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->cascade." );
    }
    
    public function testSetAccessFailureColumnMapInvalidType()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->columnMap = array( "I am not an object" );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->columnMap." );
    }
    
    public function testSetAccessFailureColumnMapInvalidArraySize()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->columnMap = array();
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->columnMap." );
    }
    
    public function testSetAccessFailureColumnMapInvalidClass()
    {
        $relation = new ezcPersistentOneToManyRelation( "persons", "addresses" );
        try
        {
            $relation->columnMap = array(
                new StdClass(),
                new StdClass(),
            );
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->columnMap." );
    }
}

?>
