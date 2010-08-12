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
class ezcWebdavPluginRegistryTest extends ezcTestCase
{
    private static $beforeParams;

    private static $afterParams;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    protected function setUp()
    {
        self::$beforeParams = null;
        self::$afterParams  = null;
    }

    public static function callbackBeforeTest( ezcWebdavPluginParameters $params )
    {
        self::$beforeParams = $params;
    }

    public static function callbackAfterTest( ezcWebdavPluginParameters $params )
    {
        self::$afterParams = $params;
    }

    public function testCtor()
    {
        $reg = new ezcWebdavPluginRegistry();

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(),
            'plugins',
            $reg,
            'Attribute $plugins not initialized correctly.'
        );

    }

    public function testRegisterPluginSuccess()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                            array(  $cfg, 'testCallback' ),
                        ),
                    ),
                    'afterProcessResponse' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                            array( $cfg, 'testCallback' ),
                        ),
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );
    }

    public function testRegisterPluginFailureDoubleRegister()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg
            ),
            'plugins',
            $reg
        );

        try
        {
            $reg->registerPlugin( $cfg );
            $this->fail( 'Exception not thrown on double registered namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testRegisterPluginFailureInvalidNamespace()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();
        $reg->namespace = true;

        $reg->registerPlugin( $cfg );
        
        try
        {
            $reg->registerPlugin( $cfg );
            $this->fail( 'Exception not thrown on double registered namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testRegisterPluginFailureInvalidHooks()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $cfg->hooks = true;

        $reg = new ezcWebdavPluginRegistry();

        try
        {
            $reg->registerPlugin( $cfg );
            $this->fail( 'Exception not thrown on double registered namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testRegisterPluginFailureInvalidHookClass()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $cfg->hooks = array(
            'fooMyClass' => array(),
        );

        $reg = new ezcWebdavPluginRegistry();

        try
        {
            $reg->registerPlugin( $cfg );
            $this->fail( 'Exception not thrown on double registered namespace.' );
        }
        catch ( ezcWebdavInvalidHookException $e ) {}
    }

    public function testRegisterPluginFailureInvalidHook()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $cfg->hooks = array(
            'ezcWebdavTransport' => array(
                'beforeMyCustomHook' => array(),
            ),
        );

        $reg = new ezcWebdavPluginRegistry();

        try
        {
            $reg->registerPlugin( $cfg );
            $this->fail( 'Exception not thrown on double registered namespace.' );
        }
        catch ( ezcWebdavInvalidHookException $e ) {}
    }

    public function testUnregisterPluginSuccess()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                            array(  $cfg, 'testCallback' ),
                        ),
                    ),
                    'afterProcessResponse' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                            array( $cfg, 'testCallback' ),
                        ),
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        $reg->unregisterPlugin( $cfg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );
        
        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                    ),
                    'afterProcessResponse' => array(
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );
    }

    public function testUnregisterPluginFailureUnknown()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );

        try
        {
            $reg->unregisterPlugin( $cfg );
            $this->fail( 'Exception not thrown on unregistering unknown namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testUnregisterPluginFailureInvalidNamespace()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $cfg->namespace = true;
        $reg = new ezcWebdavPluginRegistry();
        
        try
        {
            $reg->unregisterPlugin( $cfg );
            $this->fail( 'Exception not thrown on unregistering invalid namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }
    
    public function testGetPluginConfigSuccess()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg,
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                            array(  $cfg, 'testCallback' ),
                        ),
                    ),
                    'afterProcessResponse' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                            array( $cfg, 'testCallback' ),
                        ),
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        $this->assertEquals(
            $cfg,
            $reg->getPluginConfig( 'foonamespace' )
        );
    }
    
    public function testGetPluginConfigFailure()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        try
        {
            $reg->getPluginConfig( 'foonamespace' );
            $this->fail( 'Exception not thrown on get of unknown plugin namespace.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );
    }
    
    public function testHasPluginConfigSuccess()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg,
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                            array(  $cfg, 'testCallback' ),
                        ),
                    ),
                    'afterProcessResponse' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                            array( $cfg, 'testCallback' ),
                        ),
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        $this->assertTrue(
            $reg->hasPlugin( 'foonamespace' )
        );
    }
    
    public function testHasPluginConfigFailure()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        $this->assertFalse(
            $reg->hasPlugin( 'foonamespace' )
        );

        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );
    }
    
    public function testAnnounceHookSuccess()
    {
        $cfg = new fooCustomWebdavPluginConfiguration();
        $reg = new ezcWebdavPluginRegistry();

        $reg->registerPlugin( $cfg );
        
        $this->assertHooksCorrect( $reg );

        $this->assertAttributeEquals(
            array(
                'foonamespace' => $cfg,
            ),
            'plugins',
            $reg
        );

        $this->assertAttributeEquals(
             array(
                'ezcWebdavTransport' => array(
                    'beforeParseRequest' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                            array(  $cfg, 'testCallback' ),
                        ),
                    ),
                    'afterProcessResponse' => array(
                        'foonamespace' => array(
                            array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                            array( $cfg, 'testCallback' ),
                        ),
                    ),
                ),
            ),
            'assignedHooks',
            $reg,
            'Property $assignedHooks not set correctly after registration.'
        );

        $reg->announceHook( 'ezcWebdavTransport', 'beforeParseRequest', ( $beforeParams = new ezcWebdavPluginParameters() ) );

        $this->assertSame(
            $beforeParams,
            self::$beforeParams,
            'Params of before callback invalid'
        );

        $this->assertNull(
            self::$afterParams,
            'Params of after callback invalid'
        );

        $this->assertEquals(
            1,
            $cfg->callbackCalled,
            'Number of called callbackes invalid.'
        );

        $reg->announceHook( 'ezcWebdavTransport', 'afterProcessResponse', ( $afterParams = new ezcWebdavPluginParameters() ) );

        $this->assertSame(
            $beforeParams,
            self::$beforeParams,
            'Params of before callback invalid'
        );

        $this->assertEquals(
            new ezcWebdavPluginParameters(),
            self::$beforeParams,
            'Params of before callback invalid'
        );

        $this->assertSame(
            $afterParams,
            self::$afterParams,
            'Params of after callback invalid'
        );

        $this->assertEquals(
            2,
            $cfg->callbackCalled,
            'Number of called callbackes invalid.'
        );
    }


    protected function assertHooksCorrect( ezcWebdavPluginRegistry $reg )
    {
        $this->assertAttributeEquals(
            array (
                'ezcWebdavTransport' => array (
                    'beforeParseRequest'     => true,
                    'afterProcessResponse'   => true,
                    'parseUnknownRequest'    => true,
                    'processUnknownResponse' => true,
                ),
                'ezcWebdavPropertyHandler' => array(
                    'extractDeadProperty'          => true,
                    'serializeDeadProperty'        => true,
                    'extractUnknownLiveProperty'   => true,
                    'serializeUnknownLiveProperty' => true,
                ),
                'ezcWebdavServer' => array (
                    'receivedRequest'   => true,
                    'generatedResponse' => true,
                ),
            ),
            'hooks',
            $reg,
            'Attribute $hooks is invalid.'
        );
    }
}

?>
