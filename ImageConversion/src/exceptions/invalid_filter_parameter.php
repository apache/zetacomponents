<?php
/**
 * File containing the ezcImageInvalidFilterParameterException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if the given filter failed.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageInvalidFilterParameterException extends ezcImageException
{
    function __construct( $filterName, $parameterName, $actualValue, $expectedRange = null )
    {
        $actualValue = var_export( $actualValue, true );
        $message = "Wrong value '{$actualValue}' submitted for parameter '{$parameterName}' of filter '{$filterName}'.";
        if ( $expectedRange !== null )
        {
            $message .= " Expected parameter to be in range '{$expectedRange}'.";
        }
        parent::__construct( $message );
    }
}

?>
