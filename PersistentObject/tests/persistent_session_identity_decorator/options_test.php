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
 * Tests the load facilities of ezcPersistentIdenitySessionOptions.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtorNoArgs()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        $this->assertFalse(
            $opts->refetch
        );
    }

    public function testCtorArgs()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions(
            array( 'refetch' => true )
        );

        $this->assertTrue(
            $opts->refetch
        );
    }

    public function testGetAccessSuccess()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        $this->assertFalse(
            $opts->refetch
        );
    }

    public function testGetAccessFailure()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        try
        {
            echo $opts->fooBar;
            $this->fail( 'Exception not thrown on get access to non-existent property.' );
        } catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        $this->assertTrue( isset( $opts->refetch ) );
        $this->assertFalse( isset( $opts->fooBar ) );
    }
    
    public function testSetAccessSuccess()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        $this->assertSetProperty(
            $opts,
            'refetch',
            array( true, false )
        );
    }
    
    public function testSetAccessFailure()
    {
        $opts = new ezcPersistentSessionIdentityDecoratorOptions();

        $this->assertSetPropertyFails(
            $opts,
            'refetch',
            array( null, 23, 42.23, 'foo', array(), new stdClass() )
        );
    }
}

?>
