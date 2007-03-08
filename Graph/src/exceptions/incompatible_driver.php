<?php
/**
 * File containing the ezcGraphToolsIncompatibleDriverException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when trying to modify rendered images with incompatible
 * graph tools.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphToolsIncompatibleDriverException extends ezcGraphException
{
    public function __construct( $driver, $accepted )
    {
        $driverClass = get_class( $driver );
        parent::__construct( "Incompatible driver used. Driver '{$driverClass}' is not an instance of '{$accepted}'." );
    }
}

?>
