<?php
/**
 * File containing the ezcSearchQuery class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcSearchQuery class provides the common API for all Query objects.
 *
 * Subclasses should provide functionality to build an actual query.
 *
 * @package Search
 * @version //autogentag//
 * @private
 */
class ezcSearchQueryTools
{
    /**
     * Returns all the elements in $array as one large single dimensional array.
     *
     * @param array $array
     * @return array
     */
    static public function arrayFlatten( array $array )
    {
        $flat = array();
        foreach ( $array as $arg )
        {
            switch ( gettype( $arg ) )
            {
                case 'array':
                    $flat = array_merge( $flat, $arg );
                    break;

                default:
                    $flat[] = $arg;
                    break;
            }
        }
        return $flat;
    }
}
?>
