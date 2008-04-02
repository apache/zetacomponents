<?php
class ezcSearchFindQuerySolr implements ezcSearchFindQuery
{
    /**
     * Holds the expression object
     *
     * @var ezcSearchExpression
     */
    public $expr;

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

    public $whereClauses;

    public $handler;
    public $definition;

    /**
     * Constructs a new ezcSearchFindQuerySolr object
     */
    public function __construct( $handler, $definition = null )
    {
        $this->handler = $handler;
        $this->definition = $definition;
        $this->resultFields = array();
        $this->highlightFields = array();
    }

    public function reset()
    {
        $this->resultFields = array();
        $this->highlightFields = array();
    }

    public function select()
    {
        $args = func_get_args();
        $cols = ezcSearchQueryTools::arrayFlatten( $args );
        $this->resultFields = array_merge( $this->resultFields, $cols );
        return $this;
    }

    public function highlight()
    {
        $args = func_get_args();
        $cols = ezcSearchQueryTools::arrayFlatten( $args );
        $this->highlightFields = array_merge( $this->highlightFields, $cols );
        return $this;
    }

    public function where( $clause )
    {
        $this->whereClauses[] = $clause;
        return $this;
    }

    public function limit( $limit, $offset = '' )
    {
    }

    public function orderBy( $column, $type = ezcSearchQueryTools::ASC )
    {
    }

    public function getQuery()
    {
        return $this->handler->getQuery( $this );
    }

    /**
     * Returns a string containing a field/value specifier
     *
     * @param string $field
     * @param mixed $value
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
     * Returns a string containing a field/value specifier
     *
     * @param string $field
     * @param mixed $value
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

    public function lOr( $clause1, $clause2 )
    {
        return "($clause1 OR $clause2)";
    }

    public function lAnd( $clause1, $clause2 )
    {
        return "($clause1 AND $clause2)";
    }

    public function not( $clause )
    {
        return "!$clause";
    }

    public function important( $clause )
    {
        return "+$clause";
    }

    public function boost( $clause, $boostFactor )
    {
        return "$clause^$boostFactor";
    }

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
