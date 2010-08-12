<?php
/**
 * File containing the ezcWebdavLockIfHeaderTaggedList class.
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
 *
 * @access private
 */
/**
 * List class for If header values, if they are tagged.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockIfHeaderTaggedList extends ezcWebdavLockIfHeaderList
{
    /**
     * List items. 
     * 
     * @var array(string=>array(ezcWebdavLockIfHeaderListItem))
     */
    protected $items;

    /**
     * Creates a new tagged If header list.
     *
     * This list contains items of type {@link ezcWebdavLockIfHeaderListItem}
     * assigned to resource pathes. The list of $items can be given during
     * construction and might be manipulated later through the ArrayAccess
     * interface.
     *
     * @param array $items
     */
    public function __construct( array $items = array() )
    {
        $this->items = $items;
    }

    /**
     * Returns if the given $offset exists.
     * 
     * @param string $offset 
     * @return bool
     *
     * @throws ezcBaseValueException
     *         if $offset is not a string with length > 0.
     */
    public function offsetExists( $offset )
    {
        if ( !is_string( $offset ) || strlen( $offset ) < 1 )
        {
            throw new ezcBaseValueException(
                'offset',
                $offset,
                'string, length > 0',
                'Offset must be a valid path.'
            );
        }

        return isset( $this->items[$offset] );
    }

    /**
     * Returns the value of the given offset.
     *
     * Returns an instance of {@link ezcWebdavLockIfHeaderListItem}, if it
     * exists, null otherwise.
     * 
     * @param string $offset 
     * @return ezcWebdavLockIfHeaderListItem|null
     *
     * @throws ezcBaseValueException
     *         if $offset is not a string with length > 0.
     */
    public function offsetGet( $offset )
    {
        if ( $this->offsetExists( $offset ) )
        {
            return $this->items[$offset];
        }
        return array();
    }

    /**
     * Set a new $offset with $value.
     *
     * $offset must be a string with length > 0 (a resource path) and $value
     * must be an instance of {@link ezcWebdavLockIfHeaderListItem}.
     * 
     * @param string $offset 
     * @param ezcWebdavLockIfHeaderListItem $value 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if $offset or $value are not of the correct type.
     */
    public function offsetSet( $offset, $value )
    {
        if ( !is_string( $offset ) || strlen( $offset ) < 1 )
        {
            throw new ezcBaseValueException(
                'offset',
                $offset,
                'string, length > 0',
                'Offset must be a valid path.'
            );
        }

        if ( !is_array( $value ) )
        {
            throw new ezcBaseValueException(
                'value',
                $value,
                'ezcWebdavLockIfHeaderListItem'
            );
        }

        $this->items[$offset] = $value;
    }

    /**
     * Unset the given offset.
     * 
     * @param string $offset 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if $offset is not a string with length > 0.
     */
    public function offsetUnset( $offset )
    {
        if ( !is_string( $offset ) || strlen( $offset ) < 1 )
        {
            throw new ezcBaseValueException(
                'offset',
                $offset,
                'string, length > 0',
                'Offset must be a valid path.'
            );
        }

        unset( $this->items[$offset] );
    }

    /**
     * Returns all lock tokens submitted in the header.
     *
     * This method returns a list of all lock tokens (without duplicates) that
     * are present in the If header represented by this list.
     * 
     * @return array(string)
     *
     * @todo This should be cached as long as the list is not changed.
     */
    public function getLockTokens()
    {
        $tokens = array();
        foreach ( $this->items as $itemList )
        {
            foreach( $itemList as $item )
            {
                $tokens = array_merge( $tokens, $item->lockTokens );
            }
        }
        return array_unique(
            array_map( 'strval', $tokens )
        );
    }
}

?>
