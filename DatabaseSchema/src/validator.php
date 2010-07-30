<?php
/**
 * File containing the ezcDbSchemaValidator class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcDbSchemaValidator validates schemas for correctness.
 *
 * Example:
 * <code>
 * <?php
 * $xmlSchema = ezcDbSchema::createFromFile( 'xml', 'wanted-schema.xml' );
 * $messages = ezcDbSchemaValidator::validate( $xmlSchema );
 * foreach ( $messages as $message )
 * {
 *     echo $message, "\n";
 * }
 * ?>
 * </code>
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @mainclass
 */
class ezcDbSchemaValidator
{
    /**
     * An array containing all the different classes that implement validation methods.
     *
     * The array contains the classnames that implement validators. The
     * validation classes all should implement a method called "validate()"
     * which accepts an ezcDbSchema object.
     */
    static private $validators = array(
        'ezcDbSchemaTypesValidator',
        'ezcDbSchemaIndexFieldsValidator',
        'ezcDbSchemaAutoIncrementIndexValidator',
        'ezcDbSchemaUniqueIndexNameValidator',
    );

    /**
     * Validates the ezcDbSchema object $schema with the recorded validator classes.
     *
     * This method loops over all the known validator classes and calls their
     * validate() method with the $schema as argument. It returns an array
     * containing validation errors as strings.
     * 
     * @todo implement from an interface
     *
     * @param ezcDbSchema $schema
     * @return array(string)
     */
    static public function validate( ezcDbSchema $schema )
    {
        $validationErrors = array();
        
        foreach ( self::$validators as $validatorClass )
        {
            $errors = call_user_func( array( $validatorClass, 'validate' ), $schema );
            foreach ( $errors as $error )
            {
                $validationErrors[] = $error;
            }
        }
        return $validationErrors;
    }
}
?>
