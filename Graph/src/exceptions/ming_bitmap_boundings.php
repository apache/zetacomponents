<?php
/**
 * File containing the ezcGraphMingBitmapBoundingsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Ming does not support bitmap scaling, so that this exceptions is thrown 
 * when an image does not have the requested size.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphMingBitmapBoundingsException extends ezcGraphException
{
    public function __construct( $imageWidth, $imageHeight, $reqWidth, $reqHeight )
    {
        parent::__construct( "Ming does not support bitmap scaling, so that it is up to you to scale the image '$imageWidth' * '$imageHeight' to '$reqWidth' * '$reqHeight'." );
    }
}

?>
