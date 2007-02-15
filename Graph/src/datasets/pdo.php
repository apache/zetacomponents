<?php
/**
 * File containing the ezcGraphPdoDataSet class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to transform PDO results into ezcGraphDataSets
 *
 * @package Graph
 * @mainclass
 */
class ezcGraphPdoDataSet extends ezcGraphDataSet
{
    /**
     * Constructor
     * 
     * @param PDOStatement $statement
     * @return ezcGraphPdoDataSet
     */
    public function __construct( PDOStatement $statement, array $definition = null )
    {
        parent::__construct();

        $this->data = array();
        $this->createFromPdo( $statement, $definition );
    }

    /**
     * setData
     *
     * Can handle data provided through an array or iterator.
     * 
     * @param array|Iterator $data 
     * @access public
     * @return void
     */
    protected function createFromPdo( PDOStatement $statement, array $definition = null ) 
    {
        $count = 0;

        if ( $definition === null )
        {
            while ( $row = $statement->fetch( PDO::FETCH_NUM ) )
            {
                ++$count;

                switch ( count( $row ) )
                {
                    case 1:
                        $this->data[] = $row[0];
                        break;
                    case 2:
                        $this->data[$row[0]] = $row[1];
                        break;
                    default:
                        throw new ezcGraphPdoDataSetTooManyColumnsException( $row );
                }
            }
        }
        else
        {
            while ( $row = $statement->fetch( PDO::FETCH_NAMED ) )
            {
                ++$count;

                if ( !array_key_exists( $definition[ezcGraph::VALUE], $row ) )
                {
                    throw new ezcGraphPdoDataSetMissingColumnException( $definition[ezcGraph::VALUE] );
                }

                $value = $row[$definition[ezcGraph::VALUE]];

                if ( array_key_exists( ezcGraph::KEY, $definition ) )
                {
                    if ( !array_key_exists( $definition[ezcGraph::KEY], $row ) )
                    {
                        throw new ezcGraphPdoDataSetMissingColumnException( $definition[ezcGraph::KEY] );
                    }

                    $this->data[$row[$definition[ezcGraph::KEY]]] = $value;
                }
                else
                {
                    $this->data[] = $value;
                }
            }
        }

        // Empty result set
        if ( $count <= 0 )
        {
            throw new ezcGraphPdoDataSetStatementNotExecutedException( $statement );
        }
    }

    /**
     * Returns the number of elements in this dataset
     * 
     * @return int
     */
    public function count()
    {
        return count( $this->data );
    }
}

?>
