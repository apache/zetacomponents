<?php
/**
 * File containing the ezcGraphUnknownColorDefinitionException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown, when a given value could not be interpreted as a color by
 * ezcGraphColor.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphUnknownColorDefinitionException extends ezcGraphException
{
    public function __construct( $definition )
    {
        parent::__construct( "Unknown color definition '{$definition}'." );
    }
}

?>
