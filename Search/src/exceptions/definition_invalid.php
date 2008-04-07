<?php
/**
 * File containing the ezcSearchDefinitionInvalidException class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when a definition file for a class is invalid.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchDefinitionInvalidException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchDefinitionInvalidException
     *
     * @param string $type
     * @param string $class
     * @param string $location
     * @return void
     */
    public function __construct( $type, $class, $location, $extraMsg = false )
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
