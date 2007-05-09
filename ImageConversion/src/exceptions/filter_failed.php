<?php
/**
 * File containing the ezcImageFilterFailedException.
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
class ezcImageFilterFailedException extends ezcImageException
{
    function __construct( $filterName, $reason = null )
    {
        $reasonPart = "";
        if ( $reason )
        {
            $reasonPart = " $reason";
        }
        parent::__construct( "The filter '{$filterName}' failed.{$reasonPart}" );
    }
}

?>
