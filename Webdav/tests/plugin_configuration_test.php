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
class ezcWebdavPluginConfigurationTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testGetHooks()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $this->assertEquals(
            array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                        array(  $cfg, 'testCallback' ),
                    ),
                    'afterProcessResponse' => array(
                        array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                        array( $cfg, 'testCallback' )
                    ),
                ),
            ),
            $cfg->getHooks()
        );
    }

    public function testGetNamespace()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $this->assertEquals(
            'foonamespace',
            $cfg->getNamespace()
        );
    }

    public function testInit()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $cfg->init();
        $this->assertTrue(
            $cfg->init
        );
    }
}

?>
