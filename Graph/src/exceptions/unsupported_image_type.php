<?php
/**
 * File containing the ezcGraphGdDriverUnsupportedImageTypeException class
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
class ezcGraphGdDriverUnsupportedImageTypeException extends ezcBaseException
{
    public function __construct( $type )
    {
        $typeName = array(
            1 => 'GIF',
            2 => 'Jpeg',
            3 => 'PNG',
            4 => 'SWF',
            5 => 'PSD',
            6 => 'BMP',
            7 => 'TIFF (intel)',
            8 => 'TIFF (motorola)',
            9 => 'JPC',
            10 => 'JP2',
            11 => 'JPX',
            12 => 'JB2',
            13 => 'SWC',
            14 => 'IFF',
            15 => 'WBMP',
            16 => 'XBM',

        );

        if ( isset( $typeName[$type] ) )
        {
            $type = $typeName[$type];
        }
        else
        {
            $type = 'Unknown';
        }

        parent::__construct( "Unsupported image format <{$type}>." );
    }
}

?>
