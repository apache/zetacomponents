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
 * Tests the ezcPersistentObjecProperties class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectPropertiesTest extends ezcTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentObjectPropertiesTest' );
    }

    public function testConstructureSuccess()
    {
        $properties = new ezcPersistentObjectProperties();
        $this->assertEquals(
            0,
            count( $properties )
        );
    }

    public function testArrayAccessSuccess()
    {
        $properties = new ezcPersistentObjectProperties();
        $property = new ezcPersistentObjectProperty();
        $properties['foo'] = $property;

        $this->assertEquals(
            1,
            count( $properties )
        );
        $this->assertSame(
            $property,
            $properties['foo']
        );
    }

    public function testArrayAccessFailure()
    {
        $properties = new ezcPersistentObjectProperties();

        $this->genericArrayAccessFailure(
            $properties,
            'foo',
            array(
                23, 23.42, true, "test", array(), new stdClass(),
            ),
            'ezcBaseValueException'
        );
        $this->genericArrayAccessFailure(
            $properties,
            23,
            array(
                new ezcPersistentObjectProperty(),
            ),
            'ezcBaseValueException'
        );
    }

    public function testExchangeArraySuccess()
    {
        $properties = new ezcPersistentObjectProperties();
        $properties['foo'] = new ezcPersistentObjectProperty();
        
        $this->assertEquals(
            1,
            count( $properties )
        );

        $properties->exchangeArray( array() );
        $this->assertEquals(
            0,
            count( $properties )
        );

        $properties->exchangeArray(
            array(
                'foo' => new ezcPersistentObjectProperty(),
                'bar' => new ezcPersistentObjectProperty(),
            )
        );
        $this->assertEquals(
            2,
            count( $properties )
        );
    }

    public function testExchangeArrayFailure()
    {
        $properties = new ezcPersistentObjectProperties();
        $properties['foo'] = new ezcPersistentObjectProperty();
        
        $this->assertEquals(
            1,
            count( $properties )
        );

        try
        {
            $properties->exchangeArray(
                array( 'foo' => 23 )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid value in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $properties->exchangeArray(
                array( 23 => new ezcPersistentObjectProperty )
            );
            $this->fail( 'ezcBaseValueException not thrown on invalid offset in exchange array.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testSetFlagsSuccess()
    {
        $properties = new ezcPersistentObjectProperties();
        $properties->setFlags( 0 );
        $this->assertEquals(
            0,
            $properties->getFlags()
        );
    }

    public function testSetFlagsFailure()
    {
        $properties = new ezcPersistentObjectProperties();

        try
        {
            $properties->setFlags( 23 );
            $this->fail( 'ezcBaseValueException not thrown on flags different to 0.' );
        }
        catch ( ezcBaseValueException $e ) {}
        $this->assertEquals(
            0,
            $properties->getFlags()
        );
    }

    public function testAppendFailure()
    {
        $properties = new ezcPersistentObjectProperties();

        try
        {
            $properties[] = new ezcPersistentObjectProperty();
            $this->fail( 'ezcBaseValueException not thrown on trying to append.' );
        }
        catch ( Exception $e ) {}
        $this->assertEquals(
            0,
            count( $properties )
        );
    }

    protected function genericArrayAccessFailure( ArrayAccess $properties, $offset, array $values, $exceptionClass )
    {
        foreach ( $values as $value )
        {
            try
            {
                $properties[$offset] = $value;
                $this->fail( $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $properties ) . '.' );
            }
            catch ( Exception $e )
            {
                $this->assertEquals(
                    $exceptionClass,
                    get_class( $e ),
                    $exceptionClass . ' not thrown on value ' . gettype( $value ) . ' for offset ' . $offset . ' in class ' . get_class( $properties ) . ', ' . get_class( $e ) . ' thrown instead.'
                );
            }
        }
    }

}


?>
