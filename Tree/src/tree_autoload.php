<?php
/**
 * Autoloader definition for the Tree component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

return array(
    'ezcTreeException'                => 'Tree/exceptions/exception.php',
    'ezcTreeInvalidIdException'       => 'Tree/exceptions/invalid_id.php',
    'ezcTree'                         => 'Tree/tree.php',
    'ezcTreeBackend'                  => 'Tree/interfaces/backend.php',
    'ezcTreeDataStore'                => 'Tree/interfaces/data_store.php',
    'ezcTreeDb'                       => 'Tree/backends/db.php',
    'ezcTreeDbDataStore'              => 'Tree/stores/db.php',
    'ezcTreeXmlDataStore'             => 'Tree/stores/xml.php',
    'ezcTreeDbExternalTableDataStore' => 'Tree/stores/db_external.php',
    'ezcTreeDbParentChild'            => 'Tree/backends/db_parent_child.php',
    'ezcTreeNode'                     => 'Tree/tree_node.php',
    'ezcTreeNodeList'                 => 'Tree/tree_node_list.php',
    'ezcTreeNodeListIterator'         => 'Tree/tree_node_list_iterator.php',
    'ezcTreeTransactionItem'          => 'Tree/structs/transaction_item.php',
    'ezcTreeXml'                      => 'Tree/backends/xml.php',
    'ezcTreeXmlInternalDataStore'     => 'Tree/stores/xml_internal.php',
);
?>
