<?php
/**
 * Test case for the ezcWebdavInfrastructureBase class.
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
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Mock class to remove "abstract".
 * 
 * @package Webdav
 * @version //autogen//
 */
class fooCustomWebdavInfrastructure extends ezcWebdavInfrastructureBase {}

/**
 * Reqiuire base test
 */

/**
 * Require mocked version of ezcWebdavPluginConfiguration. 
 */
require_once 'classes/custom_plugin_configuration.php';

/**
 * Tests for ezcWebdavInfrastructureBase class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavInfrastructureBaseTest extends ezcTestCase
{
    protected $namespaces = array();

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        $srv = ezcWebdavServer::getInstance();

        $this->namespaces['foonamespace'] = new fooCustomWebdavPluginConfiguration();

        $this->namespaces['namespacebar'] = new fooCustomWebdavPluginConfiguration();
        $this->namespaces['namespacebar']->namespace = 'namespacebar';

        $srv->pluginRegistry->registerPlugin( $this->namespaces['foonamespace'] );
        $srv->pluginRegistry->registerPlugin( $this->namespaces['namespacebar'] );
    }

    protected function tearDown()
    {
        $srv = ezcWebdavServer::getInstance();

        $srv->pluginRegistry->unregisterPlugin( $this->namespaces['foonamespace'] );
        $srv->pluginRegistry->unregisterPlugin( $this->namespaces['namespacebar'] );
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
    }

    public function testRemovePluginDataFailure()
    {
        $base = new fooCustomWebdavInfrastructure();

        $base->setPluginData( 'foonamespace', 'barkey', array( 23, 42 ) );
        $base->setPluginData( 'foonamespace', 'bazkey', true );
        $base->setPluginData( 'namespacebar', 'keyfoo', new stdClass() );

        try
        {
            $base->removePluginData( 'unkown namespace', 'unknown key' );
            $this->fail( 'Exception not thrown on removal of data from unknown plugin namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}

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
    }
}



?>
