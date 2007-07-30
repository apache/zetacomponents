<?php
abstract class ezcTree
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array( 'prefetch' => false, 'nodeClassName' => 'ezcTreeNode' );

    protected $inTransaction = false;
    protected $inTransactionCommit = false;
    private $transactionList = array();

    protected function __construct()
    {
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'store':
            case 'nodeClassName':
            case 'prefetch':
                return $this->properties[$name];
        }
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @throws ezcBasePropertyPermissionException if a read-only property is
     *         tried to be modified.
     * @throws ezcBaseValueException if a the value for a property is out of
     *         range.
     * @throws ezcBaseInvalidParentClassException
     *         if the class name passed as replacement for the ezcTreeNode
     *         classs does not inherit from the ezcTreeNode class.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'store':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );

            case 'nodeClassName':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string that contains a class name' );
                }

                // Check if the passed classname actually implements the
                // correct parent class. We have to do that with reflection
                // here unfortunately
                $parentClass = new ReflectionClass( 'ezcTreeNode' );
                $handlerClass = new ReflectionClass( $value );
                if ( 'ezcTreeNode' !== $value && !$handlerClass->isSubclassOf( $parentClass ) )
                {
                    throw new ezcBaseInvalidParentClassException( 'ezcTreeNode', $value );
                }
                $this->properties[$name] = $value;
                break;

            case 'prefetch':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'boolean' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Creates a new tree node with node ID $id and $data
     *
     * This method returns by default an object of the ezcTreeNode class, 
     * however if a replacement is configured through the nodeClassName property
     * an object of that class is returned instead. This object is guaranteed
     * to inherit from ezcTreeNode.
     *
     * @param string $id
     * @param mixed  $data
     * @return instanceof(ezcTreeNode)
     */
    public function createNode( $id, $data )
    {
        $className = $this->properties['nodeClassName'];
        return new $className( $this, $id, $data );
    }

    /**
     * Returns the node identified by the ID $id
     *
     * @param string $id
     * @throws ezcTreeInvalidIdException if there is no node with ID $id
     * @return ezcTreeNode
     */
    public function fetchNodeById( $id )
    {
        if ( !$this->nodeExists( $id ) )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        $className = $this->properties['nodeClassName'];
        $node = new $className( $this, $id );

        // Obtain data from the store if prefetch is enabled
        if ( $this->prefetch )
        {
            $this->properties['store']->fetchDataForNode( $node );
        }
        return $node;
    }

    /**
     * Starts an transaction in which all tree modifications are queued until 
     * the transaction is committed with the commit() method.
     */
    public function beginTransaction()
    {
        if ( $this->inTransaction )
        {
            throw new ezcTreeTransactionAlreadyStartedException;
        }
        $this->inTransaction = true;
        $this->transactionList = array();
    }

    /**
     * Commits the transaction by running the stored instructions to modify
     * the tree structure.
     */
    public function commit()
    {
        $this->inTransaction = false;
        $this->inTransactionCommit = true;
        foreach ( $this->transactionList as $transactionItem )
        {
            switch ( $transactionItem->type )
            {
                case ezcTreeTransactionItem::ADD:
                    $this->addChild( $transactionItem->parentId, $transactionItem->node );
                    break;

                case ezcTreeTransactionItem::DELETE:
                    $this->delete( $transactionItem->nodeId );
                    break;

                case ezcTreeTransactionItem::MOVE:
                    $this->move( $transactionItem->nodeId, $transactionItem->parentId );
                    break;
            }
        }
        $this->inTransactionCommit = false;
        $this->fixateTransaction();
    }

    /**
     * Adds a new transaction item to the list
     *
     * @param ezcTreeTransactionItem $item
     */
    public function addTransactionItem( ezcTreeTransactionItem $item )
    {
        if ( !$this->inTransaction )
        {
            throw new ezcTreeTransactionNotStartedException;
        }
        $this->transactionList[] = $item;
    }

    /**
     * Rolls back the transaction by clearing all stored instructions.
     */
    public function rollback()
    {
        $this->inTransaction = false;
        $this->transactionList = array();
    }
}
?>
