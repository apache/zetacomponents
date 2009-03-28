<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
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
class ezcPersistentIdentitySessionOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtorNoArgs()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        $this->assertFalse(
            $opts->refetch
        );
    }

    public function testCtorArgs()
    {
        $opts = new ezcPersistentIdentitySessionOptions(
            array( 'refetch' => true )
        );

        $this->assertTrue(
            $opts->refetch
        );
    }

    public function testGetAccessSuccess()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        $this->assertFalse(
            $opts->refetch
        );
    }

    public function testGetAccessFailure()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        try
        {
            echo $opts->fooBar;
            $this->fail( 'Exception not thrown on get access to non-existent property.' );
        } catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        $this->assertTrue( isset( $opts->refetch ) );
        $this->assertFalse( isset( $opts->fooBar ) );
    }
    
    public function testSetAccessSuccess()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        $this->assertSetProperty(
            $opts,
            'refetch',
            array( true, false )
        );
    }
    
    public function testSetAccessFailure()
    {
        $opts = new ezcPersistentIdentitySessionOptions();

        $this->assertSetPropertyFails(
            $opts,
            'refetch',
            array( null, 23, 42.23, 'foo', array(), new stdClass() )
        );
    }
}

?>
