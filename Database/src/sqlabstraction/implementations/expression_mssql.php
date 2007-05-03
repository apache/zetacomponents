<?php
/**
 * File containing the ezcQueryExpressionMssql class.
 *
 * @package Database
 * @version 1.0
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQueryExpressionMssql class is used to create SQL expression for SQL Server.
 *
 * This class reimplements the methods that have a different syntax in SQL Server.
 *
 * @package Database
 */
class ezcQueryExpressionMssql extends ezcQueryExpression
{

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
        return "{$expression1} % {$expression2}";
    }

    /**
     * Returns the md5 sum of a field. 
     * There is two variants of implementation for this feature.
     * Both not ideal though.
     * First don't require additional setup of MS SQL Server
     * and uses undocumented function master.dbo.fn_varbintohexstr()
     * to convert result of Transact-SQL HashBytes() function to string.
     *
     * Second one requires the stored procedure
     * from http://www.thecodeproject.com/database/xp_md5.asp to 
     * be installed and wrapped by the user defined function fn_md5
     *
     * @return string
     */
    public function md5( $column )
    {
        $column = $this->getIdentifier( $column );
        return "SUBSTRING( master.dbo.fn_varbintohexstr( HashBytes( 'MD5', {$column} ) ), 3, 32)";
        // alternative
        // return "dbo.fn_md5( {$column} )";
    }
    
    /**
     * Returns the length of a text field.
     *
     * @param string $column
     * @return string
     */
    public function length( $column )
    {
        $column = $this->getIdentifier( $column );
        return "LEN( {$column} )";
    }

    /**
     * Returns the current system date.
     *
     * @return string
     */
    public function now()
    {
        return "GETDATE()";
    }

    /**
     * Returns part of a string.
     *
     * Note: Not SQL92, but common functionality.
     *
     * @param string $value the target $value the string or the string column.
     * @param int $from extract from this characeter.
     * @param int $len extract this amount of characters. If $len is not 
     *            provided it's assumed to be the number of characters 
     *            to get the whole remainder of the string.
     * @return string sql that extracts part of a string.
     */
    public function subString( $value, $from, $len = null )
    {
        $value = $this->getIdentifier( $value );
        if ( $len === null )
        {
            return "SUBSTRING( {$value}, {$from}, LEN({$value})-({$from}-1) )";
        }
        else
        {
            $len = $this->getIdentifier( $len );
            return "SUBSTRING( {$value}, {$from}, {$len} )";
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
        return join( ' + ', $cols );
    }
}
?>
