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
    'ezcSearchException'              => 'Search/exceptions/exception.php',
    'ezcSearchCanNotConnectException' => 'Search/exceptions/can_not_connect.php',
    'ezcSearchHandler'                => 'Search/interfaces/handler.php',
    'ezcSearchIndexHandler'           => 'Search/interfaces/index_handler.php',
    'ezcSearchQuery'                  => 'Search/abstraction/query.php',
    'ezcSearchCodeManager'            => 'Search/managers/code_manager.php',
    'ezcSearchFindQuery'              => 'Search/abstraction/query_find.php',
    'ezcSearchQueryInsert'            => 'Search/abstraction/query_index.php',
    'ezcSearchResult'                 => 'Search/search_result.php',
    'ezcSearchSession'                => 'Search/search_session.php',
    'ezcSearchSessionInstance'        => 'Search/search_session_instance.php',
    'ezcSearchSolrHandler'            => 'Search/handlers/solr.php',
);
?>
