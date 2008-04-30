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
 * The struct contains the result as parsed by the different search handlers.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchResult
{
    /**
     * Search status.
     *
     * @var int
     */
    public $status;

    /**
     * Query time in milliseconds
     *
     * @var int
     */
    public $queryTime;

    /**
     * The number of results
     *
     * @var int
     */
    public $resultCount;

    /**
     * The index in the result, in case of paging
     *
     * @var int
     */
    public $start;

    /**
     * The found documents
     *
     * @var array(mixed)
     */
    public $documents;

    /**
     * An error message in case a search error occurred
     *
     * @var string
     */
    public $error;

    /**
     * Contructs a new ezcSearchResult.
     *
     * @param int $status
     * @param int $queryTime
     * @param int $resultCount
     * @param int $start
     * @param array $documents
     * @param string $error
     */
    public function __construct( $status =  0, $queryTime =  0, $resultCount =  0, $start =  0, $documents =  array(), $error =  '' )
    {
        $this->status = $status;
        $this->queryTime = $queryTime;
        $this->resultCount = $resultCount;
        $this->start = $start;
        $this->documents = $documents;
        $this->error = $error;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcSearchResult
     */
    static public function __set_state( array $array )
    {
        return new ezcSearchResult( $array['status'], $array['queryTime'], $array['resultCount'], $array['start'], $array['documents'], $array['error'] );
    }
}
