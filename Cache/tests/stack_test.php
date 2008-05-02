<?php
/**
 * ezcCacheStackTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcCacheTestStackConfigurator implements ezcCacheStackConfigurator
{
    public static $options;

    public static $storage;

    public static function configure( ezcCacheStack $stack )
    {
        $stack->options = self::$options;
        $stack->pushStorage( self::$storage );
    }
}

/**
 * Test suite for ezcCacheStack class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackTest extends ezcTestCase
{
    /**
     * suite 
     * 
     * @static
     * @access public
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtorNoConfigurator()
    {
        $options  = new ezcCacheStackOptions();
        $location = 'foo';

        $stack = new ezcCacheStack( 'foo' );

        $this->assertAttributeEquals(
            array(
                'location' => 'foo',
                'options'  => new ezcCacheStackOptions(),
            ),
            'properties',
            $stack
        );

        $stack = new ezcCacheStack( 'foo', $options );

        $properties = $this->getObjectAttribute( $stack, 'properties' );

        $this->assertEquals(
            'foo',
            $properties['location']
        );
        $this->assertSame(
            $options,
            $properties['options']
        );
    }

    public function testCtorWithConfigurator()
    {
        $configuredOptions = new ezcCacheStackOptions();
        ezcCacheTestStackConfigurator::$options = $configuredOptions;
        ezcCacheTestStackConfigurator::$storage = new ezcCacheStorageFileArray(
            $this->createTempDir( __FUNCTION__ )
        );

        $options  = new ezcCacheStackOptions();
        $location = 'foo';

        $options->configurator = 'ezcCacheTestStackConfigurator';

        $stack = new ezcCacheStack( $location, $options );

        $this->assertSame(
            $configuredOptions,
            $stack->options
        );
    }
}
?>
