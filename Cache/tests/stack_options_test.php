<?php
/**
 * ezcCacheStackOptionsTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcCacheTestDummyStackConfigurator implements ezcCacheStackConfigurator
{
    public static function configure( ezcCacheStack $stack )
    {
        // Dummy
    }
}

/**
 * Test suite for the ezcCacheStackOptions class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackOptionsTest extends ezcTestCase
{
    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtorDefaultSuccess()
    {
        $opts = new ezcCacheStackOptions();
        $this->assertAttributeEquals(
            array(
                'configurator'        => null,
                'metaStorage'         => null,
                'replacementStrategy' => 'ezcCacheStackLruReplacementStrategy',
                'bubbleUpOnRestore'   => false,
            ),
            'properties',
            $opts,
            'Default options incorrect.'
        );
    }

    public function testCtorNonDefaultSuccess()
    {
        $optArray = array(
            'configurator'        => 'ezcCacheTestDummyStackConfigurator',
            // @TODO: Should be a valid storage object.
            'metaStorage'         => null,
            'replacementStrategy' => 'ezcCacheStackLfuReplacementStrategy',
            'bubbleUpOnRestore'   => true,
        );
        $opts = new ezcCacheStackOptions( $optArray );
        $this->assertAttributeEquals(
            $optArray,
            'properties',
            $opts,
            'Options set via ctor incorrect.'
        );
    }

    public function testSetSuccess()
    {
        $metaDataStorage = $this->getMock( 'ezcCacheStackMetaDataStorage' );

        $opts = new ezcCacheStackOptions();
        $this->assertSetProperty(
            $opts,
            'configurator',
            array( 'ezcCacheTestDummyStackConfigurator', null )
        );

        $this->assertSetProperty(
            $opts,
            'metaStorage',
            array( $metaDataStorage )
        );
        $this->assertSetProperty(
            $opts,
            'replacementStrategy',
            array( 'ezcCacheStackLfuReplacementStrategy', 'ezcCacheStackLruReplacementStrategy' )
        );
        $this->assertSetProperty(
            $opts,
            'bubbleUpOnRestore',
            array( true, false )
        );
    }

    public function testSetFailure()
    {
        $nonMetaDataStorage = $this->getMock(
            'ezcCacheStorage',
            array(
                'validateLocation',
                'store',
                'restore',
                'delete',
                'countDataItems',
                'getRemainingLifetime'
            ),
            array(),
            '',
            false
        );

        $opts = new ezcCacheStackOptions();
        $this->assertSetPropertyFails(
            $opts,
            'configurator',
            array( true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'metaStorage',
            array( true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass(), $nonMetaDataStorage )
        );
        $this->assertSetPropertyFails(
            $opts,
            'replacementStrategy',
            array( null, true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'bubbleUpOnRestore',
            array( null, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );

        try
        {
            $opts->fooBar = 23;
            $ths->fail( 'Exception not thrown on access to unknown option.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testGetSuccess()
    {
        $opts = new ezcCacheStackOptions();
        $this->assertEquals( null, $opts->configurator );
        $this->assertEquals( null, $opts->metaStorage );
        $this->assertEquals( 'ezcCacheStackLruReplacementStrategy', $opts->replacementStrategy );
        $this->assertEquals( false, $opts->bubbleUpOnRestore );
    }

    public function testGetFailure()
    {
        $opts = new ezcCacheStackOptions();
        try
        {
            echo $opts->fooBar;
            $ths->fail( 'Exception not thrown on access to unknown option.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }
}

?>
