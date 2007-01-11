<?php
/**
 * File containing the ezcImageHandlerSettingsInvalidException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if invalid handler settings are submitted when creating an
 * {@link ezcImageConverter}.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageHandlerSettingsInvalidException extends ezcImageException
{
    function __construct( $name )
    {
        parent::__construct( "Transformation '{$name}' does not exists." );
    }
}

?>
