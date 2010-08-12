<?php
/**
 * File containing the ezcImageInvalidReferenceException.
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
 * @package ImageConversion
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Thrown if no valid image reference could be found for an action (conversion,
 * filter, load, save,...).
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageInvalidReferenceException extends ezcImageException
{
    /**
     * Creates a new ezcImageInvalidReferenceException.
     * 
     * @param string $reason The reason.
     * @return void
     */
    function __construct( $reason = null )
    {
        $reasonPart = "";
        if ( $reason )
        {
            $reasonPart = " $reason";
        }
        parent::__construct( "No valid reference found for action.{$reasonPart}" );
    }
}

?>
