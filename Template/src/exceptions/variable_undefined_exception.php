<?php
/**
 * File containing the ezcTemplateVariableUndefinedException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for undefined template variables.
 * @package Template
 * @version //autogen//
 */
class ezcTemplateVariableUndefinedException extends Exception
{
    /**
     * Initialises the exception with the name of the variable. The error text
     * is automatically generated.
     *
     * @param string $name The name of the variable which is undefined.
     */
    public function __construct( $name )
    {
        parent::__construct( "Undefined variable: <{$name}>" );
    }

}
?>
