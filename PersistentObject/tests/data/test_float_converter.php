<?php
/**
 * File containing test code for the PersistentObject component.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

class ezcPersistentPropertyTestFloatConverter implements ezcPersistentPropertyConverter
{
    public function fromDatabase( $databaseValue )
    {
        if ( $databaseValue === null )
        {
            return 42.23;
        }
        return (float) $databaseValue;
    }

    public function toDatabase( $propertyValue )
    {
        if ( $propertyValue === null )
        {
            return 23.42;
        }
        return (float) $propertyValue;
    }

    public static function __set_state( array $state )
    {
        return new ezcPersistentPropertyTestFloatConverter();
    }
}

?>
