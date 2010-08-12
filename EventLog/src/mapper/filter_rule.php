<?php
/**
 * File containing the ezcLogFilterRule class.
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
 * @package EventLog
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * The ezcLogFilterRule is a rule that is added to the ezcLogFilterSet.
 *
 * This class binds the matching part of the filter rule together with a container.
 * The container contains the value bound to the filter.
 *
 * {@link __construct()}
 *
 * @package EventLog
 * @version //autogentag//
 */
class ezcLogFilterRule
{
    /**
     * The matching part of the ezcLogFilterRule
     *
     * @var ezcLogFilter
     */
    private $filter;

    /**
     * Should continue to the next filter if this rule matches?
     *
     * @var bool
     */
    private $continueProcessing;

    /**
     * The container that contains the result.
     *
     * @var array(mixed)
     */
    private $container;

    /**
     * True if it matches all severities, otherwise false.
     *
     * @var bool
     */
    private $severityStar = false;

    /**
     * True if it matches all sources, otherwise false.
     *
     * @var bool
     */
    private $sourceStar = false;

    /**
     * True if it matches all categories, otherwise false.
     *
     * @var bool
     */
    private $categoryStar = false;

    /**
     * Internal structure for faster lookup.
     *
     * @var array(string=>mixed)
     */
    private $structure;

    /**
     * Creates an ezcLogFilterRule.
     *
     * The ezcLogFilter $filter is the matching part of this filter rule. See {@link get()}.
     * The $container contains the value bound to the $filter, the result.
     * If the filter matches, the boolean $continueProcessing indicates whether the next
     * filter is processed.
     *
     * @param ezcLogFilter $filter
     * @param mixed $container
     * @param bool $continueProcessing
     */
    public function __construct( ezcLogFilter $filter, $container, $continueProcessing )
    {
        $this->filter = clone( $filter );

        if ( $this->filter->severity  == 0 )
        {
            $this->severityStar = true;
        }

        if ( sizeof( $this->filter->source ) == 0 )
        {
            $this->filter->source = array( "*" );
            $this->sourceStar = true;
        }

        if ( sizeof( $this->filter->category ) == 0 )
        {
            $this->filter->category = array( "*" );
            $this->categoryStar = true;
        }

        $this->continueProcessing = $continueProcessing;
        $this->container = ( is_array( $container ) ? $container : array( $container ) );

        $this->createStructure();
    }

    /**
     * Creates an internal structure, to quickly lookup the combination of severity, source, and
     * categories.
     */
    protected function createStructure()
    {
        $severities = $this->getMaskArray( $this->filter->severity );
        if ( sizeof( $severities ) == 0 )
        {
            $severities = array( "*" );
        }

        foreach ( $severities as $severity )
        {
            foreach ( $this->filter->source as $source )
            {
                foreach ( $this->filter->category as $category )
                {
                    $key =  $severity . "_" . $source . "_" . $category;

                       $this->structure[ $key ] = true;
                }
            }
        }
    }

    /**
     * Returns true when the given $severity, $source, and $category matches with this filter rule.
     *
     * @param int $severity
     * @param string $source
     * @param string $category
     * @return bool
     */
    public function isMatch( $severity, $source, $category )
    {
     if ( $this->severityStar )
        {
            $severity = "*";
        }

     if ( $this->sourceStar )
        {
            $source = "*";
        }

     if ( $this->categoryStar )
        {
            $category = "*";
        }

        $key =  $severity . "_" . $source . "_" . $category;
        return ( isset( $this->structure[ $key ] ) && $this->structure[ $key ] );
    }

    /**
     * Returns the container, containing the result.
     *
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Returns true if, after matching, should proceeded to the next filter rule.
     *
     * @return bool
     */

    public function shouldContinueProcessing()
    {
        return $this->continueProcessing;
    }

    /**
     * Returns the bits set in $mask as separate values in an array.
     *
     * @param int $mask
     * @return array(int)
     */
    protected function getMaskArray( $mask )
    {
        $result = array();

        $input = 1;
        while ( $input <= $mask )
        {
            if ( $mask & $input )
            {
                $result[] = $input;
            }
            $input <<= 1;
        }

        return $result;
    }
}
?>
