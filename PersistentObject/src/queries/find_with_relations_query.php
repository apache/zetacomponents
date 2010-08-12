<?php
/**
 * File containing the ezcPersistentFindWithRelationsQuery class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package PersistentObject
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Find query object for pre-fetching queries in ezcPersistentSessionIdentityDecorator.
 *
 * This query class extends {@link ezcPersistentFindQuery} with the possibility
 * to define related objects to be pre-fretched. Do not instantiate this class
 * directly, but use {@link
 * ezcPersistentIdentityDecorator::createFindQueryWithRelations()} instead.
 *
 * @property-read bool $isRestricted
 *                Whether the query has been restricted using a {@link where()}
 *                condition.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentFindWithRelationsQuery extends ezcPersistentFindQuery
{
    /**
     * Creates a new persistent find query.
     *
     * Creates a new persistent find query from the query object $q and the
     * given $className. $relations defines, which related objects should be
     * fetched by this query.
     *
     * @see ezcPerisistentSessionIdenityDecorator::createFindWithRelationsQuery()
     * 
     * @param ezcQuerySelect $query
     * @param string $className
     * @param array(string=>ezcPersistentRelationFindDefinition) $relations
     */
    public function __construct( ezcQuerySelect $query, $className, array $relations )
    {
        parent::__construct( $query, $className );
        $this->properties['isRestricted'] = false;
        $this->properties['relations']    = $relations;
    }

    /**
     * Adds a where clause with logical expressions to the query.
     *
     * where() accepts an arbitrary number of parameters. Each parameter
     * must contain a logical expression or an array with logical expressions.
     * If you specify multiple logical expression they are connected using
     * a logical and.
     *
     * Multiple calls to where() will join the expressions using a logical and.
     *
     * Example:
     * <code>
     * $q->select( '*' )->from( 'table' )->where( $q->expr->eq( 'id', 1 ) );
     * </code>
     *
     * Note, if you add a WHERE clause to this query, the fetched related
     * objects will not be fetched into the {@link ezcPersistentIdentityMap}
     * used as a typical related object set, but as a named set.
     *
     * @throws ezcQueryVariableParameterException if called with no parameters.
     * @param string|array(string) $... Either a string with a logical expression name
     *                                  or an array with logical expressions.
     * @return ezcQuerySelect
     */
    public function where()
    {
        $args = func_get_args();

        $this->properties['isRestricted'] = true;

        $this->query->where( $args );

        return $this;
    }

    /**
     * Delegate to inner $query object.
     *
     * This query object does not allow any other calls than {where()} and
     * {groupBy()}. Therefore, this method throws an exception, for any other
     * call.
     * 
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws RuntimeException For any call.
     */
    public function __call( $methodName, $arguments )
    {
        switch ( $methodName )
        {
            case 'orderBy':
            case 'getQuery':
            case 'hasAliases':
            case 'getIdentifier':
            case 'getIdentifiers':
            case 'bindValue':
            case 'bindParam':
            case 'resetBinds':
            case 'doBind':
            case 'prepare':
            case 'subSelect':
                return parent::__call( $methodName, $arguments );
        }
        throw new RuntimeException(
            "Method '$methodName' does not exist or is not allowed to be called."
        );
    }

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param mixed $properyValue
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the desired property could not be found.
     * @throws ezcBaseValueException
     *         if $properyValue is not valid for $propertyName.
     */
    public function __set( $propertyName, $properyValue )
    {
        switch ( $propertyName )
        {
            case 'isRestricted':
            case 'relations':
                throw new ezcBasePropertyPermissionException(
                    $propertyName,
                    ezcBasePropertyPermissionException::READ
                );

            default:
                return parent::__set( $propertyName, $properyValue );
        }
    }
}

?>
