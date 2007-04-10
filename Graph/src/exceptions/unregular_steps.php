<?php
/**
 * File containing the ezcGraphUnregularStepsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a bar chart shouls be rendered on an axis using 
 * unregular step sizes.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphUnregularStepsException extends ezcGraphException
{
    public function __construct()
    {
        parent::__construct( "Bar charts do not support axis with unregualr steps sizes." );
    }
}

?>
