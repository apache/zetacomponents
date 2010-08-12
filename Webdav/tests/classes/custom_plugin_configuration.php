<?php
/**
 * File containing the fooCustomWebdavPluginConfiguration class.
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
 * @subpackage Tests
 * @version //autogen//
 */
class fooCustomWebdavPluginConfiguration extends ezcWebdavPluginConfiguration
{
    public $foo;

    public $callbackCalled = 0;

    public $namespace = 'foonamespace';

    public $hooks;

    public $init = false;

    public function getHooks()
    {
        return ( isset( $this->hooks ) ? $this->hooks : array(
            'ezcWebdavTransport' => array(
                'beforeParseRequest' => array(
                    array( 'ezcWebdavPluginRegistryTest', 'callbackBeforeTest' ),
                    array(  $this, 'testCallback' ),
                ),
                'afterProcessResponse' => array(
                    array( 'ezcWebdavPluginRegistryTest', 'callbackAfterTest' ),
                    array( $this, 'testCallback' )
                ),
            ),
        ) );
    }

    public function testCallback()
    {
        ++$this->callbackCalled;
    }


    public function getNamespace()
    {
        return $this->namespace;
    }

    public function init()
    {
        $this->init = true;
    }
}



?>
