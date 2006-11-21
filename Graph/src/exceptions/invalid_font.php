<?php
/**
 * File containing the ezcGraphInvalidFontTypeException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if font type cannot be rendered with one driver.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphInvalidFontTypeException extends ezcGraphException
{
    public function __construct( $type, $driver )
    {
        $fontNames = array(
            ezcGraph::TTF_FONT => 'True Type Font',
            ezcGraph::PS_FONT => 'Postscript Type 1 font',
            ezcGraph::PALM_FONT => 'Palm Font',
        );

        $fontName = ( isset( $fontNames[$type] )
            ? $fontName = $fontNames[$type]
            : 'Unknown'
        );

        parent::__construct( "Font type '{$fontName}' cannot be used with '{$driver}'." );
    }
}

?>
