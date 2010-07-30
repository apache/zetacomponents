<?php
/**
 * File containing the ezcPersistentSessionInstance class
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
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Holds persistent object session instances for global access throughout an application.
 *
 * Typical usage example:
 * <code>
 * $session = new ezcPersistentSession( ezcDbInstance::get(),
 *                                       new ezcPersistentCodeManager( ... ) );
 * ezcPersistentSessionInstance::set( $session ); // set default session
 * $session2 = new ezcPersistentSession( ezcDbInstance::get( 'other_db' ),
 *                                       new ezcPersistentCodeManager( ... ) );
 * ezcPersistentSessionInstance::set( $session2, 'extra' ); // set the extra session
 *
 * // retrieve the sessions
 * $session = ezcPersistentSessionInstance::get();
 * $session2 = ezcPersistentSessionInstance::get( 'extra' );
 * </code>
 *
 * @package PersistentObject
 * @version //autogen//
 * @mainclass
 */
class ezcPersistentSessionInstance
{
    /**
     * Identifier of the instance that will be returned
     * when you call get() without arguments.
     *
     * @see ezcPersistentSessionInstance::get()
     * @var string
     */
    static private $defaultInstanceIdentifier = null;

    /**
     * Holds the session instances.
     *
     * Example:
     * <code>
     * array( 'server1' => [object],
     *        'server2' => [object] );
     * </code>
     *
     * @var array(string=>ezcPersistentSession)
     */
    static private $instances = array();

    /**
     * Returns the persistent session instance named $identifier.
     *
     * If $identifier is ommited the default persistent session
     * specified by chooseDefault() is returned.
     *
     * @throws ezcPersistentSessionNotFoundException if the specified instance is not found.
     * @param string $identifier
     * @return ezcPersistentSession
     */
    public static function get( $identifier = null )
    {
        if ( $identifier === null && self::$defaultInstanceIdentifier )
        {
            $identifier = self::$defaultInstanceIdentifier;
        }

        if ( !isset( self::$instances[$identifier] ) )
        {
            // The ezcInitPersistentSessionInstance callback should return an
            // ezcPersistentSession object which will then be set as instance.
            $ret = ezcBaseInit::fetchConfig( 'ezcInitPersistentSessionInstance', $identifier );
            if ( $ret === null )
            {
                throw new ezcPersistentSessionNotFoundException( $identifier );
            }
            else
            {
                self::set( $ret, $identifier );
            }
        }

        return self::$instances[$identifier];
    }

    /**
     * Adds the persistent session $session to the list of known instances.
     *
     * If $identifier is specified the persistent session instance can be
     * retrieved later using the same identifier. If $identifier is ommited
     * the default instance will be set.
     *
     * @param ezcPersistentSessionFoundation $session
     * @param string $identifier the identifier of the database handler
     * @return void
     */
    public static function set( ezcPersistentSessionFoundation $session, $identifier = null )
    {
        if ( $identifier === null )
        {
            $identifier = self::$defaultInstanceIdentifier;
        }

        self::$instances[$identifier] = $session;
    }

    /**
     * Sets the database $identifier as default database instance.
     *
     * To retrieve the default database instance
     * call get() with no parameters..
     *
     * @see ezcPersistentSessionInstance::get().
     * @param string $identifier
     * @return void
     */
    public static function chooseDefault( $identifier )
    {
        self::$defaultInstanceIdentifier = $identifier;
    }

    /**
     * Resets the default instance holder.
     *
     * @return void
     */
    public static function resetDefault()
    {
        self::$defaultInstanceIdentifier = false;
    }

    /**
     * Resets the complete class.
     *
     * @return void
     */
    public static function reset()
    {
        self::$defaultInstanceIdentifier = null;
        self::$instances = array();
    }
}
?>
