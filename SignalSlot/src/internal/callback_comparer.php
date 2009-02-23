<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @access private
 */

/**
 * Check if two callbacks are the same or not.
 *
 * @version //autogen//
 * @mainclass
 * @package SignalSlot
 * @access private
 */
class ezcSignalCallbackComparer
{
    /**
     * Returns true if the callbacks $a and $b are the same.
     *
     * @param callback $a
     * @param callback $b
     * @return bool
     */
    public static function compareCallbacks( $a, $b )
    {
        if ( is_string( $a ) || is_string( $b ) )
        {
            return $a === $b;
        }
        return ( count( array_udiff( $a, $b, array( 'ezcSignalCallbackComparer', 'comp_func') ) ) == 0 );
    }

    /**
     * Checks if $a and $b are of the exact same.
     *
     * Note: This method does not support arrays as you may not have array's in callbacks.
     *
     * @param mixed $a
     * @param mixed $b
     * @return int 0 if same 1 or -1 if not.
     */
    public static function comp_func( $a, $b )
    {
        if ( $a === $b )
        {
            return 0;
        }
        return 1;
    }
}
?>
