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
 * Exception that is thrown if a group is tried to be added, while it already
 * exists.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationGroupExistsAlreadyException extends ezcConfigurationException
{
    function __construct( $groupName )
    {
        parent::__construct( "The settings group '{$groupName}' exists already." );
    }
}
?>
