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
 * Exception that is thrown if the name of a setting is not a string.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationSettingnameNotStringException extends ezcConfigurationException
{
    function __construct( $settingName )
    {
        $settingNameType = gettype( $settingName );
        parent::__construct( "The setting name that was passed is not a string, but an '{$settingNameType}'." );
    }
}
?>
