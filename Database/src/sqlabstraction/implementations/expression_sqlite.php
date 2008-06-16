<?php
/**
 * File containing the ezcQueryExpressionSqlite class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQueryExpressionSqlite class is used to create SQL expression for SQLite.
 *
 * This class reimplements the methods that have a different syntax in
 * SQLite (substr) and contains PHP implementations of functions that are
 * registered with SQLite with it's PDO::sqliteRegisterFunction() method.
 *
 * @package Database
 * @version //autogentag//
 */
class ezcQueryExpressionSqlite extends ezcQueryExpression
{
    /**
     * Contains an interval map from generic intervals to SQLite native intervals.
     *
     * @var array(string=>string)
     */
    protected $intervalMap = array(
        'SECOND' => 'seconds',
        'MINUTE' => 'minutes',
        'HOUR' => 'hours',
        'DAY' => 'days',
        'MONTH' => 'months',
        'YEAR' => 'years',
    );

    /**
     * Returns part of a string.
     *
     * Note: Not SQL92, but common functionality. SQLite only supports the 3
     * parameter variant of this function, so we are using 2^30-1 as
     * artificial length in that case.
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
            $len = $this->getIdentifier( $len );
            return "substr( {$value}, {$from}, 1073741823 )";
        }
        else
        {
            return "substr( {$value}, {$from}, {$len} )";
        }
    }

    /**
     * Returns the current system date and time.
     *
     * @return string
     */
    public function now()
    {
        return '"' . date( 'Y-m-d H:i:s' ) . '"';
    }

    /**
     * Returns the SQL that performs the bitwise XOR on two values.
     *
     * @param string $value1
     * @param string $value2
     * @return string
     */
    public function bitXor( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "( ( {$value1} | {$value2} ) - ( {$value1} & {$value2} ) )";
    }

    /**
     * Returns the SQL that converts a timestamp value to a unix timestamp.
     *
     * @param string $column
     * @return string
     */
    public function unixTimestamp( $column )
    {
        if ( $column == 'NOW()' )
        {
            return " strftime( '%s', 'now' ) ";
        }
        else
        {
            $column = $this->getIdentifier( $column );
            return " toUnixTimestamp( {$column} ) ";
        }
    }

    /**
     * Returns the SQL that subtracts an interval from a timestamp value.
     *
     * @param string $column
     * @param numeric $expr
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateSub( $column, $expr, $type )
    {
        $type = $this->intervalMap[$type];

        $column = $this->getIdentifier( $column );
        return " datetime( {$column} , '-{$expr} {$type}' ) ";
    }

    /**
     * Returns the SQL that adds an interval to a timestamp value.
     *
     * @param string $column
     * @param numeric $expr
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateAdd( $column, $expr, $type )
    {
        $type = $this->intervalMap[$type];

        $column = $this->getIdentifier( $column );
        return " datetime( {$column} , '+{$expr} {$type}' ) ";
    }

    /**
     * Returns the SQL that extracts parts from a timestamp value.
     *
     * @param string $column
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateExtract( $column, $type )
    {
        switch ( $type )
        {
            case 'SECOND':
                $type = '%S';
                break;
            case 'MINUTE':
                $type = '%M';
                break;
            case 'HOUR':
                $type = '%H';
                break;
            case 'DAY':
                $type = '%d';
                break;
            case 'MONTH':
                $type = '%m';
                break;
            case 'YEAR':
                $type = '%Y';
                break;
        }

        if ( $column == 'NOW()' )
        {
            $column = "'now'";
        }

        $column = $this->getIdentifier( $column );
        return " strftime( '{$type}', {$column} ) ";
    }

    /**
     * Returns the SQL to check if a value is one in a set of
     * given values..
     *
     * in() accepts an arbitrary number of parameters. The first parameter
     * must always specify the value that should be matched against. Successive
     * parameters must contain a logical expression or an array with logical
     * expressions.  These expressions will be matched against the first
     * parameter.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )
     *                  ->where( $q->expr->in( 'id', 1, 2, 3 ) );
     * </code>
     *
     * Optimization note: Call setQuotingValues( false ) before using in() with
     * big lists of numeric parameters. This avoid redundant quoting of numbers
     * in resulting SQL query and saves time of converting strings to
     * numbers inside RDBMS.
     *
     * @throws ezcQueryVariableParameterException if called with less than two
     *         parameters.
     * @throws ezcQueryInvalidParameterException if the 2nd parameter is an
     *         empty array.
     * @param string $column the value that should be matched against
     * @param string|array(string) $... values that will be matched against $column
     * @return string logical expression
     */
    public function in( $column )
    {
        $args = func_get_args();
        if ( count( $args ) < 2 )
        {
            throw new ezcQueryVariableParameterException( 'in', count( $args ), 2 );
        }

        if ( is_array( $args[1] ) && count( $args[1] ) == 0 )
        {
            throw new ezcQueryInvalidParameterException( 'in', 2, 'an empty array', 'a non-empty array' );
        }

        $values = ezcQuerySelect::arrayFlatten( array_slice( $args, 1 ) );

        // Special handling of sub selects to avoid double braces
        if ( count( $values ) === 1 && $values[0] instanceof ezcQuerySubSelect )
        {
            return "{$column} IN " . $values[0]->getQuery();
        }
        
        return parent::in( $column, $values );
    }
}
?>
