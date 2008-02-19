<?php
/**
 * File containing the ezcSearchFindQuery class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class to create select search backend indepentent search queries.
 *
 * @package Search
 * @version //autogentag//
 * @mainclass
 */
class ezcSearchFindQuery extends ezcSearchQuery
{
    /**
     * Sort the result ascending.
     */
    const ASC = 'ASC';

    /**
     * Sort the result descending.
     */
    const DESC = 'DESC';

    /**
     * Stores the SELECT part of the SQL.
     *
     * Everything from 'SELECT' until 'FROM' is stored.
     * @var string
     */
    protected $selectString = null;

    /**
     * Stores the FROM part of the SQL.
     *
     * Everything from 'FROM' until 'WHERE' is stored.
     * @var string
     */
    protected $fromString = null;

    /**
     * Stores the WHERE part of the SQL.
     *
     * Everything from 'WHERE' until 'GROUP', 'LIMIT', 'ORDER' or 'SORT' is stored.
     * @var string
     */
    protected $whereString = null;

    /**
     * Stores the FACET part of SQL
     *
     * @var string
     */
    protected $facetString = null;

    /**
     * Stores the ORDER BY part of the SQL.
     *
     * @var string
     */
    protected $orderString = null;

    /**
     * Stores the LIMIT part of the SQL.
     *
     * @var string
     */
    protected $limitString = null;

    /**
     * Stores the name of last invoked SQL clause method.
     *
     * Could be 'select', 'from', 'where', 'group', 'having', 'order', 'limit'
     * @var string
     */
    protected $lastInvokedMethod = null;

    /**
     * Constructs a new ezcSearchQuery object.
     *
     * @param ezcSearchHandler $handler a pointer to the search backend
     */
    public function __construct( ezcSearchHandler $handler )
    {
        parent::__construct( $handler );
    }

    /**
     * Resets the query object for reuse.
     *
     * @return void
     */
    public function reset()
    {
        $this->selectString = null;
        $this->fromString = null;
        $this->whereString = null;
        $this->facetString = null;
        $this->orderString = null;
        $this->limitString = null;
        $this->lastInvokedClauseMethod = null;
    }

    /**
     * Opens the query and selects which columns you want to return with
     * the query.
     *
     * select() accepts an arbitrary number of parameters. Each parameter
     * must contain either the name of a column or an array containing
     * the names of the columns.
     * Each call to select() appends columns to the list of columns that will be
     * used in the query.
     *
     * Example:
     * <code>
     * $q->select( 'column1', 'column2' );
     * </code>
     * The same could also be written
     * <code>
     * $columns[] = 'column1';
     * $columns[] = 'column2;
     * $q->select( $columns );
     * </code>
     * or using several calls
     * <code>
     * $q->select( 'column1' )->select( 'column2' );
     * </code>
     *
     * Each of above code produce SQL clause 'SELECT column1, column2' for the query.
     *
     * @throws ezcQueryVariableParameterException if called with no parameters..
     * @param string|array(string) $... Either a string with a column name or an array of column names.
     * @return ezcQuery returns a pointer to $this.
     */
    public function select()
    {
        if ( $this->selectString == null )
        {
            $this->selectString = 'SELECT ';
        }

        $args = func_get_args();
        $cols = self::arrayFlatten( $args );

        if ( count( $cols ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'select', count( $args ), 1 );
        }
        $this->lastInvokedMethod = 'select';
        $cols = $this->getIdentifiers( $cols );

        // glue string should be inserted each time but not before first entry
        if ( ( $this->selectString !== 'SELECT ' ) &&
             ( $this->selectString !== 'SELECT DISTINCT ' ) )
        {
            $this->selectString .= ', ';
        }

        $this->selectString .= join( ', ', $cols );
        return $this;
    }

    /**
     * Adds a where clause with logical expressions to the query.
     *
     * where() accepts an arbitrary number of parameters. Each parameter
     * must contain a logical expression or an array with logical expressions.
     * If you specify multiple logical expression they are connected using
     * a logical and.
     *
     * Multiple calls to where() will join the expressions using a logical and.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )->where( $q->expr->eq( 'id', 1 ) );
     * </code>
     *
     * @throws ezcQueryVariableParameterException if called with no parameters.
     * @param string|array(string) $... Either a string with a logical expression name
     * or an array with logical expressions.
     * @return ezcQuerySelect
     */
    public function where()
    {
        if ( $this->whereString == null )
        {
            $this->whereString = 'WHERE ';
        }

        $args = func_get_args();
        $expressions = self::arrayFlatten( $args );
        if ( count( $expressions ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'where', count( $args ), 1 );
        }

        $this->lastInvokedMethod = 'where';

        // glue string should be inserted each time but not before first entry
        if ( $this->whereString != 'WHERE ' )
        {
            $this->whereString .= ' AND ';
        }

        $this->whereString .= join( ' AND ', $expressions );
        return $this;
    }


    /**
     * Returns SQL that limits the result set.
     *
     * $limit controls the maximum number of rows that will be returned.
     * $offset controls which row that will be the first in the result
     * set from the total amount of matching rows.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )
     *                  ->limit( 10, 0 );
     * </code>
     *
     * LIMIT is not part of SQL92. It is implemented here anyway since all
     * databases support it one way or the other and because it is
     * essential.
     *
     * @param string $limit integer expression
     * @param string $offset integer expression
     * @return ezcQuerySelect
     */
    public function limit( $limit, $offset = '' )
    {
        if ( $offset === '' )
        {
            $this->limitString = "LIMIT {$limit}";
        }
        else
        {
            $this->limitString = "LIMIT {$limit} OFFSET {$offset}";
        }
        $this->lastInvokedMethod = 'limit';

        return $this;
    }

    /**
     * Returns SQL that orders the result set by a given column.
     *
     * You can call orderBy multiple times. Each call will add a
     * column to order by.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )
     *                  ->orderBy( 'id' );
     * </code>
     *
     * @param string $column a column name in the result set
     * @param string $type if the column should be sorted ascending or descending.
     *        you can specify this using ezcQuerySelect::ASC or ezcQuerySelect::DESC
     * @return ezcQuery a pointer to $this
     */
    public function orderBy( $column, $type = self::ASC )
    {
        $string = $this->getIdentifier( $column );
        if ( $type == self::DESC )
        {
            $string .= ' DESC';
        }
        if ( $this->orderString == '' )
        {
            $this->orderString = "ORDER BY {$string}";
        }
        else
        {
            $this->orderString .= ", {$string}";
        }
        $this->lastInvokedMethod = 'order';

        return $this;
    }

    /**
     * Returns the complete select query string.
     *
     * This method uses the build methods to build the
     * various parts of the select query.
     *
     * @todo add newlines? easier for debugging
     * @throws ezcQueryInvalidException if it was not possible to build a valid query.
     * @return string
     */
    public function getQuery()
    {
    }
}

?>
