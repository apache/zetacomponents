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
    'ezcSearchTransactionException'                 => 'Search/exceptions/transaction.php',
    'ezcSearchQuery'                                => 'Search/abstraction/query.php',
    'ezcSearchDefinitionManager'                    => 'Search/interfaces/definition_manager.php',
    'ezcSearchFindQuery'                            => 'Search/abstraction/query_find.php',
    'ezcSearchHandler'                              => 'Search/interfaces/handler.php',
    'ezcSearchIndexHandler'                         => 'Search/interfaces/index_handler.php',
    'ezcSearchCodeManager'                          => 'Search/managers/code_manager.php',
    'ezcSearchDefinitionDocumentField'              => 'Search/structs/document_field_definition.php',
    'ezcSearchDeleteHandler'                        => 'Search/handlers/delete_handler.php',
    'ezcSearchDeleteQuery'                          => 'Search/abstraction/query_delete.php',
    'ezcSearchDocumentDefinition'                   => 'Search/structs/document_definition.php',
    'ezcSearchEmbeddedManager'                      => 'Search/managers/embedded_manager.php',
    'ezcSearchFindHandler'                          => 'Search/handlers/find_handler.php',
    'ezcSearchFindQuerySolr'                        => 'Search/abstraction/implementations/find_solr.php',
    'ezcSearchQueryInsert'                          => 'Search/abstraction/query_index.php',
    'ezcSearchQueryTools'                           => 'Search/abstraction/query_tools.php',
    'ezcSearchResult'                               => 'Search/search_result.php',
    'ezcSearchRstXmlExtractor'                      => 'Search/extractors/rstxml.php',
    'ezcSearchSession'                              => 'Search/search_session.php',
    'ezcSearchSessionInstance'                      => 'Search/search_session_instance.php',
    'ezcSearchSimpleArticle'                        => 'Search/extractors/helpers/simple.php',
    'ezcSearchSolrHandler'                          => 'Search/handlers/solr.php',
    'ezcSearchXmlManager'                           => 'Search/managers/xml_manager.php',
);
?>
