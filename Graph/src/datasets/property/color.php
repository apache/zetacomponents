<?php
/**
 * File containing the abstract ezcGraphDatasetColorProperty class
 *
 * @package Graph
 * @version $id$
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class for color properties of datasets
 *
 * @package Graph
 */
class ezcGraphDatasetColorProperty extends ezcGraphDatasetProperty
{
    /**
     * Converts value to an ezcGraphColor object
     * 
     * @param & $value 
     * @return void
     */
    protected function checkValue( &$value )
    {
        $value = ezcGraphColor::create( $value );
        return true;
    }
}

?>
