<?php
/**
 * File containing the ezcSearchFindQuery class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class to create select search backend indepentent search queries.
 *
 * @package Search
 * @version //autogentag//
 * @mainclass
 */
interface ezcSearchQuery
{
    /**
     * Creates a new search query with handler $handler and document definition $definition.
     *
     * @param ezcSearchHandler $handler
     * @param ezcSearchDocumentDefinition $definition
     */
    public function __construct( ezcSearchHandler $handler, ezcSearchDocumentDefinition $definition );

    /**
     * Resets the query object for reuse.
     *
     * @return void
     */
    public function reset();

    /**
     * Adds a select/filter statement to the query
     *
     * @param string $clause
     * @return ezcSearchQuery
     */
    public function where( $clause );

    /**
     * Registers from which offset to start returning results, and how many results to return.
     *
     * $limit controls the maximum number of rows that will be returned.
     * $offset controls which row that will be the first in the result
     * set from the total amount of matching rows.
     *
     * @param int $limit
     * @param int $offset
     * @return ezcSearchQuery
     */
    public function limit( $limit, $offset = 0 );

    /**
     * Tells the query on which field to sort on, and in which order
     *
     * You can call orderBy multiple times. Each call will add a
     * column to order by.
     *
     * @param string $column
     * @param int    $type
     * @return ezcSearchQuery
     */
    public function orderBy( $column, $type = ezcSearchQueryTools::ASC );

    /**
     * Returns the query as a string for debugging purposes
     *
     * @return string
     * @ignore
     */
    public function getQuery();

    /**
     * Adds one facet to the query.
     *
     * @param string $facet
     * @return ezcSearchQuery
     */
    public function facet( $facet );

    /**
     * Expressions start here
     */

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the $value
     * correctly. If a definition is set, the $fieldType will be overridden
     * with the type from the definition.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function eq( $field, $value );

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the values
     * correctly.
     *
     * @param string $field
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return string
     */
    public function between( $field, $value1, $value2 );

    /**
     * Creates an OR clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed $...
     * @return string
     */
    public function lOr();

    /**
     * Creates an AND clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed $...
     * @return string
     */
    public function lAnd();

    /**
     * Creates a NOT clause
     *
     * This method accepts a clause and negates it.
     *
     * @param string $clause
     * @return string
     */
    public function not( $clause );

    /**
     * Creates an 'important' clause
     *
     * This method accepts a clause and marks it as important.
     *
     * @param string $clause
     * @return string
     */
    public function important( $clause );

    /**
     * Modifies a clause to give it higher weight while searching.
     *
     * This method accepts a clause and adds a boost factor.
     *
     * @param string $clause
     * @param float $boostFactor
     * @return string
     */
    public function boost( $clause, $boostFactor );

    /**
     * Modifies a clause make it fuzzy.
     *
     * This method accepts a clause and registers it as a fuzzy search, an
     * optional fuzz factor is also supported.
     *
     * @param string $clause
     * @param float $fuzzFactor
     * @return string
     */
    public function fuzz( $clause, $fuzzFactor = null );
}

?>
