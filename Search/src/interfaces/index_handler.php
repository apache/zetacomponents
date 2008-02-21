<?php
/**
 * File containing the ezcSearchIndexHandler interface.
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
interface ezcSearchIndexHandler
{
    public function index( ezcSearchDocumentDefinition $definition, $document );
    public function createDeleteQuery();
    public function delete( ezcSearchDeleteQuery $query );
}
?>
