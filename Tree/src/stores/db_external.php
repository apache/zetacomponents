<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXml is an implementation of a tree backend that operates on
 * an XML file.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeDbExternalTableDataStore extends ezcTreeDbDataStore
{
    /**
     * Contains the database connection handler
     *
     * @var ezcDbHandler
     */
    private $dbHandler;

    /**
     * Contains the name of the table to fetch data from
     *
     * @var string
     */
    private $table = null;

    /**
     * Contains the name of the field that contains the node ID
     *
     * @var string
     */
    private $idField = null;

    /**
     * Contains the name of the field to fetch data from.
     *
     * If this field is null, then the whole row is returned.
     *
     * @var string
     */
    private $dataField = null;

    /**
     * Constructs a new storage backend that stores data in a table external
     * from the node tree.
     *
     * The store will use the database connection specified by $dbHandler, and
     * the table $dataTable to store the data in. The lookup field that is matched
     * against the node ID is specified with $idField. By default the store will
     * return the whole row unless a specific field has been configured through
     * the $dataField argument in this constructor.
     *
     * @param ezcDbHandler $dbHandler
     * @param string $dataTable
     * @param string $idField
     * @param string $dataField
     */
    public function __construct( ezcDbHandler $dbHandler, $dataTable, $idField, $dataField = null )
    {
        $this->dbHandler = $dbHandler;
        $this->table = $dataTable;
        $this->idField = $idField;
        $this->dataField = $dataField;
    }

    /**
     * Takes the data from the executed query in $s and uses the $dataField 
     * property to filter out the wanted data for this node.
     *
     * @param PDOStatement $s
     * @return mixed
     */
    private function filterDataFromResult( PDOStatement $s )
    {
        $data = $s->fetch();
        if ( $this->dataField === null )
        {
            return $data;
        }
        return $data[$this->dataField];
    }

    /**
     * Retrieves the data for the node $node from the data store and assigns it
     * to the node's 'data' property.
     *
     * @param ezcTreeNode $node
     */
    public function fetchDataForNode( ezcTreeNode $node )
    {
        $db = $this->dbHandler;
        $q = $db->createSelectQuery();

        $id = $node->id;
        $q->select( '*' )
          ->from( $db->quoteIdentifier( $this->table ) )
          ->where( $q->expr->eq( $db->quoteIdentifier( $this->idField ), $id ) );
        $s = $q->prepare();
        $s->execute();

        $node->data = $this->filterDataFromResult( $s );
    }

    /**
     * Retrieves the data for all the nodes in the node list $nodeList and
     * assigns this data to the nodes' 'data' properties.
     *
     * @param ezcTreeNodeList $nodeList
     */
    public function fetchDataForNodes( ezcTreeNodeList $nodeList )
    {
    }

    /**
     * Stores the data in the node to the data store.
     *
     * @param ezcTreeNode $node
     */
    public function storeDataForNode( ezcTreeNode $node )
    {
    }
}
?>
