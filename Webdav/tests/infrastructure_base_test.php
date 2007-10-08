<?php
/**
 * Test case for the ezcWebdavInfrastructureBase class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Mock class to remove "abstract".
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class fooCustomWebdavInfrastructure extends ezcWebdavInfrastructureBase {}

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Tests for ezcWebdavInfrastructureBase class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavInfrastructureBaseTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        // Should register a plugin here to get a namespace
        // no need for now, since ezcWebdavPluginRegistry is not
        // ready, yet, and always returns true.
    }

    public function testSetPluginDataSuccess()
    {
        $base = new fooCustomWebdavInfrastructure();
        
        $base->setPluginData( 'foonamespace', 'barkey', array( 23, 42 ) );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'barkey' => array( 23, 42 ),
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not set correctly.'
        );
        
        $base->setPluginData( 'foonamespace', 'bazkey', true );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'barkey' => array( 23, 42 ),
                    'bazkey' => true,
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not set correctly.'
        );
        
        $base->setPluginData( 'namespacebar', 'keyfoo', new stdClass() );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'barkey' => array( 23, 42 ),
                    'bazkey' => true,
                ),
                'namespacebar' => array(
                    'keyfoo' => new stdClass(),
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not set correctly.'
        );
    }

    public function testSetPluginDataFailure()
    {
        $base = new fooCustomWebdavInfrastructure();

        try
        {
            $base->setPluginData( 'foonamespace', 23, 'foo' );
            $this->fail( 'Exception not thrown on integer key.' );
        }
        catch ( ezcBaseValueException $e ) {}

        /*
        try
        {
            $base->setPluginData( 'unknown namespace', 'bar', 'foo' );
            $this->fail( 'Exception not thrown on integer key.' );
        }
        catch ( ezcBaseValueException $e ) {}
        */
    }

    public function testRemovePluginDataSuccess()
    {
        $base = new fooCustomWebdavInfrastructure();

        $base->setPluginData( 'foonamespace', 'barkey', array( 23, 42 ) );
        $base->setPluginData( 'foonamespace', 'bazkey', true );
        $base->setPluginData( 'namespacebar', 'keyfoo', new stdClass() );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'barkey' => array( 23, 42 ),
                    'bazkey' => true,
                ),
                'namespacebar' => array(
                    'keyfoo' => new stdClass(),
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not unset correctly.'
        );

        $base->removePluginData( 'foonamespace', 'barkey' );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'bazkey' => true,
                ),
                'namespacebar' => array(
                    'keyfoo' => new stdClass(),
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not unset correctly.'
        );

        $base->removePluginData( 'namespacebar', 'keyfoo' );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                    'bazkey' => true,
                ),
                'namespacebar' => array(
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not unset correctly.'
        );

        $base->removePluginData( 'foonamespace', 'bazkey' );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                ),
                'namespacebar' => array(
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not unset correctly.'
        );

        $base->removePluginData( 'unkown namespace', 'unknown key' );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => array(
                ),
                'namespacebar' => array(
                ),
            ),
            'pluginData',
            $base,
            'Plugin data not unset correctly.'
        );
    }
}



?>
