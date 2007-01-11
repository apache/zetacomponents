<?php
/**
 * File containing the abstract ezcGraphDataSetStringProperty class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class for string properties of datasets
 *
 * @package Graph
 */
class ezcGraphDataSetStringProperty extends ezcGraphDataSetProperty
{
    /**
     * Converts value to an ezcGraphColor object
     * 
     * @param & $value 
     * @return void
     */
    protected function checkValue( &$value )
    {
        $value = (string) $value;
        return true;
    }
}

?>
