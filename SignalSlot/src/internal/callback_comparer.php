<?php
/**
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @access private
 */

/**
 * Check if two callbacks are the same or not.
 *
 * @version //autogen//
 * @mainclass
 * @package SignalSlot
 * @access private
 */
class ezcSignalCallbackComparer
{
    /**
     * Returns true if the callbacks $a and $b are the same.
     *
     * @param callback $a
     * @param callback $b
     * @return bool
     */
    public static function compareCallbacks( $a, $b )
    {
        if ( is_string( $a ) || is_string( $b ) )
        {
            return $a === $b;
        }
        return ( count( array_udiff( $a, $b, array( 'ezcSignalCallbackComparer', 'comp_func') ) ) == 0 );
    }

    /**
     * Checks if $a and $b are of the exact same.
     *
     * Note: This method does not support arrays as you may not have array's in callbacks.
     *
     * @param mixed $a
     * @param mixed $b
     * @return int 0 if same 1 or -1 if not.
     */
    public static function comp_func( $a, $b )
    {
        if ( $a === $b )
        {
            return 0;
        }
        return 1;
    }
}
?>
