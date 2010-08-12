<?php
/**
 * File containing the ezcWebdavInvalidHookException class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Exception thrown if a plugin tries to register for a non-existent hook.
 *
 * If an instance of {@link ezcWebdavPluginConfiguration} returns an invalid
 * class or hook name on the call to {@link
 * ezcWebdavPluginConfiguration::getHooks()}, {@link ezcWebdavPluginRegistry}
 * will throw this exception. This most propably means, that the plugin you try
 * to configure is malicious or works only with a newer version of the Webdav
 * component.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavInvalidHookException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $class and $hook (the hook name
     * that was requested) and sets the exception message from it.
     * 
     * @param string $class
     * @param string $hook
     * @return void
     */
    public function __construct( $class, $hook = null )
    {
        if ( $hook === null )
        {
            $msg = "The class {$class} does not provide any plugin hooks.";
        }
        else
        {
            $msg = "The class {$class} does not provide a plugin hook named {$hook}.";
        }
        parent::__construct( $msg );
    }
}



?>
