<?php
/**
 * File containing the ezcImageTransformationNotAvailableException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a transformation with the given name does not exists.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageTransformationNotAvailableException extends ezcImageException
{
    function __construct( $name )
    {
        parent::__construct( "Transformation '{$name}' does not exists." );
    }
}

?>
