<?php
/**
 * File containing the ezcTemplateType class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateType
{
    /**
     * This method couldn't be translated directly because the parameter
     * of empty should always be a variable. 
     *
     * This wrapper function makes it possible to call: is_empty("");
     */
    public static function is_empty( $var )
    {
        return empty( $var );
    }

    public static function is_instance( $var, $class )
    {
        return ($var instanceof $class);
    }

}


?>
