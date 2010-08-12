<?php
/**
 * File containing the ezcPersistentObjectSchemaTemplateFunctions class.
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
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Custom template functions for {@link ezcDbSchemaPersistentClassWriter}.
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @access private
 */
class ezcPersistentObjectSchemaTemplateFunctions implements ezcTemplateCustomFunction
{
    /**
     * Registers custom template functions available in this class.
     *
     * Returns the {@link ezcTemplateCustomFunctionDefinition} for template
     * function with $name, if defined in this class. Otherwise returns false.
     * 
     * @param string $name 
     * @return ezcTemplateCustomFunctionDefinition|false
     */
    public static function getCustomFunctionDefinition( $name )
    {
        switch ( $name )
        {
            case 'underScoreToCamelCase':
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = 'underScoreToCamelCase';
                $def->parameters = array( 'name', '[firstLower]' );
                return $def;
        }
        return false;
    }

    /**
     * Convert '_' delimited table/column names to CamelCase.
     *
     * Takes a '_' delimited table/column $name and returns it converted to
     * CamelCase. For example "my_cool_table_name" is converted to
     * "MyCoolTableName". If $firstLower is set to true, the first character of
     * the returned string will be made lower case (for property names).
     *  
     * @param string $name 
     * @param bool $firstLower
     * @return string
     */
    public static function underScoreToCamelCase( $name, $firstLower = false )
    {
        if ( $name == '' )
        {
            return $name;
        }

        $name = implode(
            '',
            array_map(
                'ucfirst',
                explode( '_', $name )
            )
        );

        if ( $firstLower )
        {
            $name = strtolower( $name[0] ) . substr( $name, 1 );
        }
        return $name;
    }
}

?>
