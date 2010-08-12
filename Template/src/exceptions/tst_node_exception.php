<?php
/**
 * File containing the ezcTemplateTstNodeException class
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
 * @package Template
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception for problems in parser element code.
 *
 * Instantiate the exception with one of the class constants, e.g.:
 * <code>
 * throw new ezcTemplateTstNodeException( ezcTemplateTstNodeException::NO_FIRST_CHILD );
 * </code>
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateTstNodeException extends ezcTemplateException
{
    /**
     * Element has no children, cannot get first child.
     */
    const NO_FIRST_CHILD = 1;

    /**
     * Element has no children, cannot get last child.
     */
    const NO_LAST_CHILD = 2;

    /**
     * Initialises the exception with the type of error which automatically generates an exception message.
     *
     * @param int $type The type of element error.
     * @param string $comment Optional comment for the error, depends on $type.
     */
    public function __construct( $type )
    {
        switch ( $type )
        {
            case self::NO_FIRST_CHILD:
                $message = "Element has no children, cannot get first child.";
                break;
            case self::NO_LAST_CHILD:
                $message = "Element has no children, cannot get last child.";
                break;
        }
        parent::__construct( $message );
    }
}
?>
