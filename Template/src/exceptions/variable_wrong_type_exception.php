<?php
/**
 * File containing the ezcTemplateVariableWrongTypeException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for problems with type of template variables.
 * @package Template
 * @version //autogen//
 */
class ezcTemplateVariableWrongTypeException extends Exception
{
    /**
     * Initialises the exception with the name, expected and actual type
     * value. The error text is automatically generated.
     *
     * @param string $name The name of the variable which has the wrong type.
     * @param int $actual The actual type value.
     * @param int $expected The expected type value.
     */
    public function __construct( $name, $expected, $actual )
    {
        parent::__construct( "Wrong type for variable: <{$name}>, expected: <${expected}>, got: <${actual}>" );
    }

}
?>
