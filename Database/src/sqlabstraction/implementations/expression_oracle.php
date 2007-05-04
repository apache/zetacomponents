<?php
/**
 * File containing the ezcQueryExpressionPgsql class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQueryExpressionPgsql class is used to create SQL expression for PostgreSQL.
 *
 * This class reimplements the methods that have a different syntax in postgreSQL.
 *
 * @package Database
 */
class ezcQueryExpressionOracle extends ezcQueryExpression
{
    /**
     * Constructs an empty ezcQueryExpression
     * @param PDO $db     
     */
    public function __construct( PDO $db )
    {
        parent::__construct( $db );
    }

    /**
     * Returns a series of strings concatinated
     *
     * concat() accepts an arbitrary number of parameters. Each parameter
     * must contain an expression or an array with expressions.
     *
     * @throws ezcQueryVariableException if no parameters are provided
     * @param string|array(string) strings that will be concatinated.
     * @return string
     */
    public function concat()
    {
        $args = func_get_args();
        $cols = ezcQuery::arrayFlatten( $args );
        if ( count( $cols ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'concat', count( $args ), 1 );
        }

        $cols = $this->getIdentifiers( $cols );
        return join( ' || ' , $cols );
    }

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
            return "substr( {$value}, {$from} )";
        }
        else
        {
            $len = $this->getIdentifier( $len );
            return "substr( {$value}, {$from}, {$len} )";
        }
    }

    /**
     * Returns the current system date and time.
     *
     * Note: The returned timestamp is a SYSDATE.
     * The format can be set after connecting with e.g.:
     * ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'
     *
     * @return string
     */
    public function now()
    {
        return "LOCALTIMESTAMP";
    }

    /**
     * Returns the SQL to locate the position of the first occurrence of a substring
     * 
     * @param string $substr
     * @param string $value
     * @return string
     */
    public function position( $substr, $value )
    {
        $value = $this->getIdentifier( $value );
        return "INSTR( {$value}, '{$substr}' )";
    }

    /**
     * Returns the SQL that performs the bitwise AND on two values.
     *
     * @param string $value1
     * @param string $value2
     * @return string
     */
    public function bitAnd( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "bitand( {$value1}, {$value2} )";
    }

    /**
     * Returns the SQL that performs the bitwise OR on two values.
     *
     * @param string $value1
     * @param string $value2
     * @return string
     */
    public function bitOr( $value1, $value2 )
    {
        $value1 = $this->getIdentifier( $value1 );
        $value2 = $this->getIdentifier( $value2 );
        return "( {$value1} + {$value2} - bitand( {$value1}, {$value2} ) )";
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
        return "( {$value1} + {$value2} - bitand( {$value1}, {$value2} ) * 2 )";
    }

    /**
     * Returns the SQL that converts a timestamp value to a unix timestamp.
     *
     * @param string $column
     * @return string
     */
    public function unixTimestamp( $column )
    {
        $column = $this->getIdentifier( $column );

        if ( $column != 'NOW()' )
        {
            $column = "CAST( {$column} AS TIMESTAMP )";
//            // alternative
//            if ( preg_match( '/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $column ) ) {
//                $column = "TO_TIMESTAMP( {$column}, 'YYYY-MM-DD HH24:MI:SS' )";
//            }
        }

        $date1 = "CAST( SYS_EXTRACT_UTC( {$column} ) AS DATE )";
        $date2 = "TO_DATE( '19700101000000', 'YYYYMMDDHH24MISS' )";
        return " ROUND( ( {$date1} - {$date2} ) / ( 1 / 86400 ) ) ";
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

        if ( $column != 'NOW()' )
        {
            $column = "CAST( {$column} AS TIMESTAMP )";
        }

        return " {$column} - INTERVAL '{$expr}' {$type} ";
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

        if ( $column != 'NOW()' )
        {
            $column = "CAST( {$column} AS TIMESTAMP )";
        }

        return " {$column} + INTERVAL '{$expr}' {$type} ";
    }

    /**
     * Returns the SQL that extracts parts from a timestamp value.
     *
     * @param string $date
     * @param string $type one of SECOND, MINUTE, HOUR, DAY, MONTH, or YEAR
     * @return string
     */
    public function dateExtract( $column, $type )
    {
        $type = $this->intervalMap[$type];
        $column = $this->getIdentifier( $column );

        if ( $column != 'NOW()' )
        {
            $column = "CAST( {$column} AS TIMESTAMP )";
        }

        if ( $type == 'SECOND' )
        {
            return " FLOOR( EXTRACT( {$type} FROM {$column} ) ) ";
        }
        else
        {
            return " EXTRACT( {$type} FROM {$column} ) ";
        }
    }
}
?>
