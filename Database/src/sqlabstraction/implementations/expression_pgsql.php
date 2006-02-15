<?php
/**
 * File containing the ezcQueryExpressionPgsql class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQueryExpressionPgsql class is used to create SQL expression for PostgreSQL.
 *
 * This class reimplements the methods that have a different syntax in postgreSQL.
 *
 * @package Database
 */
class ezcQueryExpressionPgsql extends ezcQueryExpression
{
    /**
     * Stores the PostgreSQL version number.
     *
     * @var int
     */
    private $version;

    /**
     * Constructs an empty ezcQueryExpression with the versoin $version.
     *
     * @todo Provide version number or a pointer to $db?
     * @param int $version
     */
    public function __construct( $version )
    {
        parent::__construct();
        $this->version = $version;
    }

    /**
     * Returns the md5 sum of a field.
     *
     * Note: Not SQL92, but common functionality
     *
     * md5() works with the default PostgreSQL 8 versions.
     *
     * If you are using PostgreSQL 7.x or older you need
     * to make sure that the digest procedure.
     * If you use RPMS (Redhat and Mandrake) install the postgresql-contrib
     * package. You must then install the procedure by running this shell command:
     * <code>
     * psql [dbname] < /usr/share/pgsql/contrib/pgcrypto.sql
     * </code>
     * You should make sure you run this as the postgres user.
     *
     * @return string
     */
    public function md5( $column )
    {
        $column = $this->getIdentifier( $column );
        if ( $this->version > 7 )
        {
            return "MD5( {$column} )";
        }
        else
        {
            return " encode( digest( $column, 'md5' ), 'hex' ) ";
        }
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
            $len = $this->getIdentifier( $len );
            return "substr( {$value}, {$from} )";
        }
        else
        {
            return "substr( {$value}, {$from}, {$len} )";
        }
    }

    /**
     * Returns a series of strings concatinated
     *
     * concat() accepts an arbitrary number of parameters. Each parameter
     * must contain an expression or an array with expressions.
     *
     * @throws ezcQueryVariableParameterException if no parameters are provided.
     * @param string|array(string) strings that will be concatinated.
     * @return string
     */
    public function concat()
    {
        $args = func_get_args();
        $cols = ezcQuery::arrayFlatten( $args );
        if ( count( $cols ) < 1 )
        {
            throw new ezcQueryVariableParameterException( 'select', count( $args ), 1 );
        }

        $cols = $this->getIdentifiers( $cols );

        return join( ' || ' , $cols );
    }
}
?>
