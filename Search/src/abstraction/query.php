<?php
/**
 * File containing the ezcSearchQuery class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcSearchQuery class provides the common API for all Query objects.
 *
 * Subclasses should provide functionality to build an actual query.
 *
 * @package Search
 * @version //autogentag//
 * @private
 */
abstract class ezcSearchQuery
{
    /**
     * A pointer to the search handler to use for this query.
     *
     * @var ezcSearchHandler
     */
    protected $handler;

    /**
     * Constructs a new ezcSearchQuery that works on the handler $handler.
     *
     * @param ezcSearchHandler $handler
     */
    public function __construct( ezcSearchHandler $handler )
    {
        $this->handler = $handler;
    }

    /**
     * Return query string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getQuery();
    }

    /**
     * Returns the query string for this query object.
     *
     * @throws ezcSearchQueryInvalidException if it was not possible to build a valid query.
     * @return string
     */
    abstract public function getQuery();
}
?>
