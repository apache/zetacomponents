<?php
/**
 * File containing the ezcQueryExpression class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQueryExpression class is used to create database independent SQL expression.
 *
 * The QueryExpression class is usually used through the 'expr' variable in
 * one of the Select, Insert, Update or Delete classes.
 *
 * Note that the methods for logical or and and are
 * named lOr and lAnd respectively. This is because and and or are reserved names
 * in PHP and can not be used in method names.
 *
 * @package Database
 * @mainclass
 */
class ezcQueryExpression
{
    /**
     * The column and table name aliases.
     *
     * Format: array('alias' => 'realName')
     * @var array(string=>string)
     */
    private $aliases = null;

    /**
     * Constructs an empty ezcQueryExpression
     */
    public function __construct( array $aliases = array() )
    {
        if ( !empty( $aliases ) )
        {
            $this->aliases = $aliases;
        }
    }

    /**
     * Sets the aliases $aliases for this object.
     *
     * The aliases can be used to substitute the column and table names with more
     * friendly names. E.g PersistentObject uses it to allow using property and class
     * names instead of column and table names.
     *
     * @param array(string=>string) $aliases
     * @return void
     */
    public function setAliases( array $aliases )
    {
        $this->aliases = $aliases;
    }

    /**
     * Returns true if this object has aliases.
     *
     * @return bool
     */
    public function hasAliases()
    {
        return $this->aliases !== null ? true : false;
    }

    /**
     * Returns the correct identifier for the alias $alias.
     *
     * If the alias does not exists in the list of aliases
     * it is returned unchanged.
     *
     * @param string $alias
     * @return string
     */
    protected function getIdentifier( $alias )
    {
        if ( $this->aliases !== null &&
            array_key_exists( $alias, $this->aliases ) )
        {
            return $this->aliases[$alias];
        }
        return $alias;
    }

    /**
     * Returns the correct identifiers for the aliases found in $aliases.
     *
     * This method is similar to getIdentifier except that it works on an array.
     *
     * @param array(string) $alias
     * @returns array(string)
     */
    protected function getIdentifiers( array $aliasList )
    {
        if ( $this->aliases !== null )
        {
            foreach ( $aliasList as $key => $alias )
            {
                if ( array_key_exists( $alias, $this->aliases ) )
                {
                    $aliasList[$key] = $this->aliases[$alias];
                }
            }
        }
        return $aliasList;
    }

    /**
     * Returns the SQL to bind logical expressions together using a logical or.
     *
     * lOr() accepts an arbitrary number of parameters. Each parameter
     * must contain a logical expression or an array with logical expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $e = $q->expr;
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $e->lOr( $e->eq( 'id', 1 ),
     *                                    $e->eq( 'id', 2 ) ) );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @return string a logical expression
     */
    public function lOr()
    {
        $args = func_get_args();
        if ( count( $args ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'lOr', count( $args ), 1 );
        }

        $elements = ezcQuerySelect::arrayFlatten( $args );
        if ( count( $elements ) == 1 )
        {
            return $elements[0];
        }
        else
        {
            return '( ' . join( ' OR ', $elements ) . ' )';
        }
    }

    /**
     * Returns the SQL to bind logical expressions together using a logical and.
     *
     * lAnd() accepts an arbitrary number of parameters. Each parameter
     * must contain a logical expression or an array with logical expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $e = $q->expr;
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $e->lAnd( $e->eq( 'id', 1 ),
     *                                     $e->eq( 'id', 2 ) ) );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @return string a logical expression
     */
    public function lAnd()
    {
        $args = func_get_args();
        if ( count( $args ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'lAnd', count( $args ), 1 );
        }

        $elements = ezcQuerySelect::arrayFlatten( $args );
        if ( count( $elements ) == 1 )
        {
            return $elements[0];
        }
        else
        {
            return '( ' . join( ' AND ', $elements ) . ' )';
        }
    }

    /**
     * Returns the SQL for a logical not.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $e = $q->expr;
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $e->eq( 'id', $e->not( 'null' ) ) );
     * </code>
     *
     * @return string a logical expression
     */
    public function not( $expression )
    {
        $expression = $this->getIdentifier( $expression );
        return "NOT ( {$expression} )";
    }

    // math

    /**
     * Returns the SQL to perform the same mathematical operation over an array
     * of values or expressions.
     *
     * basicMath() accepts an arbitrary number of parameters. Each parameter
     * must contain a value or an expression or an array with values or
     * expressions.
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @param string $type the type of operation, can be '+', '-', '*' or '/'.
     * @param string|array(string)
     * @return string an expression
     */
    private function basicMath( $type )
    {
        $args = func_get_args();
        $elements = ezcQuerySelect::arrayFlatten( array_slice( $args, 1 ) );
        $elements = $this->getIdentifiers( $elements );
        if ( count( $elements ) < 1 )
        {
            throw new ezcQueryVariableParameterException( $type, count( $args ), 1 );
        }
        if ( count( $elements ) == 1 )
        {
            return $elements[0];
        }
        else
        {
            return '( ' . join( " $type ", $elements ) . ' )';
        }
    }

