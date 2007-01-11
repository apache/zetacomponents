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
class ezcQuerySqliteFunctions
{
    /**
     * Returns the md5 sum of the data that SQLite's md5() function receives.
     *
     * @return string
     */
    static public function md5Impl( $data )
    {
        return md5( $data );
    }

    /**
     * Returns the modules of the data that SQLite's mod() function receives.
     *
     * @return string
     */
    static public function modImpl( $dividend, $divisor )
    {
        return $dividend % $divisor;
    }

    /**
     * Returns a concattenation of the data that SQLite's concat() function receives.
     *
     * @return string
     */
    static public function concatImpl()
    {
        $args = func_get_args();
        return join( '', $args );
    }
}
?>
