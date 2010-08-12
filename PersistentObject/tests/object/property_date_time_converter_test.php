<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
