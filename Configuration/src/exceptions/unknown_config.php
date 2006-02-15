<?php
/**
 * File containing the ezcConfigurationException class
 *
 * @package Configuration
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if the specified configuration does not exist in the system.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationUnknownConfigException extends ezcConfigurationException
{
    function __construct( $configurationName )
    {
        parent::__construct( "The configuration <{$configurationName}> does not exist." );
    }
}
?>
