<?php
/**
 * File containing the ezcGraphInvalidRendererException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcGraphUnknownChartTypeException is the exception which is thrown when the
 * factory method tries to return an instance of an unknown chart type
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphInvalidRendererException extends ezcBaseException
{
    public function __construct( $renderer )
    {
        parent::__construct( 'Unknown renderer <' . $renderer . '>.' );
    }
}

?>
