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
 * Exception that is thrown if the specified setting does not exist in the settings.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationUnknownSettingException extends ezcConfigurationException
{
    function __construct( $groupName, $settingName )
    {
        parent::__construct( "The setting '{$groupName}', '{$settingName}' does not exist." );
    }
}
?>
