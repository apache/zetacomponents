<?php
/**
 * File containing the ezcSearchResult class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Solr backend implementation
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchResult
{
    public $status;
    public $queryTime;
    public $resultCount;
    public $start;
    public $documents;

    public function __construct()
    {
    }
}