    /**
     * Returns the SQL to add values or expressions together.
     *
     * add() accepts an arbitrary number of parameters. Each parameter
     * must contain a value or an expression or an array with values or
     * expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->add( 'id', 2 )  );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @param string|array(string)
     * @return string an expression
     */
    public function add()
    {
        $args = func_get_args();
        return $this->basicMath( '+', $args  );
    }

    /**
     * Returns the SQL to subtract values or expressions from eachother.
     *
     * subtract() accepts an arbitrary number of parameters. Each parameter
     * must contain a value or an expression or an array with values or
     * expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->subtract( 'id', 2 )  );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @param string|array(string)
     * @return string an expression
     */
    public function sub()
    {
        $args = func_get_args();
        return $this->basicMath( '-', $args );
    }

    /**
     * Returns the SQL to multiply values or expressions by eachother.
     *
     * multiply() accepts an arbitrary number of parameters. Each parameter
     * must contain a value or an expression or an array with values or
     * expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->multiply( 'id', 2 )  );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @param string|array(string)
     * @return string an expression
     */
    public function mul()
    {
        $args = func_get_args();
        return $this->basicMath( '*', $args );
    }

    /**
     * Returns the SQL to divide values or expressions by eachother.
     *
     * divide() accepts an arbitrary number of parameters. Each parameter
     * must contain a value or an expression or an array with values or
     * expressions.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->divide( 'id', 2 )  );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with no parameters.
     * @param string|array(string)
     * @return string an expression
     */
    public function div()
    {
        $args = func_get_args();
        return $this->basicMath( '/', $args );
    }

