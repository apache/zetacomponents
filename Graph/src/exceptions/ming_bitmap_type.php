<?php
/**
 * File containing the ezcGraphMingBitmapTypeException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Ming can only read non interlaced bitmaps. This exception is thrown for 
 * all other image types.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphMingBitmapTypeException extends ezcGraphException
{
    public function __construct( $type )
    {
        parent::__construct( "Ming can only read non interlaced JPEGs." );
    }
}

?>
