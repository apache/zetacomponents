<?php
/**
 * File containing the ezcQuerySubSelect class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class to create subselects within queries.
 *
 * The ezcSubQuery used for creating correct subqueries inside ezcQuery object.
 * Class holds a refenence to inclusive ezcQuery and transfer 
 * PDO related calls to it.
 * 
 * 
 * Example:
 * <code>
 * $q = ezcDbInstance::get()->createSelectQuery();
 * $q2 = $q->subSelect();
 * 
 * $q2->select( 'lastname' )->from( 'users' );
 *
 * // This will produce SQL:
 * // SELECT * FROM Greetings WHERE age > 10 AND user IN ( ( SELECT lastname FROM users ) )
 * $q->select( '*' )->from( 'Greetings' );
 *     ->where( $q->expr->gt( 'age', 10 ),
 *              $q->expr->in( 'user', $q2->getQuery() ) );
 * 
 * $stmt = $q->prepare(); // $stmt is a normal PDOStatement
 * $stmt->execute();
 * </code>
 *
 * @package Database
 */
class ezcQuerySubSelect extends ezcQuerySelect
{
    protected $outerQuery = null;

    /**
     * Constructs a new ezcQuery object.
     *
     * @param ezcQuery $outer reference to inclusive ezcQuery object.
     */
    public function __construct( ezcQuery &$outer )
    {
        $this->outerQuery = $outer;

        if ( $this->expr == null )
        {
            $this->expr = ezcDbInstance::get()->createExpression();
        }
    }

    /**
     * Binds the parameter $param to the specified variable name $placeHolder..
     *
     * This method use ezcQuery::bindParam() from the ezcQuery in which subselect included.
     * Info about bounded parameters stored in ezcQuery.
     *
     * The parameter $param specifies the variable that you want to bind. If
     * $placeholder is not provided bind() will automatically create a
     * placeholder for you. An automatic placeholder will be of the name
     * 'ezcValue1', 'ezcValue2' etc.
     *
     * @see ezcQuery::bindParam()
     * 
     * Example:
     * <code>
     * $value = 2;
     * $subSelect = $q->subSelect();
     * $subSelect->select('*')
     *              ->from( 'table2' )
     *                ->where( $subSelect->expr->in('id', $subSelect->bindParam( $value )) );
     * 
     * $q->select('*')
     *     ->from( 'table' )
     *       ->where ( $q->expr->eq( 'id', $subSelect->getQuery() ) );
     * 
     * $stmt = $q->prepare(); // the parameter $value is bound to the query.
     * $value = 4;
     * $stmt->execute(); // subselect executed with 'id = 4'
     * </code>
     * 
     * @param &mixed $param
     * @param string $placeHolder the name to bind with. The string must start with a colon ':'.
     * @return &mixed the placeholder name used.
     */
    public function bindParam( &$param, $placeHolder = null )
    {
        return $this->outerQuery->bindParam( $param, $placeHolder );
    }

    /**
     * Binds the value $value to the specified variable name $placeHolder.
     *
     * This method use ezcQuery::bindValue() from the ezcQuery in which subselect included.
     * Info about bounded parameters stored in ezcQuery.
     *
     * The parameter $value specifies the value that you want to bind. If
     * $placeholder is not provided bindValue() will automatically create a
     * placeholder for you. An automatic placeholder will be of the name
     * 'ezcValue1', 'ezcValue2' etc.
     *
     * @see ezcQuery::bindValue()
     *
     * Example:
     * <code>
     * 
     * $value = 2;
     * $subSelect = $q->subSelect();
     * $subSelect->select( name )
     *              ->from( 'table2' )
     *                ->where(  $subSelect->expr->in('id', $subSelect->bindValue( $value )) );
     * 
     * $q->select('*')
     *     ->from( 'table1' )
     *       ->where ( $q->expr->eq( 'name', $subSelect->getQuery() ) );
     * 
     * $stmt = $q->prepare(); // the $value is bound to the query.
     * $value = 4;
     * $stmt->execute(); // subselect executed with 'id = 2'
     * </code>
     * 
     *
     * @param &mixed $param
     * @param string $placeHolder the name to bind with. The string must start with a colon ':'.
     * @return &mixed the placeholder name used.
     */
    public function bindValue( $param, $placeHolder = null )
    {
        return $this->outerQuery->bindValue( $param, $placeHolder );
    }


    /**
     * Return SQL string for subselect.
     * 
     * Typecasting shouild be done to make __toString() to be called.
     * This will work in PHP 5.2, 6.0
     * 
     * Example:
     * <code>
     * $subSelect = $q->subSelect();
     * $subSelect->select( name )->from( 'table2' );
     * $q->select('*')
     *     ->from( 'table1' )
     *       ->where ( $q->expr->eq( 'name', (string)$subSelect ) );
     * $stmt = $q->prepare(); 
     * $stmt->execute();
     * </code>
     * 
     * @return string SQL string for subselect.
     */
    public function __toString()
    {
        return '( '.$this->getQuery().' )';
    }

    /**
     * Return string with SQL query for subselect.
     * 
     * Example:
     * <code>
     * $subSelect = $q->subSelect();
     * $subSelect->select( name )->from( 'table2' );
     * $q->select('*')
     *     ->from( 'table1' )
     *       ->where ( $q->expr->eq( 'name', $subSelect->getQuery() ) );
     * $stmt = $q->prepare(); 
     * $stmt->execute();
     * </code>
     * 
     * @return string SQL string for subselect.
     */
    public function getQuery()
    {
        return '( '.parent::getQuery().' )';
    }

    /* 
    * Returns ezcQuerySubSelect of deeper level.
    *
    * Used for making subselects inside subselects.
    *
    * Example:
    * <code>
    * 
    * $value = 2;
    * $subSelect = $q->subSelect();
    * $subSelect->select( name )
    *              ->from( 'table2' )
    *                ->where( $subSelect->expr->in('id', $subSelect->bindValue( $value )) );
    * 
    * $q->select(*)
    *     ->from( 'table1' )
    *       ->where ( $q->expr->eq( 'name', $subSelect->getQuery() ) );
    * 
    * $stmt = $q->prepare(); // the $value is bound to the query.
    * $value = 4;
    * $stmt->execute(); // subselect executed with 'id = 2'
    * </code>
    *
    * @return ezcQuerySubSelect
    */
    public function subSelect()
    {
        return new ezcQuerySubSelect( $this->outerQuery );
    }

}

?>
