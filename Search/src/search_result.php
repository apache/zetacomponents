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
    // private so that we can only use the factory to create it
    private function __construct()
    {
    }

    static public function createFromResponse( $response )
    {
        $s = new ezcSearchResult();
        $s->status = $response->responseHeader->status;
        $s->queryTime = $response->responseHeader->QTime;
        $s->resultCount = $response->response->numFound;
        $s->start = $response->response->start;

        foreach ( $response->response->docs as $document )
        {
            var_dump( $document );
        }

        return $s;
    }
}
