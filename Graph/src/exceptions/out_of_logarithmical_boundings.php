<?php
/**
 * File containing the ezcGraphOutOfLogithmicalBoundingsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when data exceeds the values which are displayable on an
 * logarithmical scaled axis.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphOutOfLogithmicalBoundingsException extends ezcGraphException
{
    public function __construct( $minimum )
    {
        parent::__construct( "Data exceeds displayable values on a logarithmical scaled axis." );
    }
}

?>
