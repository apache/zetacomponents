<?php
/**
 * File containing the ezcDbSchemaOracleWriter class.
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
 * @package DatabaseSchema
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Handler for storing database schemas and applying differences that uses Oracle as backend.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaOracleHelper
{
    /**
     * Constant for the maximum identifier length.
     *
     * @var int
     */
    const IDENTIFIER_MAX_LENGTH = 30;

    /**
     * Generate composite identifier name for sequence or triggers and looking for oracle 30 chars ident restriction.
     * 
     * @param string $tableName
     * @param string $fieldName
     * @param string $suffix
     * @return string
     */
    public static function generateSuffixCompositeIdentName( $tableName, $fieldName, $suffix )
    {
        return self::generateSuffixedIdentName( array( $tableName, $fieldName ), $suffix );
    }

    /**
     * Generate single identifier name for constraints for example obeying oracle 30 chars ident restriction.
     * 
     * @param array $identNames
     * @param string $suffix
     * @return string
     */
    public static function generateSuffixedIdentName( array $identNames, $suffix )
    {
        $ident = implode( "_", $identNames ) . "_" . $suffix;
        $i = 0;
        $last = -1;

        while ( strlen( $ident ) > self::IDENTIFIER_MAX_LENGTH )
        {
            if ( strlen( $identNames[$i] ) > 1 || $last == $i )
            {
                $identNames[$i] = substr( $identNames[$i], 0, strlen( $identNames[$i] ) - 1 );
                $last = $i;
            }
            $i = ( $i + 1 ) % count( $identNames );
            $ident = implode( "_", $identNames ) . "_" . $suffix;
        }
        return $ident;
    }
}
?>
