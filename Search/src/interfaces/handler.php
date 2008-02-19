<?php
/**
 * File containing the ezcSearchHandler interface.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Defines interface for all the search backend implementations.
 *
 * @version //autogentag//
 * @package Search
 */
interface ezcSearchHandler
{
    public function createFindQuery( $type = false );
    public function find( ezcSearchFindQuery $query );
}
?>
