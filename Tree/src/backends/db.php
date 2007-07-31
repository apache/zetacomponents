<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeDb contains common methods for the different database tree backends.
 *
 * @property-read ezcTreeXmlDataStore $store
 *                The data store that is used for retrieving/storing data.
 * @property      bool                $prefetch
 *                Whether data pre-fetching is enabled.
 * @property      string              $nodeClassName
 *                Which class is used as tree node - this class *must* inherit
 *                the ezcTreeNode class.
 *
 * @package Tree
 * @version //autogentag//
 */
abstract class ezcTreeDb extends ezcTree
{
    /**
     * Contains the database connection handler
     *
     * @var ezcDbHandler
     */
    protected $dbh;

    /**
     * Contains the name of the table to retrieve the relational data from.
     *
     * @var string
     */
    protected $indexTableName;

    /**
     * Constructs a new ezcTreeDb object
     *
     * The different arguments to the constructor configure which database
     * connection ($dbh) is used to access the database and the $indexTableName
     * argument which table is used to retrieve the relation data from. The
     * $store argument configure which data store is used with this tree.
     *
     * All database backends require the index table to atleast define the
     * field 'id', which can either be a string or an integer field.
     * 
     * @param ezcDbHandler       $dbh
     * @param string             $indexTableName
     * @param ezcTreeDbDataStore $store
     */
    public function __construct( ezcDbHandler $dbh, $indexTableName, ezcTreeDbDataStore $store )
    {
        $this->dbh = $dbh;
        $this->indexTableName = $indexTableName;
        $this->properties['store'] = $store;
    }

    /**
     * Returns whether the node with ID $id exists as tree node
     *
     * @param string $id
     * @return bool
     */
    public function nodeExists( $id )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        $q->select( 'id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );

        $s = $q->prepare();
        $s->execute();

        return count( $s->fetchAll() ) ? true : false;
    }
}
?>
