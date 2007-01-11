<?php
/**
 * File containing the ezcConfigurationException class
 *
 * @package Configuration
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if the write operation for the configuration failed.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationWriteFailedException extends ezcConfigurationException
{
    function __construct( $path )
    {
        parent::__construct( "The file could not be stored in '{$path}'." );
    }
}
?>
