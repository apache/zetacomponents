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
interface ezcSearchFindQuery extends ezcSearchQuery
{
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
    public function select();
}

?>
