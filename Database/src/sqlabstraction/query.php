<?php
/**
 * File containing the ezcQuery class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcQuery class provides the common API for all Query objects.
 *
 * ezcQuery has three main purposes:
 * - it provides a common API for building queries through the getQuery() method.
 * - it provides a common API for binding parameters to queries through
 *   bindValue() and bindParam()
 * - it provides internal aliasing functionality that allows you to use
 *   aliases for table and column names. The substitution is done inside of the
 *   query classes before the query itself is built.
 *
 * Through the bind methods you can bind parameters and values to your
 * query. Finally you can use prepare to get a PDOStatement object
 * from your query object.
 *
 * Subclasses should provide functionality to build an actual query.
 *
 * @package Database
 */
abstract class ezcQuery
{
    /**
     * A pointer to the database handler to use for this query.
     *
     * @var PDO
     */
    protected $db;

    /**
     * The column and table name aliases.
     *
     * Format: array('alias' => 'realName')
     * @var array(string=>string)
     */
    private $aliases = null;

    /**
     * Counter used to create unique ids in the bind methods.
     *
     * @var int
     */
    private $boundCounter = 0;

    /**
     * Stores the list of parameters that will be bound with doBind().
     *
     * Format: array( ':name' => &mixed )
     * @var array(string=>&mixed)
     */
    private $boundParameters = array();

    /**
     * Stores the list of values that will be bound with doBind().
     *
     * Format: array( ':name' => mixed )
     * @var array(string=>mixed)
     */
    private $boundValues = array();

    /**
     * The expression object for this class.
     *
     * @var ezcQueryExpression
     */
    public $expr = null;

    /**
     * Constructs a new ezcQuery that works on the database $db and with the aliases $aliases.
     *
     * The aliases can be used to substitute the column and table names with more
     * friendly names. E.g PersistentObject uses it to allow using property and class
     * names instead of column and table names.
     *
     * @param PDO $db
     * @param array(string=>string) $aliases
     */
    public function __construct( PDO $db, array $aliases = array() )
    {
        $this->db = $db;
        if ( $this->expr == null )
        {
            $this->expr = $db->createExpression();
        }
        if ( !empty( $aliases ) )
        {
            $this->aliases = $aliases;
            $this->expr->setAliases( $this->aliases );
        }
    }

