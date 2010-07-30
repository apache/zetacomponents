<?php
/**
 * File containing the ezcTemplateType class
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * This class contains a bundle of static functions, each implementing a specific
 * function used inside the template language. 
 
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateType
{
    /**
     * Returns true if the given value is empty, otherwise false.
     *
     * This method couldn't be translated directly because the parameter
     * of empty should always be a variable. 
     *
     * This wrapper function makes it possible to call: is_empty("");
     *
     * @param mixed $var
     * @return bool
     */
    public static function is_empty( $var )
    {
        return empty( $var );
    }

    /**
     * Returns true if the given variable $var is an instance of the class $class. 
     *
     * @param mixed $var
     * @param string $class
     * @return bool
     */
    public static function is_instance( $var, $class )
    {
        return ($var instanceof $class);
    }
}


?>
