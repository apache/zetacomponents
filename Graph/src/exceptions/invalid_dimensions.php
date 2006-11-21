<?php
/**
 * File containing the ezcGraphMatrixInvalidDimensionsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when an operation is not possible because of incompatible
 * matrix dimensions.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphMatrixInvalidDimensionsException extends ezcGraphException
{
    public function __construct( $rows, $columns, $dRows, $dColumns )
    {
        parent::__construct( "Matrix '{$dRows}, {$dColumns}' is incompatible with matrix '{$rows}, {$columns}' for requested operation." );
    }
}

?>
