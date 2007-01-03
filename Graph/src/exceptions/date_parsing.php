<?php
/**
 * File containing the ezcGraphErrorParsingDateException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a date assigned to the ezcGraphChartElementDateAxis
 * could not be parsed.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphErrorParsingDateException extends ezcGraphException
{
    public function __construct( $value )
    {
        $type = gettype( $value );
        parent::__construct( "Could not parse date '{$value}' of type '{$type}'." );
    }
}

?>

