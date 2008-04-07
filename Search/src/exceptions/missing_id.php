<?php
/**
 * File containing the ezcSearchDefinitionMissingIdPropertyException class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the definition does not specify an ID property.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchDefinitionMissingIdPropertyException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchDefinitionMissingIdPropertyException
     *
     * @param string $type
     * @param string $class
     * @param string $location
     * @return void
     */
    public function __construct( $type, $location )
    {
        if ( $extraMsg )
        {
            $extraMsg = " ($extraMsg)";
        }
        $message = "The $type definition file for '$class' at '$location' is invalid{$extraMsg}.";
        parent::__construct( $message );
    }
}
?>
