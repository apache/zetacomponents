<?php
/**
 * File containing the ezcGraphInvalidImageFileException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a file can not be used as a image file.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphInvalidImageFileException extends ezcGraphException
{
    public function __construct( $image )
    {
        parent::__construct( "File '{$image}' is not a valid image." );
    }
}

?>
