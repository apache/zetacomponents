<?php
/**
 * File containing the ezcGraphDatabaseDataSet class
 *
 * @package GraphDatabaseTiein
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to transform PDO results into ezcGraphDataSets
 *
 * @package GraphDatabaseTiein
 * @version //autogentag//
 * @mainclass
 */
class ezcGraphDatabaseDataSet extends ezcGraphDataSet
{
    /**
     * Constructor
     * 
     * Creates a ezcGraphDatabase from a PDOStatement and uses the columns 
     * defined in the definition array as keys and values for the data set. 
     *
     * If the definition array is empty a single column will be used as values,
     * with two columns the first column will be used for the keys and the 
     * second for the data set values.
     *
     * You may define the name of the rows used for keys and values by using 
     * an array like:
     *  array (
     *      ezcGraph::KEY => 'row name',
     *      ezcGraph::VALUE => 'row name',
     *  );
     *
     * @param PDOStatement $statement
     * @param array $definition
     * @return ezcGraphDatabase
     */
    public function __construct( PDOStatement $statement, array $definition = null )
    {
        parent::__construct();

        $this->data = array();
        $this->createFromPdo( $statement, $definition );
    }

    /**
     * Create dataset from PDO statement
     *
     * This methods uses the values from a PDOStatement to fill up the data 
     * sets data.
     *
     * If the definition array is empty a single column will be used as values,
     * with two columns the first column will be used for the keys and the 
     * second for the data set values.
     *
     * You may define the name of the rows used for keys and values by using 
     * an array like:
     *  array (
     *      ezcGraph::KEY => 'row name',
     *      ezcGraph::VALUE => 'row name',
     *  );
     * 
     * @param PDOStatement $statement
     * @param array $definition
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
                        throw new ezcGraphDatabaseTooManyColumnsException( $row );
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
                    throw new ezcGraphDatabaseMissingColumnException( $definition[ezcGraph::VALUE] );
                }

                $value = $row[$definition[ezcGraph::VALUE]];

                if ( array_key_exists( ezcGraph::KEY, $definition ) )
                {
                    if ( !array_key_exists( $definition[ezcGraph::KEY], $row ) )
                    {
                        throw new ezcGraphDatabaseMissingColumnException( $definition[ezcGraph::KEY] );
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
            throw new ezcGraphDatabaseStatementNotExecutedException( $statement );
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
