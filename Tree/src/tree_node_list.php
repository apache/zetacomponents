<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeNodeList represents a lists of nodes.
 *
 * The nodes in the list can be accessed through an array as this class
 * implements the ArrayAccess SPL interface. The array is indexed based on the
 * the node's ID.
 *
 * @property-read string $size The number of nodes in the list.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeNodeList implements ArrayAccess
{
    /**
     * Holds the nodes of this list.
     *
     * @var array(ezcTreeNode)
     */
    private $nodes;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    //private $properties = array();

    /**
     * Constructs a new ezcTreeNode object
     */
    public function __construct()
    {
        $this->nodes = array();
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'size':
                return count( $this->nodes );

        }
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @throws ezcBasePropertyPermissionException if a read-only property is
     *         tried to be modified.
     * @param string $name
     * @param mixed $value
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'size':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns whether a node with the ID $id exists in the list
     *
     * This method is part of the SPL ArrayAccess interface.
     *
     * @param  string $id
     * @return bool
     * @ignore
     */
    public function offsetExists( $id )
    {
        return array_key_exists( $id, $this->nodes );
    }

    /**
     * Returns the node with the ID $id
     *
     * This method is part of the SPL ArrayAccess interface.
     *
     * @param  string $id
     * @return ezcTreeNode
     * @ignore
     */
    public function offsetGet( $id )
    {
        return $this->nodes[$id];
    }

    /**
     * Adds a new node with node ID $id to the list.
     *
     * This method is part of the SPL ArrayAccess interface.
     * 
     * @throws ezcTreeInvalidClassException if the data to be set as array
     *         element is not an instance of ezcTreeNode
     * @throws ezcTreeIdsDoNotMatchException if the array index $id does not
     *         match the tree node's ID that is stored in the $data object
     * @param  string      $id
     * @param  ezcTreeNode $data
     * @ignore
     */
    public function offsetSet( $id, $data )
    {
        if ( !$data instanceof ezcTreeNode )
        {
            throw new ezcTreeInvalidClassException( 'ezcTreeNode', get_class( $data ) );
        }
        if ( $data->id !== $id )
        {
            throw new ezcTreeIdsDoNotMatchException( $data->id, $id );
        }
        $this->addNode( $data );
    }

    /**
     * Removes the node with ID $id from the list.
     *
     * This method is part of the SPL ArrayAccess interface.
     *
     * @param string $id
     * @ignore
     */
    public function offsetUnset( $id )
    {
        unset( $this->nodes[$id] );
    }


    /**
     * Adds the node $node to the list
     *
     * @param ezcTreeNode $node
     */
    public function addNode( ezcTreeNode $node )
    {
        $this->nodes[$node->id] = $node;
    }

    /**
     * Returns all nodes in the list
     *
     * @return array(string=>ezcTreeNode)
     */
    public function getNodes()
    {
        return $this->nodes;
    }
}
?>
