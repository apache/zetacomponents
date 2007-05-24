<?php
/**
 * File containing the ezcGraphInvalidDataException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when invalid data is provided, which cannot be rendered 
 * for some reason.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphInvalidDataException extends ezcGraphException
{
    public function __construct( $message )
    {
        parent::__construct( "You provided unusable data: '$message'." );
    }
}

?>
