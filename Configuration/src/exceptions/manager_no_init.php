<?php
/**
 * File containing the ezcConfigurationManagerNotInitializedException class
 *
 * @package Configuration
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if an invalid class is passed as INI reader to the manager.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationManagerNotInitializedException extends ezcConfigurationException
{
    function __construct()
    {
        parent::__construct( "The manager has not been initialized." );
    }
}
?>
