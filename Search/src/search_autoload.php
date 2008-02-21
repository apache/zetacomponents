<?php
/**
 * Autoloader definition for the Search component.
 *
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Search
 */

return array(
    'ezcSearchException'                            => 'Search/exceptions/exception.php',
    'ezcSearchCanNotConnectException'               => 'Search/exceptions/can_not_connect.php',
    'ezcSearchDefinitionInvalidException'           => 'Search/exceptions/definition_invalid.php',
    'ezcSearchDefinitionMissingIdPropertyException' => 'Search/exceptions/missing_id.php',
    'ezcSearchDefinitionNotFoundException'          => 'Search/exceptions/definition_not_found.php',
    'ezcSearchDefinitionManager'                    => 'Search/interfaces/definition_manager.php',
    'ezcSearchHandler'                              => 'Search/interfaces/handler.php',
    'ezcSearchIndexHandler'                         => 'Search/interfaces/index_handler.php',
    'ezcSearchQuery'                                => 'Search/abstraction/query.php',
    'ezcSearchCodeManager'                          => 'Search/managers/code_manager.php',
    'ezcSearchDefinitionDocumentField'              => 'Search/structs/document_field_definition.php',
    'ezcSearchDeleteHandler'                        => 'Search/handlers/delete_handler.php',
    'ezcSearchDocumentDefinition'                   => 'Search/structs/document_definition.php',
    'ezcSearchFindHandler'                          => 'Search/handlers/find_handler.php',
    'ezcSearchFindQuery'                            => 'Search/abstraction/query_find.php',
    'ezcSearchQueryInsert'                          => 'Search/abstraction/query_index.php',
    'ezcSearchResult'                               => 'Search/search_result.php',
    'ezcSearchSession'                              => 'Search/search_session.php',
    'ezcSearchSessionInstance'                      => 'Search/search_session_instance.php',
    'ezcSearchSolrHandler'                          => 'Search/handlers/solr.php',
    'ezcSearchXmlManager'                           => 'Search/managers/xml_manager.php',
);
?>
