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
 * Tests the ezcPersistentPropertyDateTimeConverter class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentPropertyDateTimeConverterTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentPropertyDateTimeConverterTest' );
    }

    public function testFromDatabaseSuccess()
    {
        $conv = new ezcPersistentPropertyDateTimeConverter();

        $this->assertEquals(
            new DateTime( '@327535200' ),
            $conv->fromDatabase( 327535200 ),
            'Conversion of positive time stamp from database failed.'
        );

        $this->assertEquals(
            new DateTime( '@-1000' ),
            $conv->fromDatabase( -1000 ),
            'Conversion of positive time stamp from database failed.'
        );
        
        $this->assertEquals(
            new DateTime( '@327535200' ),
            $conv->fromDatabase( '327535200' ),
            'Conversion of positive time stamp as string from database failed.'
        );

        $this->assertNull(
            $conv->fromDatabase( null ),
            'Conversion of null value failed.'
        );
    }

    public function testFromDatabaseFailure()
    {
        $conv = new ezcPersistentPropertyDateTimeConverter();

        $values = array(
            'Test string',
            true,
            false,
            new stdClass(),
            array( 23, 42 )
        );

        foreach ( $values as $value )
        {
            try
            {
                $res = $conv->fromDatabase( $value );
                $this->fail( 'Exception not thrown on illegal converter of type ' . gettype( $value ) );
            }
            catch ( ezcBaseValueException $e ) {}
        }
    }

    public function testToDatabaseSuccess()
    {
        $conv = new ezcPersistentPropertyDateTimeConverter();

        $this->assertEquals(
            327535200,
            $conv->toDatabase( new DateTime( '@327535200' ) ),
            'Conversion of positive time stamp to database failed.'
        );

        $this->assertEquals(
            -1000,
            $conv->toDatabase( new DateTime( '@-1000' ) ),
            'Conversion of positive time stamp to database failed.'
        );

        $this->assertNull(
            $conv->toDatabase( null ),
            'Conversion of null value failed.'
        );
    }
    
    public function testToDatabaseFailure()
    {
        $conv = new ezcPersistentPropertyDateTimeConverter();

        $values = array(
            23,
            23.42,
            'Test string',
            true,
            false,
            new stdClass(),
            array( 23, 42 )
        );

        foreach ( $values as $value )
        {
            try
            {
                $res = $conv->toDatabase( $value );
                $this->fail( 'Exception not thrown on illegal converter of type ' . gettype( $value ) );
            }
            catch ( ezcBaseValueException $e ) {}
        }
    }

}


?>
