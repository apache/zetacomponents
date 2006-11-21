<?php
/**
 * File containing the ezcGraphSvgDriverInvalidIdException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a id could not be found in a SVG document to insert 
 * elements in.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphSvgDriverInvalidIdException extends ezcGraphException
{
    public function __construct( $id )
    {
        parent::__construct( "Could not find element with id '{$id}' in SVG document." );
    }
}

?>
