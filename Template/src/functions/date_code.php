<?php
/**
 * File containing the ezcTemplateDate class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDate
{
    public static function date( $format, $timestamp = null )
    {
        if ( $timestamp instanceof DateTime )
        {
            return $timestamp->format( $format );
        }
        else
        {
            if ( $timestamp === null ) 
            {
                return date( $format );
            }
            else
            {
                return date( $format, $timestamp );
            }
        }
    }
}

?>
