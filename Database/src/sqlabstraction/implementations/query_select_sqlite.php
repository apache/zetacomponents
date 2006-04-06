<?php
/**
 * File containing the ezcQuerySelectSqlite class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * SQLite specific implementation of ezcQuery.
 *
 * This class reimplements methods where SQLite differs from the standard
 * implementation in ezcQuery. The only difference is the right join syntax.
 *
 * @see ezcQuery
 * @package Database
 */
class ezcQuerySelectSqlite extends ezcQuerySelect
{
    /**
     * Constructs a new ezcQueryOracle object.
     */
    public function __construct( PDO $db )
    {
        parent::__construct( $db );
    }

    /**
     * Returns the SQL for a right join.
     *
     * SQLite doesn't support a RIGHT OUTER JOIN, so we are rewriting it to a
     * LEFT OUTER JOIN instead.
     *
     * Example:
     * <code>
     * // the following code will produce the SQL
     * // SELECT id FROM t2 LEFT JOIN t1 ON t1.id = t2.id
     * $q->select( 'id' )->from( $q->rightJoin( 't1', 't2', 't1.id', 't2.id' ) );
     * </code>
     *
     * @param string $table1 the name of the table to join with
     * @param string $table2 the name of the table to join
     * @param string $column1 the column to join with
     * @param string $column2 the column to join on
     * @return string the SQL call for a right join.
     */
    public function rightJoin()
    {
        $args = func_get_args();
        $passedArgsCount = count( $args );
        //process old simple sintax.
        if ( $passedArgsCount == 4 ) 
        {
            if ( is_string( $args[0] ) && is_string( $args[1] ) &&
                 is_string( $args[2] ) && is_string( $args[3] ) 
               ) 
            {
                $table1 = $this->getIdentifier( $args[0] );
                $table2 = $this->getIdentifier( $args[1] );
                $column1 = $this->getIdentifier( $args[2] );
                $column2 = $this->getIdentifier( $args[3] );

                return "{$table2} LEFT JOIN {$table1} ON {$column1} = {$column2}";
            }
            else
            {
                throw new ezcQueryInvalidException( 'SELECT', 'Inconsistent types of arguments passed to rightJoin().' );
            }
        }
        else 
        {
            throw new ezcQueryInvalidException( 'SELECT', 'Complex right joins are not supported by ezcQuerySelectSqlite.' );
        }
    }
}
?>
