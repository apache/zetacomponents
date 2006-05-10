<?php
/**
 * File containing the ezcTemplateDebug class
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
class ezcTemplateDebug
{
    public static function debug_dump( $var )
    {
        return print_r( $var, true );
    }
}


?>
