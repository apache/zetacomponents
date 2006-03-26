<?php
/**
 * File containing the ezcDbSchemaValidator class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDbSchemaValidator validates schemas for correctness.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaValidator
{
    static private $validators = array(
        'ezcDbSchemaTypesValidator',
        'ezcDbSchemaIndexFieldsValidator'
    );

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
