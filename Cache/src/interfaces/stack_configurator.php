<?php
/**
 * File containing the ezcCacheStackConfigurator interface.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Interface to be implemented by stack configurator classes.
 *
 * To allow the usage of {@link ezcCacheStack} with the {@link
 * ezcCacheManager}, a class implementing this interface is necessary. The name
 * of the class must be stored in the {@link ezcCacheStackOptions} defined for
 * the stack in the manager. As soon as the stack is requested by the user for
 * the first time, a new {@link ezcCacheStack} object will be created in the
 * manager. This object will be given to the {@link
 * ezcCacheStackConfigurator->configure()} method of the class named in the
 * options.
 * 
 * @package Cache
 * @version //autogentag//
 */
interface ezcCacheStackConfigurator
{
    /**
     * Configures the given stack.
     *
     * This method configures the given $stack object. The object is usually
     * expected to be newly constructed after this method receives it. If given
     * in a class implemnting this interface is given in {@link
     * ezcCacheStackOptions}, this method will be called automatically from
     * {@link ezcCacheStack->__construct()}.
     *
     * This method is expected to use the {@link ezcCacheStack->pushStorage()}
     * method to configure storages in the stack.
     * 
     * @param ezcCacheStack $stack 
     * @return void
     */
    public static function configure( ezcCacheStack $stack );
}

?>
