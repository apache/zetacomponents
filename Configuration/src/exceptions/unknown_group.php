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
 * Exception that is thrown if the specified group does not exist in the settings.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationUnknownGroupException extends ezcConfigurationException
{
    function __construct( $groupName )
    {
        parent::__construct( "The settings group <{$groupName}> does not exist." );
    }
}
?>