    /**
     * Sets the aliases $aliases for this object.
     *
     * The aliases should be in the form array( "aliasName" => "databaseName" ). Table and
     * column aliases can be mixed in the array.
     *
     * The aliases can be used to substitute the column and table names with more
     * friendly names. The substitution is done when the query is built, not using
     * AS statements in the database itself.
     *
     * Example of a select query with aliases:
     * <code>
     * $q->setAliases( array( 'Identifier' => 'id', 'Company' => 'company' ) );
     * $this->q->select( 'Company' )->from( 'table' )->where( $q->expr->eq( 'Identifier', 5 ) );
     * echo $q->getQuery();
     * </code>
     *
     * This example will output SQL similar to:
     * <code>
     * SELECT company FROM table WHERE id = 5
     * </code>
     *
     * @param array(string=>string) $aliases
     * @return void
     */
    public function setAliases( array $aliases )
    {
        $this->aliases = $aliases;
        $this->expr->setAliases( $aliases );
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
     * Binds the value $value to the specified variable name $placeHolder.
     *
     * This method provides a shortcut for PDOStatement::bindValue
     * when using prepared statements.
     *
     * The parameter $value specifies the value that you want to bind. If
     * $placeholder is not provided bindValue() will automatically create a
     * placeholder for you. An automatic placeholder will be of the name
     * 'ezcValue1', 'ezcValue2' etc.
     *
     * @see http://no.php.net/manual/en/function.pdostatement-bindparam.php
     * @see doBind()
     *
     * Example:
     * <code>
     * $value = 2;
     * $q->eq( 'id', $q->bindValue( $value ) );
     * $stmt = $q->prepare(); // the value 2 is bound to the query.
     * $value = 4;
     * $stmt->execute(); // executed with 'id = 2'
     * </code>
     *
     * @param mixed $value
     * @param string $placeHolder the name to bind with. The string must start with a colon ':'.
     * @return string the placeholder name used.
     */
    public function bindValue( $value, $placeHolder = null )
    {
        if ( $placeHolder === null )
        {
            $this->boundCounter++;
            $placeHolder = ":ezcValue{$this->boundCounter}";
        }
        $this->boundParameters[$placeHolder] = $value;
        return $placeHolder;
    }

    /**
     * Binds the parameter $param to the specified variable name $placeHolder..
     *
     * This method provides a shortcut for PDOStatement::bindParam
     * when using prepared statements.
     *
     * The parameter $param specifies the variable that you want to bind. If
     * $placeholder is not provided bind() will automatically create a
     * placeholder for you. An automatic placeholder will be of the name
     * 'ezcValue1', 'ezcValue2' etc.
     *
     * @see http://no.php.net/manual/en/function.pdostatement-bindparam.php
     * @see doBind()
     *
     * Example:
     * <code>
     * $value = 2;
     * $q->eq( 'id', $q->bindParam( $value ) );
     * $stmt = $q->prepare(); // the parameter $value is bound to the query.
     * $value = 4;
     * $stmt->execute(); // executed with 'id = 4'
     * </code>
     *
     * @param &mixed $param
     * @param string $placeHolder the name to bind with. The string must start with a colon ':'.
     * @return string the placeholder name used.
     */
    public function bindParam( &$param, $placeHolder = null )
    {
        if ( $placeHolder === null )
        {
            $this->boundCounter++;
            $placeHolder = ":ezcValue{$this->boundCounter}";
        }
        $this->boundParameters[$placeHolder] =& $param;
        return $placeHolder;
    }

    /**
     * Performs binding of variables bound with bindValue and bindParam on the statement $stmt.
     *
     * This method must be called if you have used the bind methods
     * in your query and you build the method yourself using build.
     *
     * @param PDOStatement
     * @return void
     */
    public function doBind( PDOStatement $stmt )
    {
        foreach ( $this->boundValues as $key => $value )
        {
            try
            {
                $stmt->bindValue( $key, $value );
            }
            catch ( PDOException $e )
            {
                // see comment below
            }
        }
        foreach ( $this->boundParameters as $key => &$value )
        {
            try
            {
                $stmt->bindParam( $key, $value );
            }
            catch ( PDOException $e )
            {
                // we are ignoring this exception since it may only occur when
                // a bound parameter is not found in the query anymore.
                // this can happen if either drop an expression with a bound value
                // created with this query or if you remove a bind in a query by
                // replacing it with another one.
                // the only other way to avoid this problem is parse the string for the
                // bound variables. Note that a simple search will not do since the variable
                // name may occur in a string.
            }
        }
    }

    /**
     * Returns a prepared statement from this query which can be used for execution.
     *
     * prepare() automatically calls doBind() on the statement.
     * @return PDOStatement
     */
    public function prepare()
    {
        $stmt = $this->db->prepare( $this->getQuery() );
        $this->doBind( $stmt );
        return $stmt;
    }

    /**
     * Returns all the elements in $array as one large single dimensional array.
     *
     * @todo public? Currently this is needed for QueryExpression.
     * @return array
     */
    static public function arrayFlatten( array $array )
    {
        $flat = array();
        foreach ( $array as $arg )
        {
            switch ( gettype( $arg ) )
            {
                case 'array':
                    $flat = array_merge( $flat, $arg );
                    break;

                default:
                    $flat[] = $arg;
                    break;
            }
        }
        return $flat;
    }

    /**
     * Returns the query string for this query object.
     *
     * @throws ezcQueryInvalidException if it was not possible to build a valid query.
     * @return string
     */
    abstract public function getQuery();
}
?>