    /**
     * Returns the SQL to check if two values are equal.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->eq( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function eq( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} = {$value2}";
    }

    /**
     * Returns the SQL to check if two values are unequal.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->neq( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function neq( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} <> {$value2}";
    }

    /**
     * Returns the SQL to check if one value is greater than another value.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->gt( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function gt( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} > {$value2}";
    }

    /**
     * Returns the SQL to check if one value is greater than or equal to
     * another value.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->gte( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function gte( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} >= {$value2}";
    }

    /**
     * Returns the SQL to check if one value is less than another value.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->lt( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function lt( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} < {$value2}";
    }

    /**
     * Returns the SQL to check if one value is less than or equal to
     * another value.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->lte( 'id', 1 ) );
     * </code>
     *
     * @param string $value1 logical expression to compare
     * @param string $value2 logical expression to compare with
     * @return string logical expression
     */
    public function lte( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$value1} <= {$value2}";
    }

    /**
     * Returns the SQL to check if a value is one in a set of
     * given values..
     *
     * in() accepts an arbitrary number of parameters. The first parameter
     * must always specify the value that should be matched against. Successive
     * must contain a logical expression or an array with logical expressions.
     * These expressions will be matched against the first parameter.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->in( 'id', 1, 2, 3 ) );
     * </code>
     *
     * @throws ezcDbAbstractionException if called with less than two parameters..
     * @param string $column the value that should be matched against
     * @param string|array(string) values that will be matched against $column
     * @return string logical expression
     */
    public function in( $column )
    {
        $args = func_get_args();
        if ( count( $args ) < 2 )
        {
            throw new ezcQueryVariableParameterException( 'in', count( $args ), 2 );
        }

        $values = ezcQuerySelect::arrayFlatten( array_slice( $args, 1 ) );
        $values = $this->getIdentifiers( $values );
        $column = $this->getIdentifier( $column );

        if ( count( $values ) == 0 )
        {
            throw new ezcQueryVariableParameterException( 'in', count( $args ), 2 );
        }
        return "{$column} IN ( " . join( ', ', $values ) . ' )';
    }

    /**
     * Returns SQL that checks if a expression is null.
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->isNull( 'id') );
     * </code>
     *
     * @param string $expression the expression that should be compared to null
     * @return string logical expression
     */
    public function isNull( $expression )
    {
        $expression = $this->getIdentifier( $expression );
        return "{$expression} IS NULL";
    }

    /**
     * Returns SQL that checks if an expression evaluates to a value between
     * two values.
     *
     * The parameter $expression is checked if it is between $value1 and $value2.
     *
     * Note: There is a slight difference in the way BETWEEN works on some databases.
     * http://www.w3schools.com/sql/sql_between.asp. If you want complete database
     * independence you should avoid using between().
     *
     * Example:
     * <code>
     * $q = ezcDbInstance::get()->createSelectQuery();
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->between( 'id' , 1, 5 ) );
     * </code>
     *
     * @param string $expression the value to compare to
     * @param string $value1 the lower value to compare with
     * @param string $value2 the higher value to compare with
     * @return string logical expression
     */
    public function between( $expression, $value1, $value2 )
    {
        $expression = $this->getIdentifier( $expression );
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "{$expression} BETWEEN {$value1} AND {$value2}";
    }

    /**
     * Match a partial string in a column.
     *
     * Like will look for the pattern in the column given. Like accepts
     * the wildcards '_' matching a single character and '%' matching
     * any number of characters.
     *
     * @param string $expression the name of the expression to match on
     * @param string $pattern the pattern to match with.
     */
    public function like( $expression, $pattern )
    {
        $expression = $this->getIdentifier( $expression );
        return "{$expression} LIKE {$pattern}";
    }
    // aggregate functions
    /**
     * Returns the average value of a column
     *
     * @param string $column the column to use
     * @return string
     */
    public function avg( $column )
    {
        $column = $this->getIdentifier( $column );
        return "AVG( {$column} )";
    }

    /**
     * Returns the number of rows (without a NULL value) of a column
     *
     * If a '*' is used instead of a column the number of selected rows
     * is returned.
     *
     * @param string $column the column to use
     * @return string
     */
    public function count( $column )
    {
        $column = $this->getIdentifier( $column );
        return "COUNT( {$column} )";
    }

    /**
     * Returns the highest value of a column
     *
     * @param string $column the column to use
     * @return string
     */
    public function max( $column )
    {
        $column = $this->getIdentifier( $column );
        return "MAX( {$column} )";
    }

    /**
     * Returns the lowest value of a column
     *
     * @param string $column the column to use
     * @return string
     */
    public function min( $column )
    {
        $column = $this->getIdentifier( $column );
        return "MIN( {$column} )";
    }

    /**
     * Returns the total sum of a column
     *
     * @param string $column the column to use
     * @return string
     */
    public function sum( $column )
    {
        $column = $this->getIdentifier( $column );
        return "SUM( {$column} )";
    }

    // scalar functions

    /**
     * Returns the md5 sum of a field.
     *
     * Note: Not SQL92, but common functionality
     *
     * @return string
     */
    public function md5( $column )
    {
        $column = $this->getIdentifier( $column );
        return "MD5( {$column} )";
    }

    /**
     * Returns the length of a text field.
     *
     * @param string $expression1
     * @param string $expression2
     * @return string
     */
    public function length( $column )
    {
        $column = $this->getIdentifier( $column );
        return "LENGTH( {$column} )";
    }

    /**
     * Rounds a numeric field to the number of decimals specified.
     *
     * @param string $expression1
     * @param string $expression2
     * @return string
     */
    public function round( $column, $decimals )
    {
        $column = $this->getIdentifier( $column );

        return "ROUND( {$column}, {$decimals} )";
    }

    /**
     * Returns the remainder of the division operation
     * $expression1 / $expression2.
     *
     * @param string $expression1
     * @param string $expression2
     * @return string
     */
    public function mod( $expression1, $expression2 )
    {
        $expression1 = $this->getIdentifier( $expression1 );
        $expression2 = $this->getIdentifier( $expression2 );
        return "MOD( {$expression1}, {$expression2} )";
    }

    /**
     * Returns the current system date.
     *
     * @return string
     */
    public function now()
    {
        return "NOW()";
    }

    // string functions
    /**
     * Returns part of a string.
     *
     * Note: Not SQL92, but common functionality.
     *
     * @param string $value the target $value the string or the string column.
     * @param int $from extract from this characeter.
     * @param int $len extract this amount of characters.
     * @return string sql that extracts part of a string.
     */
    public function subString( $value, $from, $len = null )
    {
        $value = $this->getIdentifier( $value );
        if ( $len === null )
        {
            return "substring( {$value} from {$from} )";
        }
        else
        {
            $len = $this->getIdentifier( $len );
            return "substring( {$value} from {$from} for {$len} )";
        }
    }

    /**
     * Returns a series of strings concatinated
     *
     * concat() accepts an arbitrary number of parameters. Each parameter
     * must contain an expression or an array with expressions.
     *
     * @param string|array(string) strings that will be concatinated.
     */
    public function concat()
    {
        $args = func_get_args();
        $cols = ezcQuerySelect::arrayFlatten( $args );

        if ( count( $cols ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'concat', count( $args ), 1 );
        }

        $cols = $this->getIdentifiers( $cols );
        return "CONCAT( " . join( ', ', $cols ) . ' )';
    }
}
?>
