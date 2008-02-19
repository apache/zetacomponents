<?php
/**
 * File containing the ezcSearchDefinitionManager class
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Defines the interface for all persistent object definition managers.
 *
 * Definition managers are used to fetch the definition of a specific
 * persistent object. The definition is returned in form of a
 * ezcSearchDocumentDefinition structure.
 *
 * @version //autogen//
 * @package Search
 */
interface ezcPersistentDefinitionManager
{
    /**
     * Returns the definition of the document type $type.
     *
     * @throws ezcSearchDefinitionNotFoundException if no such definition can be found.
     * @param string $type
     * @return ezcSearchDocumentDefinition
     */
    public function fetchDefinition( $type );
}
?>
