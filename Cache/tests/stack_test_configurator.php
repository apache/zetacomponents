<?php
/**
 * ezcCacheStackTestConfigurator
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
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Configurator class
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackTestConfigurator implements ezcCacheStackConfigurator
{
    public static $storages  = array();

    public static $metaStorage;

    public static $options;

    public static function configure( ezcCacheStack $stack )
    {
        foreach ( self::$storages as $storageConf )
        {
            $stack->pushStorage( $storageConf );
        }
        if ( self::$metaStorage !== null )
        {
            $stack->options->metaStorage = self::$metaStorage;
        }
        if ( self::$options !== null )
        {
            $stack->options = self::$options;
        }
    }

    public static function reset()
    {
        self::$storages    = array();
        self::$metaStorage = null;
        self::$options     = null;
    }
}

?>
