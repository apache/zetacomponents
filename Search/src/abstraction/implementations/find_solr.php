<?php
/**
 * File containing the ezcSearchFindQuerySolr class.
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcSearchFindQuerySolr implements the find query for searching documents.
 *
 * @package Search
 * @version //autogen//
 */
class ezcSearchFindQuerySolr implements ezcSearchFindQuery
{
    /**
     * Holds the columns to return in the search result
     *
     * @var array
     */
    public $resultFields;

    /**
     * Holds the columns to highlight in the search result
     *
     * @var array(string)
     */
    public $highlightFields;

    /**
     * Holds all the search clauses that will be used to create the search query.
     *
     * @var array(string)
     */
    public $whereClauses;

    /**
     * Holds the maximum number of results for the query.
     *
     * @var int
     */
    public $limit;

    /**
     * Holds the number of the first element to return in the results.
     *
     * This is used in combination with the $limit option.
     *
     * @var int
     */
    public $offset;

    /**
     * Holds all the facets
     *
     * @var array(string)
     */
    public $facets;

    /**
     * Holds the search handler for which this query is built.
     *
     * @var ezcSearchHandler
     */
    public $handler;

    /**
     * Contains the document definition for which this query is built.
     *
     * @param ezcSearchDocumentDefinition
     */
    public $definition;

    /**
     * Constructs a new ezcSearchFindQuerySolr object for the handler $handler
     *
     * The handler implements mapping field names and values based on the
     * document $definition.
     *
     * @param ezcSearchHandler $handler
     * @param ezcSearchDocumentDefinition $definition
     */
    public function __construct( ezcSearchHandler $handler, ezcSearchDocumentDefinition $definition )
    {
        $this->handler = $handler;
        $this->definition = $definition;
        $this->reset();
    }

    /**
     * Resets all the internal query values to their defaults.
     */
    public function reset()
    {
        $this->resultFields = array();
        $this->highlightFields = array();
        $this->whereClauses = array();
        $this->limit = 0;
        $this->offset = 0;
        $this->facets = array();
    }

    /**
     * Adds the fields to return in the results.
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names. The following is therefore
     * equivalent:
     * <code>
     * $q->select( array( 'one', 'two', 'three' ) );
     * $q->select( 'one', 'two', 'three' ) );
     * </code>
     *
     * If fields already have been added with this function, they will not be
     * overwritten when this function is called subsequently.
     *
     * @param mixed
     * @return ezcSearchFindQuerySolr
     */
    public function select()
    {
        $args = func_get_args();
        $cols = ezcSearchQueryTools::arrayFlatten( $args );
        $this->resultFields = array_merge( $this->resultFields, $cols );
        return $this;
    }

    /**
     * Adds the fields to highlight in the results.
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names. The following is therefore
     * equivalent:
     * <code>
     * $q->highlight( array( 'one', 'two', 'three' ) );
     * $q->highlight( 'one', 'two', 'three' ) );
     * </code>
     *
     * If fields already have been added with this function, they will not be
     * overwritten when this function is called subsequently.
     *
     * @param mixed
     * @return ezcSearchFindQuerySolr
     */
    public function highlight()
    {
        $args = func_get_args();
        $cols = ezcSearchQueryTools::arrayFlatten( $args );
        $this->highlightFields = array_merge( $this->highlightFields, $cols );
        return $this;
    }

    /**
     * Adds a select/filter statement to the query
     *
     * @param string $clause
     * @return ezcSearchFindQuerySolr
     */
    public function where( $clause )
    {
        $this->whereClauses[] = $clause;
        return $this;
    }

    /**
     * Registers from which offset to start returning results, and how many results to return.
     *
     * @param int $limit
     * @param int $offset
     * @return ezcSearchFindQuerySolr
     */
    public function limit( $limit, $offset = 0 )
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /**
     * Tells the query on which field to sort on, and in which order
     *
     * @param string $column
     * @param int    $type
     * @return ezcSearchFindQuerySolr
     */
    public function orderBy( $column, $type = ezcSearchQueryTools::ASC )
    {
        return $this;
    }

