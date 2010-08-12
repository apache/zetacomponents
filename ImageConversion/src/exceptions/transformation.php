<?php
/**
 * File containing the abstract class ezcImageTransformationException.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Exception to be thrown be ezcImageTransformation classes.
 *
 * This is a special exception which is used in ezcImageTransformation to 
 * catch all transformation exceptions. Purpose is to provide a catch
 * all for all transformation inherited excptions, that leaves the source
 * exception in tact for logging or analysis purposes.
 *
 * @see ezcImageTransformation
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageTransformationException extends ezcImageException
{

    /**
     * Stores the parent exception.
     * Each transformation exception is based on a parent, which can be any 
     * ezcImage* exception. The transformation exception deals as a collection 
     * container to catch all these exception at once.
     * 
     * @var ezcImageException
     */
    public $parent;
    
    /**
     * Creates a new ezcImageTransformationException using a parent exception. 
     * Creates a new ezcImageTransformationException and appends an existing
     * exception to it. The ezcImageTransformationException is just the catch-
     * all container. The parent is stored for logging/debugging purpose.
     * 
     * @param ezcBaseException $e Any exception that may occur during
     *                            transformation.
     */
    public function __construct( ezcBaseException $e )
    {
        $this->parent = $e;
        $message = $e->getMessage();
        parent::__construct( "Transformation failed. '{$message}'." );
    }

}
?>
