<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the ezcPersistentObjecRelations class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentRelationCollectionTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtor()
    {
        $this->markTestSkipped( 'Does not work in PHP 5.[23].x due to broken ArrayObject.' );
        $col = new ezcPersistentRelationCollection();

        $this->assertAttributeEquals(
            array(),
            'relations',
            $col
        );
    }

    public function testOffsetSetOffsetFailure()
    {
        $col = new ezcPersistentRelationCollection();
        
        try
        {
            $col[23] = new ezcPersistentOneToManyRelation( 'src', 'tbl' );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        try
        {
            $col[''] = new ezcPersistentOneToManyRelation( 'src', 'tbl' );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetSetValueFailure()
    {
        $col = new ezcPersistentRelationCollection();
        
        try
        {
            $col['foo'] = array();
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        try
        {
            $col['foo'] = new stdClass();
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        try
        {
            $col['foo'] = 'bar';
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetSetGetSuccess()
    {
        $col = new ezcPersistentRelationCollection();
        
        $rel        = new ezcPersistentOneToManyRelation( 'src', 'dest' );
        $col['foo'] = $rel;

        $this->assertSame(
            $rel,
            $col['foo']
        );
    }

    public function testExchangeArraySuccess()
    {
        $col = new ezcPersistentRelationCollection();
        
        $rel       = new ezcPersistentOneToManyRelation( 'src', 'dest' );
        $secondRel = new ezcPersistentOneToManyRelation( 'src2', 'dst2' );

        $col['foo'] = $rel;

        $col->exchangeArray( array( 'foo' => $secondRel ) );

        $this->assertNotSame(
            $rel,
            $col['foo']
        );
        $this->assertSame(
            $secondRel,
            $col['foo']
        );
    }

    public function testExchangeArrayInvalidOffsetFailure()
    {
        $col = new ezcPersistentRelationCollection();
        $rel = new ezcPersistentOneToManyRelation( 'src', 'dest' );

        try
        {
            $col->exchangeArray( array( '' => $rel ) );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $col->exchangeArray( array( 23 => $rel ) );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testExchangeArrayInvalidValueFailure()
    {
        $col = new ezcPersistentRelationCollection();

        try
        {
            $col->exchangeArray( array( 'foo' => new stdClass() ) );
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $col->exchangeArray( array( 'foo' => 23 ) );
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testSetFlagsSuccess()
    {
        $col = new ezcPersistentRelationCollection();

        $this->assertEquals(
            0,
            $col->getFlags()
        );

        $col->setFlags( 0 );

        $this->assertEquals(
            0,
            $col->getFlags()
        );
    }

    public function testSetFlagsFailure()
    {
        $col = new ezcPersistentRelationCollection();

        try
        {
            $col->setFlags( ArrayObject::ARRAY_AS_PROPS );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $col->setFlags( ArrayObject::STD_PROP_LIST );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $col->setFlags( 'foo' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testAppendFailure()
    {
        $col = new ezcPersistentRelationCollection();

        try
        {
            $col->append( new ezcPersistentOneToManyRelation( 'src', 'dst' ) );
        }
        catch ( Exception $e ) {}
    }

    public function testSetState()
    {
        $expected        = new ezcPersistentRelationCollection();
        $expected['foo'] = new ezcPersistentOneToManyRelation( 'src', 'dst' );

        $this->assertEquals(
            $expected,
            ezcPersistentRelationCollection::__set_state(
                array( 'foo' => new ezcPersistentOneToManyRelation( 'src', 'dst' ) )
            )
        );
    }

    public function testExportImport()
    {
        $expected        = new ezcPersistentRelationCollection();
        $expected['foo'] = new ezcPersistentOneToManyRelation( 'src', 'dst' );

        $this->assertEquals(
            $expected,
            eval( 'return ' . var_export( $expected, true ) . ';' )
        );
    }
}


?>