    /**
     * Returns the query as a string for debugging purposes
     *
     * @param ezcSearchFindQuerySolr $query
     * @return string
     * @ignore
     */
    public function getQuery()
    {
        return $this->handler->getQuery( $this );
    }

    /**
     * Adds one facet to the query.
     *
     * @param string $facet
     * @return ezcSearchFindQuerySolr
     */
    public function facet( $facet )
    {
        $field = $this->handler->mapFieldType( $facet, $this->definition->fields[$facet]->type );
        $this->facets[] = $field;
        return $this;
    }

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the $value
     * correctly.
     *
     * @param string $field
     * @param mixed $value
     * @param int $fieldType
     *
     * @return string
     */
    public function eq( $field, $value, $fieldType = ezcSearchDocumentDefinition::STRING )
    {
        $field = trim( $field );

        $value = $this->handler->mapFieldValueForSearch( $fieldType, $value );

        if ( $this->definition && isset( $this->definition->fields[$field] ) )
        {
            $field = $this->handler->mapFieldType( $field, $this->definition->fields[$field]->type );
        }

        $ret = "$field:$value";

        if ( $this->definition && isset( $this->definition->fields[$field] ) && $this->definition->fields[$field]->boost != 1 )
        {
            $ret .= "^{$this->definition->fields[$field]->boost}";
        }
        return $ret;
    }

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the values
     * correctly.
     *
     * @param string $field
     * @param mixed $value
     * @param int $fieldType
     *
     * @return string
     */
    public function between( $field, $value1, $value2 )
    {
        $field = trim( $field );

        $value1 = $this->handler->mapFieldValue( $value1 );
        $value2 = $this->handler->mapFieldValue( $value2 );

        if ( $this->definition && isset( $this->definition->fields[$field] ) )
        {
            $field = $this->handler->mapFieldType( $field, $this->definition->fields[$field]->type );
        }

        $ret = "$field:[$value1 TO $value2]";

        if ( $this->definition && isset( $this->definition->fields[$field] ) && $this->definition->fields[$field]->boost != 1 )
        {
            $ret .= "^{$this->definition->fields[$field]->boost}";
        }
        return $ret;
    }

    // FIX ME: NO EZCQUERY 
    /**
     * Creates an OR clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed
     * @return string
     */
    public function lOr()
    {
        $args = func_get_args();
        if ( count( $args ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'lOr', count( $args ), 1 );
        }

        $elements = ezcSearchQueryTools::arrayFlatten( $args );
        if ( count( $elements ) == 1 )
        {
            return $elements[0];
        }
        else
        {
            return '( ' . join( ' OR ', $elements ) . ' )';
        }
    }

    // FIX ME: NO EZCQUERY 
    /**
     * Creates an AND clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed
     * @return string
     */
    public function lAnd()
    {
        $args = func_get_args();
        if ( count( $args ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'lOr', count( $args ), 1 );
        }

        $elements = ezcSearchQueryTools::arrayFlatten( $args );
        if ( count( $elements ) == 1 )
        {
            return $elements[0];
        }
        else
        {
            return '( ' . join( ' AND', $elements ) . ' )';
        }
    }

    /**
     * Creates a NOT clause
     *
     * This method accepts a clause and negates it.
     *
     * @param string $clause
     * @return string
     */
    public function not( $clause )
    {
        return "!$clause";
    }

    /**
     * Creates an 'import' clause
     *
     * This method accepts a clause and marks it as important.
     *
     * @param string $clause
     * @return string
     */
    public function important( $clause )
    {
        return "+$clause";
    }

    /**
     * Modifies a clause to give it higher weight while searching.
     *
     * This method accepts a clause and adds a boost factor.
     *
     * @param string $clause
     * @return string
     */
    public function boost( $clause, $boostFactor )
    {
        return "$clause^$boostFactor";
    }

    /**
     * Modifies a clause make it fuzzy.
     *
     * This method accepts a clause and registers it as a fuzzy search, an
     * optional fuzz factor is also supported.
     *
     * @param string $clause
     * @return string
     */
    public function fuzz( $clause, $fuzzFactor = false )
    {
        if ( $fuzzFactor )
        {
            return "$clause~$fuzzFactor";
        }
        return "$clause~";
    }
}
?>
