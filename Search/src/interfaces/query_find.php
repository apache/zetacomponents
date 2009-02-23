<?php
/**
 * File containing the ezcSearchFindQuery class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class to create select search backend indepentent search queries.
 *
 * @package Search
 * @version //autogentag//
 * @mainclass
 */
interface ezcSearchFindQuery extends ezcSearchQuery
{
    /**
     * Opens the query and selects which fields you want to return with
     * the query.
     *
     * select() accepts an arbitrary number of parameters. Each parameter must
     * contain either the name of a field or an array containing the names of
     * the fields.  Each call to select() appends fields to the list of
     * fields that will be used in the query.
     *
     * Example:
     * <code>
     * $q->select( 'field1', 'field2' );
     * </code>
     * The same could also be written:
     * <code>
     * $fields[] = 'field1';
     * $fields[] = 'field2;
     * $q->select( $fields );
     * </code>
     * or using several calls
     * <code>
     * $q->select( 'field1' )->select( 'field2' );
     * </code>
     *
     * @param string|array(string) $... Either a string with a field name or an array of field names.
     * @return ezcSearchFindQuery
     */
    public function select();
}

?>
