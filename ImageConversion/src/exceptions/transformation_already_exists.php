<?php
/**
 * File containing the ezcImageTransformationAlreadyExistsException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a transformation with the given name already exists.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageTransformationAlreadyExistsException extends ezcImageException
{
    function __construct( $name )
    {
        parent::__construct( "Transformation '{$name}' already exists." );
    }
}

?>
