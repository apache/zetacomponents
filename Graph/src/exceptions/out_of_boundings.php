<?php
/**
 * File containing the ezcGraphMatrixOutOfBoundingsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a rrequested matrix value is out of the boundings of 
 * the matrix.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphMatrixOutOfBoundingsException extends ezcGraphException
{
    public function __construct( $rows, $columns, $rPos, $cPos )
    {
        parent::__construct( "Position <{$rPos}, {$cPos}> is out of the matrix boundings <{$rows}, {$columns}>." );
    }
}

?>
