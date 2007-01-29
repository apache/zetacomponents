<?php
/**
 * File containing the ezcQueryExpressionSqlite class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
}
?>
